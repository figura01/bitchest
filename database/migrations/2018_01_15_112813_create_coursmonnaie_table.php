<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursMonnaieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursmonnaie', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crypto_id');
            $table->date('date');
            $table->decimal('taux', 8, 2);
            $table->foreign('crypto_id')->references('id')->on('crypto');
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
        Schema::dropIfExists('Coursmonnaie');
    }
}
