<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTvaIdToExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('tva_id')->nullable()->after('montant_ttc');

            $table->foreign('tva_id')
                  ->references('id')
                  ->on('tvas')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['tva_id']);
            $table->dropColumn('tva_id');
        });
    }
}