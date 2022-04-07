<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassWiseFeeCriteria extends Model
{
    use HasFactory;
    protected $table = 'classwisefeecriterias';
    public $timestamps = false;
}
