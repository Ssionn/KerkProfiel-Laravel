<?php

namespace App\Services;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CustomPathGeneratorService implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $media->uuid . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $media->uuid . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $media->uuid . '/responsive-images/';
    }
}
