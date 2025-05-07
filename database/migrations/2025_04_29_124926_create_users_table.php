<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->primary();;
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['PER', 'PATS']);
            $table->foreignId('grades_id')->nullable()->constrained('grades');
            $table->foreignId('departements_id')->nullable()->constrained('departements');
            $table->foreignId('ufrs_id')->nullable()->constrained('ufrs');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
