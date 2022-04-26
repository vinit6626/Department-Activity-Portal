<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperPubStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_pub_students', function (Blueprint $table) {
            $table->increments('s_paper_id');
            $table->string('student_id',7);
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->string('ISSN',10)->nullable();
            $table->string('ISBN',20)->nullable();
            $table->string('DOI_number',100)->nullable();
            $table->string('paper_title',500)->nullable();
            $table->string('conference_name',100)->nullable();
            $table->string('journal_name',100)->nullable();
            $table->string('paper_type',100)->nullable();
            $table->tinyInteger('published_or_presented')->default(0);
            $table->string('volume_and_issue',10)->nullable();
            $table->string('page_num',10)->nullable();
            $table->string('impact_factor',10)->nullable();
            $table->string('publication_month',2);
            $table->year('publication_year');
            $table->string('academic_year',100);
            $table->string('academic_semester',10);
            $table->string('file',100)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_pub_students');
    }
}
