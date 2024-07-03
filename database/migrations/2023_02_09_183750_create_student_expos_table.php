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
        Schema::create('student_expos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expo');
            $table->foreign('expo')->references('id')->on('expos');
            $table->unsignedBigInteger('student');
            $table->foreign('student')->references('id')->on('students');
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
        Schema::table('student_expos', function(Blueprint $table)
        {
            $table->dropForeign('expo');
            $table->dropForeign('student');
        });
        Schema::dropIfExists('student_expos');
    }
};
