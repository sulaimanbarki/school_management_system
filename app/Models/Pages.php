<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    protected $table = "pages";
    public $timestamps = false;
    protected $fillable = [
        'page_head',
        'page_title',
        'page_link',
        'page_type',
        'icon_id',
        'page_order',
        'campusid'
    ];
}
