<?php

namespace App\Exports;

use App\Models\Revenue;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardSheet implements
    FromArray,
    WithTitle,
    WithStyles,
    WithEvents,
    WithCharts,
    WithColumnWidths
{
    protected $dateDebut;
    protected $dateFin;
    protected $libelle;

    protected $revenuTotal = 0;
    protected $depenseTotale = 0;
    protected $solde = 0;
    protected $tvaRevenu = 0;
    protected $tvaDepense = 0;
    protected $tvaNette = 0;
    protected $pourcentage = 0;
    protected $caisse = 0;
    protected $banque = 0;
    protected $totalTresorerie = 0;
    protected $is = 0;

    protected $dette = 0;
    protected $detteAPayer = 0;
    protected $detteEnRetard = 0;

    protected $creance = 0;
    protected $creanceAEncaisser = 0;
    protected $creanceEnRetard = 0;

    public function __construct(
        $dateDebut = null,
        $dateFin = null,
        $libelle = null
    ) {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->libelle = $libelle;
    }

    public function array(): array
    {
        $revenusQuery = Revenue::query();
        $depensesQuery = Expense::query();

        if ($this->dateDebut) {
            $revenusQuery->whereDate('date', '>=', $this->dateDebut);
            $depensesQuery->whereDate('date', '>=', $this->dateDebut);
        }

        if ($this->dateFin) {
            $revenusQuery->whereDate('date', '<=', $this->dateFin);
            $depensesQuery->whereDate('date', '<=', $this->dateFin);
        }

        if (!empty($this->libelle)) {
            $revenusQuery->where('libelle', 'like', '%' . $this->libelle . '%');
            $depensesQuery->where('libelle', 'like', '%' . $this->libelle . '%');
        }

        $this->revenuTotal = (clone $revenusQuery)->sum('montant_ttc');
        $this->depenseTotale = (clone $depensesQuery)->sum('montant_ttc');
        $this->solde = $this->revenuTotal - $this->depenseTotale;

        $this->tvaRevenu = (clone $revenusQuery)->sum('montant_tva');
        $this->tvaDepense = (clone $depensesQuery)->sum('montant_tva');
        $this->tvaNette = $this->tvaRevenu - $this->tvaDepense;

        $this->pourcentage = $this->revenuTotal > 0
            ? round(($this->depenseTotale / $this->revenuTotal) * 100, 2)
            : 0;

       // Encaissements (Revenue) vs Décaissements (Expense)
$caisseRevenus = (clone $revenusQuery)->where('mode_paiement', 'Espèce')->sum('montant_ttc');
$caisseDepenses = (clone $depensesQuery)->where('mode_paiement', 'Espèce')->sum('montant_ttc');

$banqueRevenus = (clone $revenusQuery)->whereIn('mode_paiement', ['Versement', 'Virement', 'Chèque'])->sum('montant_ttc');
$banqueDepenses = (clone $depensesQuery)->whereIn('mode_paiement', ['Versement', 'Virement', 'Chèque'])->sum('montant_ttc');

// Selon la règle de votre dashboard (ex. Revenus - Dépenses, ou somme brute) :
$this->caisse = $caisseRevenus - $caisseDepenses;
$this->banque = $banqueRevenus - $banqueDepenses;
$this->totalTresorerie = $this->caisse + $this->banque;

        // Suivi des dettes (adaptez les statuts / colonne date si nécessaire)
        $dettesBase = (clone $depensesQuery)->whereIn('statut', ['En attente', 'En retard']);
        $this->dette = (clone $dettesBase)->sum('montant_ttc');
        $this->detteEnRetard = (clone $dettesBase)
            ->where(function ($q) {
                $q->where('statut', 'En retard')
                  ->orWhereDate('date', '<', now()->toDateString());
            })
            ->sum('montant_ttc');
        $this->detteAPayer = max(0, $this->dette - $this->detteEnRetard);

        // Suivi des créances (adaptez les statuts / colonne date si nécessaire)
        $creancesBase = (clone $revenusQuery)->whereIn('statut', ['En attente', 'En retard']);
        $this->creance = (clone $creancesBase)->sum('montant_ttc');
        $this->creanceEnRetard = (clone $creancesBase)
            ->where(function ($q) {
                $q->where('statut', 'En retard')
                  ->orWhereDate('date', '<', now()->toDateString());
            })
            ->sum('montant_ttc');
        $this->creanceAEncaisser = max(0, $this->creance - $this->creanceEnRetard);

        return [
            // Ligne 1 : Grand Titre
            ['BUDGET SIMPLE'],

            // Ligne 2 : Libellé pourcentage
            ['POURCENTAGE DU REVENU DÉPENSÉ'],

            // Ligne 3 : Barre de progression verte + Valeur en F3
            ['', '', '', '', '', $this->pourcentage / 100],

            // Ligne 4 : Titres des blocs (Résumé A:E, Trésorerie G:I, Impôts K:M)
            ['RÉSUMÉ', '', '', '', '', '', 'Trésorerie', '', '', '', 'Impôts'],

            // Ligne 5 : Sous-en-têtes ligne 1
            ['Revenu total', 'Dépenses totales', 'Solde', 'TVA Revenus', 'TVA Dépenses', '', 'Caisse', 'Banque', 'Total tréso', '', 'IS', 'TVA Collectée', 'TVA Déductible'],

            // Ligne 6 : Valeurs ligne 1
            [$this->revenuTotal, $this->depenseTotale, $this->solde, $this->tvaRevenu, $this->tvaDepense, '', $this->caisse, $this->banque, $this->totalTresorerie, '', $this->is, $this->tvaRevenu, $this->tvaDepense],

            // Ligne 7 : Données graphique (col A/B) + Titres Suivi des dettes (G:I) et Suivi des créances (K:M)
            ['Revenus', $this->revenuTotal, '', '', '', '', 'Suivi des dettes', '', '', '', 'Suivi des créances'],

            // Ligne 8 : Données graphique (col A/B) + Sous-en-têtes Dettes & Créances
            ['Dépenses', $this->depenseTotale, '', '', '', '', 'Total dettes', 'À payer', 'En retard', '', 'Total créances', 'À encaisser', 'En retard'],

            // Ligne 9 : Valeurs Dettes & Créances
            ['', '', '', '', '', '', $this->dette, $this->detteAPayer, $this->detteEnRetard, '', $this->creance, $this->creanceAEncaisser, $this->creanceEnRetard],
        ];
    }

    public function title(): string
    {
        return 'Résumé';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 18,
            'C' => 16,
            'D' => 15,
            'E' => 15,
            'F' => 12, // Séparateur
            'G' => 15,
            'H' => 15,
            'I' => 16,
            'J' => 4,  // Séparateur
            'K' => 16,
            'L' => 16,
            'M' => 16,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '38761D']],
            ],
            2 => [
                'font' => ['bold' => true, 'color' => ['rgb' => '38761D'], 'size' => 10],
            ],
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => '38761D']],
            ],
            5 => [
                'font' => ['italic' => true, 'color' => ['rgb' => '38761D']],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Fusions pour les blocs principaux (Ligne 4)
                $sheet->mergeCells('A4:E4'); // Résumé
                $sheet->mergeCells('G4:I4'); // Trésorerie
                $sheet->mergeCells('K4:M4'); // Impôts

                // Fusions pour Suivi des dettes et Suivi des créances (Ligne 7)
                $sheet->mergeCells('G7:I7'); // Suivi des dettes
                $sheet->mergeCells('K7:M7'); // Suivi des créances

                // Hauteurs des lignes
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(28);
                $sheet->getRowDimension(4)->setRowHeight(22);
                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->getRowDimension(6)->setRowHeight(25);
                $sheet->getRowDimension(7)->setRowHeight(22);
                $sheet->getRowDimension(8)->setRowHeight(20);
                $sheet->getRowDimension(9)->setRowHeight(25);

                // Style de la barre de pourcentage (Ligne 3 de A à E)
                $sheet->getStyle('A3:E3')->getBorders()->getAllBorders()->setBorderStyle('thin');
                $sheet->getStyle('A3:E3')->getFill()->setFillType('solid')->getStartColor()->setRGB('38761D');
                $sheet->getStyle('F3')->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle('F3')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('38761D');

                // Formatage des montants du résumé (Ligne 6)
                $sheet->getStyle('A5:E5')->getBorders()->getBottom()->setBorderStyle('thin');
                $sheet->getStyle('A6:E6')->getNumberFormat()->setFormatCode('#,##0.00 "MAD"');

                $sheet->getStyle('A6')->getFont()->setBold(true)->getColor()->setRGB('38761D');
                $sheet->getStyle('B6')->getFont()->setBold(true)->getColor()->setRGB('C00060');
                $sheet->getStyle('C6')->getFont()->setBold(true)->getColor()->setRGB($this->solde >= 0 ? '38761D' : 'C00060');
                $sheet->getStyle('D6')->getFont()->setBold(true)->getColor()->setRGB('333333');
                $sheet->getStyle('E6')->getFont()->setBold(true)->getColor()->setRGB('333333');

                // Encadrements blocs Trésorerie (G4:I6) & Impôts (K4:M6)
                $sheet->getStyle('G4:I6')->getBorders()->getOutline()->setBorderStyle('thin');
                $sheet->getStyle('K4:M6')->getBorders()->getOutline()->setBorderStyle('thin');
                $sheet->getStyle('G6:I6')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('K6:M6')->getNumberFormat()->setFormatCode('#,##0.00');

                $sheet->getStyle('G4')->getFont()->setBold(true)->getColor()->setRGB('38761D');
                $sheet->getStyle('K4')->getFont()->setBold(true)->getColor()->setRGB('FF0000');

                // Encadrements & styles blocs Suivi des dettes (G7:I9) & Suivi des créances (K7:M9)
                $sheet->getStyle('G7:I9')->getBorders()->getOutline()->setBorderStyle('thin');
                $sheet->getStyle('K7:M9')->getBorders()->getOutline()->setBorderStyle('thin');

                $sheet->getStyle('G7')->getFont()->setBold(true)->getColor()->setRGB('C00060');
                $sheet->getStyle('K7')->getFont()->setBold(true)->getColor()->setRGB('1F4E78');

                $sheet->getStyle('G8:I8')->getFont()->setItalic(true)->getColor()->setRGB('C00060');
                $sheet->getStyle('K8:M8')->getFont()->setItalic(true)->getColor()->setRGB('1F4E78');

                $sheet->getStyle('G9:I9')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('K9:M9')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('G9')->getFont()->setBold(true)->getColor()->setRGB('C00060');
                $sheet->getStyle('I9')->getFont()->setBold(true)->getColor()->setRGB('FF0000');
                $sheet->getStyle('K9')->getFont()->setBold(true)->getColor()->setRGB('1F4E78');
                $sheet->getStyle('M9')->getFont()->setBold(true)->getColor()->setRGB('FF0000');

                // Vues et impressions
                $sheet->freezePane('A5');
                $sheet->getPageSetup()->setOrientation('landscape')->setFitToWidth(1)->setFitToHeight(1);
                $sheet->getSheetView()->setZoomScale(90);
            },
        ];
    }

    public function charts()
    {
        $labels = [
            new DataSeriesValues(
                'String',
                "'Résumé'!\$A\$7:\$A\$8",
                null,
                2
            ),
        ];

        $values = [
            new DataSeriesValues(
                'Number',
                "'Résumé'!\$B\$7:\$B\$8",
                null,
                2
            ),
        ];

        $colors = ['38761D', 'C00060'];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($values) - 1),
            [],
            $labels,
            $values,
            null,
            null,
            DataSeries::DIRECTION_COL,
            false,
            $colors
        );

        $layout = new Layout();
        $layout->setShowVal(true);

        $plotArea = new PlotArea(
            $layout,
            [$series]
        );

        $legend = new Legend(
            Legend::POSITION_BOTTOM,
            null,
            false
        );

        $title = new Title(
            'Revenus / Dépenses'
        );

        $chart = new Chart(
            'revenus_depenses',
            $title,
            $legend,
            $plotArea
        );

        // Positionnement propre du diagramme en dessous des tableaux
        $chart->setTopLeftPosition('A11');
        $chart->setBottomRightPosition('H27');
        $chart->setDisplayBlanksAs('zero');

        return [$chart];
    }
}