<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_year', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classroom_id');
            $table->unsignedInteger('year_id');
            $table->timestamps();

            $table->foreign('classroom_id')->references('id')
                ->on('classrooms');
            $table->foreign('year_id')->references('id')
                ->on('years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_year');
    }
}
