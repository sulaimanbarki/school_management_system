<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['sub_category_name', 'company_id', 'main_category_id', 'date', 'isdisplay', 'sequence', 'campusid'];
}
