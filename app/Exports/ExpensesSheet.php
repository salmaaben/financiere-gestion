<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExpensesSheet implements FromCollection, WithHeadings, WithTitle
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
     * Récupérer les dépenses.
     */
    public function collection()
    {
        $query = Expense::query();

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
                'type',
                'fournisseur',
                'categorie',
                'libelle',
                'date',
                'date_echeance',
                'date_valeur',
                'montant_ttc',
                'montant_tva',
                'devise',
                'statut',
                'mode_paiement',
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
            'Type',
            'Fournisseur',
            'Catégorie',
            'Libellé',
            'Date',
            'Date échéance',
            'Date valeur',
            'Montant TTC',
            'Montant TVA',
            'Devise',
            'Statut',
            'Mode paiement',
            'Commentaire',
        ];
    }

    /**
     * Nom de la feuille Excel.
     */
    public function title(): string
    {
        return 'Dépenses';
    }
}