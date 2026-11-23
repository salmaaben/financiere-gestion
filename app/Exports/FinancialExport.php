<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinancialExport implements WithMultipleSheets
{
    protected $dateDebut;
    protected $dateFin;
    protected $libelle;

    public function __construct(
        $dateDebut = null,
        $dateFin = null,
        $libelle = null
    ) {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->libelle = $libelle;
    }

    public function sheets(): array
    {
        return [
            new DashboardSheet(
                $this->dateDebut,
                $this->dateFin,
                $this->libelle
            ),

            new RevenuesSheet(
                $this->dateDebut,
                $this->dateFin,
                $this->libelle
            ),

            new ExpensesSheet(
                $this->dateDebut,
                $this->dateFin,
                $this->libelle
            ),
        ];
    }
}
