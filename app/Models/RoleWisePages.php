<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleWisePages extends Model
{
    use HasFactory;
    protected $table = 'role_pages';
    protected $primaryKey = 'role_page_id';
    public $timestamps = false;
    protected $fillable = [
        'role_id',
        'pages_id',
        'campusid'
    ];
}
