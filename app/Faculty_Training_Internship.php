<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Faculty_Training_Internship extends Model
{
    protected $table='training_internship_faculties';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
