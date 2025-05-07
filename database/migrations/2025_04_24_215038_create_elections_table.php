<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id()->primary();;
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['chef_departement', 'directeur_ufr', 'vice_recteur']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('candidature_start');
            $table->dateTime('candidature_end');
            $table->enum('status', ['preparation', 'candidature', 'voting', 'closed']);
            $table->foreignId('departements_id')->nullable()->constrained('departements');
            $table->foreignId('ufrs_id')->nullable()->constrained('ufrs');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elections');
    }
};
