<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Library extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->singleFile()
            ->accepts('image/*');

        $this
            ->addMediaCollection('videos')
            ->singleFile()
            ->accepts('video/*');

        $this
            ->addMediaCollection('audios')
            ->singleFile()
            ->accepts('audio/*');
        $this
            ->addMediaCollection('documents')
            ->accepts('application/pdf', 'application/vnd.ms-excel');
    }
}
