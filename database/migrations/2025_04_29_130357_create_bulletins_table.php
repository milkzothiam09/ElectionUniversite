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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('elections_id')->constrained('elections')->cascadeOnDelete();
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete();
            $table->enum('choix', ['pour', 'null'])->default('pour');
            $table->dateTime('date_vote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
};
