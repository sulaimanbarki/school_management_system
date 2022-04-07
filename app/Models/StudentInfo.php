<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;
    protected $table = 'studentinfo';
    public $timestamps = false;
    protected $fillable = [
        'formid',
        'studentid',
        'registrationid',
        'date',
        'session',
        'studentname',
        'profilepicture',
        'gender',
        'status',
        'dob',
        'transportstatus',
        'busnumber',
        'admissioninclass',
        'admissioninsection',
        'address1',
        'address2',
        'fathername',
        'cnic',
        'formb',
        'occupation',
        'fathercontact',
        'contact1',
        'contactwhatsapp',
        'picturepath',
        'admissionremarks',
        'campusid',
    ];
}
