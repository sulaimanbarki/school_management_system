<?php

namespace App\Models;

use App\Traits\HasMediaUploads;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasMediaUploads;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $guard_name = 'admin';

    protected $table = 'admins';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fname',
        'cnic',
        'gender',
        'email',
        'password',
        'phone1',
        'phone2',
        'address1',
        'address2',
        'joindate',
        'profile_photo_path',
        'campusid',
        'busnumber',
        'roleid',
        'departmentid',
        'scaleid',
        'isactive',
        'fixedsalary',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile()
            ->useDisk('public');
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        try {
            $mediaUrl = $this->getFirstMediaUrl('profile_picture');
            if (!empty($mediaUrl)) {
                return $mediaUrl;
            }
        } catch (\Throwable $e) {
            // Gracefully fallback to legacy column if media table is not yet migrated
        }

        return $this->profile_photo_path ? asset('profilepicture/' . $this->profile_photo_path) : asset('userbackend/dist/img/AdminLTELogo.png');
    }

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function campus()
    {
        return $this->belongsTo(addCampus::class, 'campusid', 'campusid');
    }
}
