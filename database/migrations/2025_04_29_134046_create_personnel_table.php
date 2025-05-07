<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('motDePasse');
            $table->enum('type', ['PER', 'PATS']);
            $table->foreignId('grades_id')->nullable()->constrained('grades');
            $table->foreignId('departements_id')->constrained('departements');
            $table->foreignId('ufrs_id')->constrained('ufrs');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personnel');
    }
};