<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        'RoleId',
        'Role',
        'CampusID',
        'IsActive',
        'Sequence',
    ];

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class);
    // }
}
