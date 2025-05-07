<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id()->primary();;
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('elections_id')->constrained('elections');
            $table->enum('status', ['en attente', 'approuvé', 'rejeté'])->default('en attente');
            $table->text('motivation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidats');
    }
};
