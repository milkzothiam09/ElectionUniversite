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
        Schema::create('proces_verbaux', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('elections_id')->constrained('elections')->cascadeOnDelete();
            $table->text('contenu');
            $table->dateTime('date_generation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proces_verbaux');
    }
};
