<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $table='counselor_students';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
