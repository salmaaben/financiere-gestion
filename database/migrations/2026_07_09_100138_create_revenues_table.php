<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('numero_piece');
            $table->string('type_piece');
            $table->decimal('montant_ttc', 10, 2);
            $table->string('statut');
            $table->string('client');
            $table->string('categorie');
            $table->string('libelle');
            $table->date('date');
            $table->decimal('montant_tva', 10, 2)->nullable();
            $table->string('devise');
            $table->text('commentaire')->nullable();
            $table->string('lien_justificatif')->nullable();
            $table->date('date_echeance')->nullable();
            $table->date('date_valeur')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->integer('nombre_nuitees')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenues');
    }
};