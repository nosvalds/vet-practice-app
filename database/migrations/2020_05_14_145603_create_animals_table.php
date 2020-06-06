<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->date("date_of_birth");
            $table->string('type',100);
            $table->float('weight');
            $table->float('height');
            $table->integer('biteyness');
            $table->foreignId('owner_id')->unsigned();
            $table->foreign("owner_id")->references("id")->on("owners")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
