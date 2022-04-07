<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceSalary extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $fillible = ['empid', 'debitamount', 'date', 'status'];
    protected $guarded = [];
}
