<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_notifications', function (Blueprint $table) {
             $table->increments('sr_no');
            $table->string('from_faculty',7);
            //$table->foreign('from_faculty')->references('faculty_id')->on('faculties');
            $table->string('to_faculty',7);
           // $table->foreign('to_faculty')->references('faculty_id')->on('faculties');
            $table->string('organized_activity_no',10);
            //$table->foreign('organized_activity_no')->references('sr_no')->on(' faculty_organized_activities');
            $table->string('description',100);
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
        Schema::dropIfExists('faculty_notifications');
    }
}
