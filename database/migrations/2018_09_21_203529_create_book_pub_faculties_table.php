<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookPubFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_pub_faculties', function (Blueprint $table) 
        {
            $table->increments('f_book_id');
            $table->string('ISBN',20);
            $table->string('faculty_id',7);
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties');
            $table->string('book_name',100);
            $table->string('authors',100);
            $table->string('publication_house',100);
            $table->string('publication_month',2);
            $table->year('publication_year');
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
        Schema::dropIfExists('book_pub_faculties');
    }
}
