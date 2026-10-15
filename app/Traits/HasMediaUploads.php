<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaUploads
{
    use InteractsWithMedia;

    /**
     * Upload and attach media from request or UploadedFile, and optionally sync a database column.
     *
     * @param string|UploadedFile $fileOrKey  Form input name (e.g. 'profilepicture') or UploadedFile instance
     * @param string $collection              Spatie media collection name (e.g. 'profile_picture')
     * @param string|null $syncColumn         Optional column to update with file_name (e.g. 'picturepath')
     * @return Media|null
     */
    public function uploadMedia(string|UploadedFile $fileOrKey, string $collection, ?string $syncColumn = null): ?Media
    {
        $fileAdder = null;

        if ($fileOrKey instanceof UploadedFile) {
            $fileAdder = $this->addMedia($fileOrKey);
        } elseif (is_string($fileOrKey) && request()->hasFile($fileOrKey)) {
            $fileAdder = $this->addMediaFromRequest($fileOrKey);
        }

        if (! $fileAdder) {
            return null;
        }

        $media = $fileAdder->toMediaCollection($collection);

        if ($syncColumn) {
            $this->{$syncColumn} = $media->file_name;
            $this->saveQuietly();
        }

        return $media;
    }

    /**
     * Get media URL with optional fallback to legacy column or default asset.
     *
     * @param string $collection
     * @param string|null $legacyPath
     * @param string|null $defaultAsset
     * @return string|null
     */
    public function getMediaUrlOrFallback(string $collection, ?string $legacyPath = null, ?string $defaultAsset = null): ?string
    {
        $url = $this->getFirstMediaUrl($collection);

        if (! empty($url)) {
            return $url;
        }

        if (! empty($legacyPath)) {
            return asset($legacyPath);
        }

        return $defaultAsset ? asset($defaultAsset) : null;
    }
}
