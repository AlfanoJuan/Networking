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
        Schema::create('student_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interests');
            $table->foreign('interests')->references('id')->on('interests');
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
        Schema::table('student_interests', function(Blueprint $table)
        {
            $table->dropForeign('interests');
            $table->dropForeign('student');
        });
        Schema::dropIfExists('student_interests');
    }
};
