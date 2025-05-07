<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('universites', function (Blueprint $table) {
            $table->id()->primary();;
            $table->string('name');
            $table->string('acronym')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('universites');
    }
};
