<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('definitions', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('word_id');
            $table->string('definition');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('word_id')->references('id')->on('words');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('definitions');
    }
}
