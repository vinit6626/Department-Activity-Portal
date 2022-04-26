<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student_Results extends Model
{
    protected $table='student_results';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
