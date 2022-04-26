<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Faculty_Attended extends Model
{
    protected $table='faculty_attended_activities';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
