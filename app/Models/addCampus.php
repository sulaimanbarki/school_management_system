<?php

namespace App\Models;

use App\Traits\HasMediaUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class addCampus extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaUploads;

    //$table="configurations";
    protected $table = 'configurations';
    public $timestamps = false;
    protected $primaryKey = 'campusid';
    protected $guarded = [];

    protected $appends = [
        'logo_photo_url',
        'bank_logo_url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('campus_logo')
            ->singleFile()
            ->useDisk('public');

        $this->addMediaCollection('bank_logo')
            ->singleFile()
            ->useDisk('public');
    }

    public function getLogoPhotoUrlAttribute(): string
    {
        try {
            $mediaUrl = $this->getFirstMediaUrl('campus_logo');
            if (!empty($mediaUrl)) {
                return $mediaUrl;
            }
        } catch (\Throwable $e) {
            // Gracefully fallback to legacy column if media table is not yet migrated
        }

        return $this->Logo_photo_path ? asset('CampusLogos/' . $this->Logo_photo_path) : asset('userbackend/dist/img/AdminLTELogo.png');
    }

    public function getBankLogoUrlAttribute(): ?string
    {
        try {
            $mediaUrl = $this->getFirstMediaUrl('bank_logo');
            if (!empty($mediaUrl)) {
                return $mediaUrl;
            }
        } catch (\Throwable $e) {
            // Gracefully fallback to legacy column if media table is not yet migrated
        }

        return $this->banklogo ? asset('banklogo/' . $this->banklogo) : null;
    }
}
