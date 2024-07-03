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
        Schema::create('company_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interests');
            $table->foreign('interests')->references('id')->on('interests');
            $table->unsignedBigInteger('company');
            $table->foreign('company')->references('id')->on('companies');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_interests', function(Blueprint $table)
        {
            $table->dropForeign('interests');
            $table->dropForeign('company');
        });
        Schema::dropIfExists('company_interests');
    }
};
