<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'designations';
    protected $fillable = [
        'name',
        'bps',
        'isactive',
        'sequence'
    ];
}
