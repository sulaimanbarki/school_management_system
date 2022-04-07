<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermName extends Model
{
    use HasFactory;

    protected $table = 'termnames';
    public $timestamps = false;
}
