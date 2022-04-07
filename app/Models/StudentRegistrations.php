<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistrations extends Model
{
    use HasFactory;
    protected $table = 'studentregistrations';
    public $timestamps = false;
    protected $fillable = [
        'formid',
        'studentname',
        'fname',
        'contact',
        'admissioninclass',
        'date',
        'academicsession',
        'campusid',
    ];
}
