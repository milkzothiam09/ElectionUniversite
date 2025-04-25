<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['chef_departement', 'directeur_ufr', 'vice_recteur']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('candidature_start');
            $table->dateTime('candidature_end');
            $table->enum('status', ['preparation', 'candidature', 'voting', 'closed']);
            $table->foreignId('departement_id')->nullable()->constrained();
            $table->foreignId('ufr_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elections');
    }
};
