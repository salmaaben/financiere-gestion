<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {

            $table->id();

            // Informations générales
            $table->string('numero_piece');
            $table->string('type');
            $table->string('mode_paiement');

            // Montants
            $table->decimal('montant_ttc', 15, 2);
            $table->decimal('montant_tva', 15, 2)->nullable();

            // Statut
            $table->string('statut');

            // Fournisseur
            $table->string('fournisseur');

            // Catégorie et libellé
            $table->string('categorie');
            $table->string('libelle');

            // Dates
            $table->date('date');
            $table->date('date_echeance')->nullable();
            $table->date('date_valeur')->nullable();

            // Devise
            $table->string('devise')->default('MAD');

            // Commentaire
            $table->text('commentaire')->nullable();

            // Justificatifs
            $table->string('lien_justificatif')->nullable();
            $table->string('lien_justificatif_comptable')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};