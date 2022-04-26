<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->string('student_id',7);
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->string('spi_sem1',5)->nullable();
            $table->string('cpi_sem1',5)->nullable();
            $table->string('spi_sem2',5)->nullable();
            $table->string('cpi_sem2',5)->nullable();
            $table->string('spi_sem3',5)->nullable();
            $table->string('cpi_sem3',5)->nullable();
            $table->string('spi_sem4',5)->nullable();
            $table->string('cpi_sem4',5)->nullable();
            $table->string('spi_sem5',5)->nullable();
            $table->string('cpi_sem5',5)->nullable();
            $table->string('spi_sem6',5)->nullable();
            $table->string('cpi_sem6',5)->nullable();
            $table->string('spi_sem7',5)->nullable();
            $table->string('cpi_sem7',5)->nullable();
            $table->string('spi_sem8',5)->nullable();
            $table->string('cpi_sem8',5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_results');
    }
}
