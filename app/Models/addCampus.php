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
        return $this->getFirstMediaUrl('campus_logo')
            ?: ($this->Logo_photo_path ? asset('CampusLogos/' . $this->Logo_photo_path) : asset('userbackend/dist/img/AdminLTELogo.png'));
    }

    public function getBankLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('bank_logo')
            ?: ($this->banklogo ? asset('banklogo/' . $this->banklogo) : null);
    }
}
