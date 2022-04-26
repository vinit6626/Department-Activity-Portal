<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingInternshipStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_internship_students', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->string('student_id',7);
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->string('training_or_internship',10);
            $table->string('title',100);
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
        Schema::dropIfExists('training_internship_students');
    }
}
