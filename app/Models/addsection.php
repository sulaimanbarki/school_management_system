<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addsection extends Model
{
    protected $table = "sections";
    protected $primaryKey = 'Sec_ID';
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'Sec_ID',
        'SectionName',
        'SectionSequence',
        'campusid'
    ];
}
