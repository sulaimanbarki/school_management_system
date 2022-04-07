<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addClass extends Model
{
    use HasFactory;
    //$table="configurations";
    protected $table = 'classes';
    public $timestamps = false;
    protected $fillable = [
        'C_id',
        'ClassName',
        'Campusid',
        'Isdisplay',
        'Sequence',
    ];
}
