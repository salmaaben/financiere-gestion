<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenues';

    protected $fillable = [
        'numero_piece',
        'type_piece',
        'montant_ttc',
        'tva_id',
        'montant_tva',
        'devise',
        'statut',
        'client',
        'categorie',
        'libelle',
        'mode_paiement',
        'date',
        'date_echeance',
        'date_valeur',
        'commentaire',
        'lien_justificatif',
        'check_in',
        'check_out',
        'nombre_nuitees',
    ];

    public function tva()
    {
        return $this->belongsTo(Tva::class, 'tva_id');
    }
}
