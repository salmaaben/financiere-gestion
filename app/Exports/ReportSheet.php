<?php

namespace App\Exports;

use App\Models\Revenue;
use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportSheet implements FromArray, WithTitle, WithStyles
{
    protected $dateDebut;
    protected $dateFin;
    protected $libelle;

    public function __construct($dateDebut = null, $dateFin = null, $libelle = null)
    {
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

        $revenuTotal = $revenusQuery->sum('montant_ttc');

        $depenseTotale = $depensesQuery->sum('montant_ttc');

        $solde = $revenuTotal - $depenseTotale;

        $tvaRevenus = (clone $revenusQuery)->sum('montant_tva');
        $tvaDepenses = (clone $depensesQuery)->sum('montant_tva');

        $tva = $tvaRevenus + $tvaDepenses;

        $pourcentage = $revenuTotal > 0
            ? round(($depenseTotale / $revenuTotal) * 100, 2)
            : 0;

        $reservations = (clone $revenusQuery)
            ->whereNotNull('client')
            ->get([
                'nombre_nuitees',
                'check_in',
                'check_out',
            ]);

        $totalNuitees = $reservations->sum(function ($reservation) {
            return (int) ($reservation->nombre_nuitees ?? 0);
        });

        $tauxOccupation = 0;

        if ($this->dateDebut && $this->dateFin) {

            $debut = Carbon::parse($this->dateDebut);
            $fin = Carbon::parse($this->dateFin);

            $nombreJours = $debut->diffInDays($fin) + 1;

            if ($nombreJours > 0) {
                $tauxOccupation = round(
                    ($totalNuitees / $nombreJours) * 100,
                    2
                );
            }
        }

        return [
            ['RAPPORT FINANCIER MY STAY'],
            [],
            ['Période', $this->dateDebut . ' au ' . $this->dateFin],
            ['Libellé', $this->libelle],
            [],
            ['INDICATEUR', 'VALEUR'],
            ['Revenus', $revenuTotal],
            ['Dépenses', $depenseTotale],
            ['TVA', $tva],
            ['Solde', $solde],
            ['Revenus dépensés (%)', $pourcentage],
            ['Nombre de nuitées', $totalNuitees],
            ['Taux d’occupation (%)', $tauxOccupation],
        ];
    }

    public function title(): string
    {
        return 'Rapport financier';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
            ],

            6 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}