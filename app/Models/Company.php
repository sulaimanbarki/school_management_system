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
        return $this->getFirstMediaUrl('logo')
            ?: ($this->logo ? asset('companylogo/' . $this->logo) : null);
    }
}
