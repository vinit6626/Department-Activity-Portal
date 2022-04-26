<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyAttendedActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_attended_activities', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->string('faculty_id',7);
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties');
            $table->string('type',40);
            $table->string('topic',100);
            $table->string('place',100);
            $table->date('from_date');
            $table->date('to_date');
            $table->string('file',100)->nullable();
            $table->string('academic_year',100);
            $table->string('academic_semester',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_attended_activities');
    }
}
