<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_networks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company');
            $table->foreign('company')->references('id')->on('companies');
            $table->enum('red', ['linkedin', 'instagram', 'facebook', 'artstation']);
            $table->string('link');
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
        Schema::dropIfExists('company_networks');
    }
};
