<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Student_Published_Paper extends Model
{
    protected $table='paper_pub_students';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
