<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student_Training_Internship extends Model
{
    protected $table='training_internship_students';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
