<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassWiseSection extends Model
{
    use HasFactory;
    protected $table = 'classwisesection';
    public $timestamps = false;
    protected $fillable = [
        'ClassID',
        'SectionID',
        'Sequence',
        'isDisplay',
        'campusid',
        'Date',
    ];
}
