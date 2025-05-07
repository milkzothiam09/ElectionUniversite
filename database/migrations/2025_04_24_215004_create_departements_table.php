<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->id()->primary();;
            $table->string('name');
            $table->foreignId('ufrs_id')->constrained('ufrs');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departements');
    }
};
