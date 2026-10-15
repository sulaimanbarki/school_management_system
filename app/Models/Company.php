<?php

namespace App\Models;

use App\Traits\HasMediaUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaUploads;

    protected $guarded = []; 

    protected $appends = [
        'logo_url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->useDisk('public');
    }

    public function getLogoUrlAttribute(): ?string
    {
        try {
            $mediaUrl = $this->getFirstMediaUrl('logo');
            if (!empty($mediaUrl)) {
                return $mediaUrl;
            }
        } catch (\Throwable $e) {
            // Gracefully fallback to legacy column if media table is not yet migrated
        }

        return $this->logo ? asset('companylogo/' . $this->logo) : null;
    }
}
