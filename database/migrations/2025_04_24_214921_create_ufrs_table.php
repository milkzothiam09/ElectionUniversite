<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ufrs', function (Blueprint $table) {
            $table->id()->primary();;
            $table->string('name');
            $table->foreignId('universites_id')->constrained('universites');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ufrs');
    }
};
