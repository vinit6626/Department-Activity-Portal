<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRDFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_d_faculties', function (Blueprint $table) {
            $table->increments('sr_no');
            $table->string('faculty_id',7);
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties');
            $table->string('description',500);
            $table->string('approval_letter_no',20);
            $table->string('funding_agency',100);
            $table->string('amount',10);
            $table->string('PI',100);
            $table->string('CI',100);
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
        Schema::dropIfExists('r_d_faculties');
    }
}
