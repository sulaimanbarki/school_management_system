<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class academicsessions extends Model
{
    use HasFactory;
    protected $table = 'academicsessions';
    public $timestamps = false;

    // protected $fillable = [
    //     'Session',
    //     'CampusID',
    //     'SessionType',
    //     'StartDate',
    //     'EndDate',
    //     'IsActive',
    //     'IsCurrent',
    // ];
}
