<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersStudentsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_students_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('year_id');
            $table->unsignedInteger('classroom_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users');
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
        Schema::dropIfExists('users_students_details');
    }
}
