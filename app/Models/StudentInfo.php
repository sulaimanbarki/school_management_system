<?php

namespace App\Models;

use App\Traits\HasMediaUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class StudentInfo extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaUploads;

    protected $table = 'studentinfo';
    public $timestamps = false;
    protected $fillable = [
        'formid',
        'studentid',
        'registrationid',
        'date',
        'session',
        'studentname',
        'profilepicture',
        'gender',
        'status',
        'dob',
        'transportstatus',
        'busnumber',
        'admissioninclass',
        'admissioninsection',
        'address1',
        'address2',
        'fathername',
        'cnic',
        'formb',
        'occupation',
        'fathercontact',
        'contact1',
        'contactwhatsapp',
        'picturepath',
        'admissionremarks',
        'campusid',
    ];

    protected $appends = [
        'picture_url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile()
            ->useDisk('public');
    }

    public function getPictureUrlAttribute(): string
    {
        try {
            $mediaUrl = $this->getFirstMediaUrl('profile_picture');
            if (!empty($mediaUrl)) {
                return $mediaUrl;
            }
        } catch (\Throwable $e) {
            // Gracefully fallback to legacy column if media table is not yet migrated
        }

        return $this->picturepath ? asset('studentprofilepicture/' . $this->picturepath) : asset('userbackend/dist/img/AdminLTELogo.png');
    }
}
