<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_piece',
        'type',
        'mode_paiement',
        'montant_ttc',
        'statut',
        'fournisseur',
        'categorie',
        'libelle',
        'date',
        'tva_id',
        'montant_tva',
        'devise',
        'commentaire',
        'lien_justificatif',
        'date_echeance',
        'date_valeur',
        'lien_justificatif_comptable',
    ];

    // Relation avec la TVA
    public function tva()
    {
        return $this->belongsTo(Tva::class, 'tva_id');
    }
}