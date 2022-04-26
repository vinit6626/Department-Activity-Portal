<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounselorStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counselor_students', function (Blueprint $table){
            $table->increments('sr_no');
            $table->string('faculty_id',7);
            $table->string('student_id',7);
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->tinyInteger('status')->default(1);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counselor_students');
    }
}
