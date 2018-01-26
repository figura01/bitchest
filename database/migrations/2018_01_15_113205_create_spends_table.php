<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spends', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('crypto_id');
            $table->unsignedInteger('coursmonnaie_id');
            $table->date('date_achat');
            $table->decimal('quantité', 8, 2);
            $table->decimal('valeur_euros', 8, 2);
            $table->boolean('active');
            $table->foreign('coursmonnaie_id')->references('id')->on('coursmonnaie');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('spends');
    }
}
