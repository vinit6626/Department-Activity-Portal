<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Faculty_Organized extends Model
{
    protected $table='faculty_organized_activities';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
