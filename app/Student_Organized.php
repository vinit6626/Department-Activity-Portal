<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student_Organized extends Model
{
    protected $table='student_organized_activities';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
?>