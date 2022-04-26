<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Faculty_Published_Book extends Model
{
    protected $table='book_pub_faculties';
    protected $primaryKey = 'sr_no';
    public $timestamps = false;
}
