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
    protected $dette = 0;
    protected $totalTresorerie = 0;
    protected $is = 0;

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

        $this->caisse = (clone $depensesQuery)->where('mode_paiement', 'Espèces')->sum('montant_ttc');
        $this->banque = (clone $depensesQuery)->whereIn('mode_paiement', ['Carte bancaire', 'Virement', 'Chèque'])->sum('montant_ttc');
        $this->dette = (clone $depensesQuery)->where('statut', 'En attente')->sum('montant_ttc');
        $this->totalTresorerie = $this->caisse + $this->banque - $this->dette;

        $this->is = $this->solde < 0 ? $this->solde : 0;

        return [
            // Ligne 1 : Grand Titre
            ['BUDGET SIMPLE'],

            // Ligne 2 : Libellé pourcentage
            ['POURCENTAGE DU REVENU DÉPENSÉ'],

            // Ligne 3 : Barre de progression verte + Valeur en F3
            ['', '', '', '', '', $this->pourcentage / 100],

            // Ligne 4 : Titre Résumé & Blocs Trésorerie / Impôt
            ['RÉSUMÉ', '', '', '', '', '', 'Trésorerie', '', '', '', '', 'Impôts'],

            // Ligne 5 : En-têtes du tableau Résumé et sous-colonnes Trésorerie/Impôts
            ['Revenu total', 'Dépenses totales', 'Solde', 'TVA Revenus', 'TVA Dépenses', '', 'Caisse', 'Banque', 'Dette', 'Total tréso', '', 'IS', 'TVA Collectée', 'TVA Déductible'],

            // Ligne 6 : Valeurs respectives
            [$this->revenuTotal, $this->depenseTotale, $this->solde, $this->tvaRevenu, $this->tvaDepense, '', $this->caisse, $this->banque, $this->dette, $this->totalTresorerie, '', $this->is, $this->tvaRevenu, $this->tvaDepense],

            // Lignes pour alimenter le graphique proprement
            ['Revenus', $this->revenuTotal],
            ['Dépenses', $this->depenseTotale],
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
            'F' => 12,  // Séparateur
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 14,
            'K' => 4,  // Séparateur
            'L' => 12,
            'M' => 16,
            'N' => 16,
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

                // Fusions pour les blocs de résumé, trésorerie et d'impôts
                $sheet->mergeCells('A4:E4'); // Résumé
                $sheet->mergeCells('G4:J4'); // Trésorerie
                $sheet->mergeCells('L4:N4'); // Impôts (étendu sur 3 colonnes: IS, TVA Collectée, TVA Déductible)

                // Hauteurs des lignes
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(28);
                $sheet->getRowDimension(4)->setRowHeight(22);
                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->getRowDimension(6)->setRowHeight(25);

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

                // Encadrements blocs Trésorerie & Impôts
                $sheet->getStyle('G4:J6')->getBorders()->getOutline()->setBorderStyle('thin');
                $sheet->getStyle('L4:N6')->getBorders()->getOutline()->setBorderStyle('thin');
                $sheet->getStyle('G6:J6')->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('L6:N6')->getNumberFormat()->setFormatCode('#,##0.00');
                
                $sheet->getStyle('G4')->getFont()->setBold(true)->getColor()->setRGB('38761D');
                $sheet->getStyle('L4')->getFont()->setBold(true)->getColor()->setRGB('FF0000');

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
        $chart->setTopLeftPosition('A10');
        $chart->setBottomRightPosition('H26');
        $chart->setDisplayBlanksAs('zero');

        return [$chart];
    }
}