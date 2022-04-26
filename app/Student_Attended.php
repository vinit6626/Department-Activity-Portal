<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student_Attended extends Model
{
    protected $table='student_attended_activities';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
