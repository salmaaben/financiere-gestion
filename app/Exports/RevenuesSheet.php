<?php

namespace App\Exports;

use App\Models\Revenue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenuesSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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

    /**
     * Récupérer les revenus avec les informations de réservation.
     */
    public function collection()
    {
        $query = Revenue::query();

        // Filtre date début
        if ($this->dateDebut) {
            $query->whereDate('date', '>=', $this->dateDebut);
        }

        // Filtre date fin
        if ($this->dateFin) {
            $query->whereDate('date', '<=', $this->dateFin);
        }

        // Filtre libellé
        if (!empty($this->libelle)) {
            $query->where('libelle', 'like', '%' . $this->libelle . '%');
        }

        return $query
            ->orderBy('date')
            ->get([
                'numero_piece',
                'type_piece',
                'client',
                'categorie',
                'libelle',
                'date',
                'date_echeance',
                'date_valeur',
                'montant_ttc',
                'montant_tva',
                'devise',
                'statut',

                // Informations de réservation
                'check_in',
                'check_out',
                'nombre_nuitees',

                'commentaire',
            ]);
    }

    /**
     * En-têtes de la feuille Excel.
     */
    public function headings(): array
    {
        return [
            'N° pièce',
            'Type pièce',
            'Client',
            'Catégorie',
            'Libellé',
            'Date',
            'Date échéance',
            'Date valeur',
            'Montant TTC',
            'Montant TVA',
            'Devise',
            'Statut',

            // Informations de réservation
            'Check-in',
            'Check-out',
            'Nombre de nuitées',

            'Commentaire',
        ];
    }

    /**
     * Nom de la feuille Excel.
     */
    public function title(): string
    {
        return 'Revenus';
    }

    /**
     * Style de la feuille.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}