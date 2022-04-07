<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    protected $table = 'icons';
    public $timestamps = false;
    protected $fillable = [
        'icon_name',
        'icon_fa',
        'icon_code',
        'campusid',
    ];
}
