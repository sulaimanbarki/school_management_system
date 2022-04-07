<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addCampus extends Model
{
    use HasFactory;
    //$table="configurations";
    protected $table = 'configurations';
    public $timestamps = false;
    protected $primaryKey = 'campusid';
}
