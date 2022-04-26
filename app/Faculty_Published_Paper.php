<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Faculty_Published_Paper extends Model
{
    protected $table='paper_pub_faculties';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
