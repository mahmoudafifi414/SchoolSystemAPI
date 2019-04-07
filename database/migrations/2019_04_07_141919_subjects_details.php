<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubjectsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('year_id');
            $table->unsignedInteger('classroom_id');
            $table->timestamps();

            $table->foreign('subject_id')->references('id')
                ->on('subjects');
            $table->foreign('year_id')->references('id')
                ->on('years');
            $table->foreign('classroom_id')->references('id')
                ->on('classrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects_details');
    }
}
