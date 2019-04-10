<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_semester', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id')->unsigned()->nullable();
            $table->integer('semester_id')->unsigned()->nullable();
            $table->foreign('year_id')->references('id')
                ->on('years')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')
                ->on('semesters')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('year_semester');
    }
}
