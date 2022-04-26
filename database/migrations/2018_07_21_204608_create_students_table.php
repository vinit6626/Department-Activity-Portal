<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id',7)->primary();
            $table->string('name',50);
            $table->string('email',40)->unique();
            $table->string('enrollment_no',15)->nullable();
            $table->string('contact_no',10)->unique();
            $table->year('admission_year');
            $table->string('department',30);
            $table->string('admission_type',10);
            $table->string('profile_image',100)->nullable();
            $table->string('password');
            $table->tinyInteger('is_verified')->default(0);
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
        Schema::dropIfExists('students');
    }
}
