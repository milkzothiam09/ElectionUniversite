<?php



use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;



return new class extends Migration

{

    public function up()

    {

        Schema::create('votes', function (Blueprint $table) {

            $table->id()->primary();;

            $table->foreignId('elections_id')->constrained('elections');

            $table->foreignId('candidats_id')->nullable()->constrained('candidats');

            $table->string('voter_hash');

            $table->boolean('is_null')->default(false);

            $table->timestamps();

        });

    }



    public function down()

    {

        Schema::dropIfExists('votes');

    }

};