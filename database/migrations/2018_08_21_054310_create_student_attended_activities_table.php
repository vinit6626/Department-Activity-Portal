<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAttendedActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attended_activities', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->string('student_id',7);
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->string('type',40);
            $table->string('topic',100);
            $table->string('place',100);
            $table->date('from_date');
            $table->date('to_date');
            $table->string('file',100);
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
        Schema::dropIfExists('student_attended_activities');
    }
}
