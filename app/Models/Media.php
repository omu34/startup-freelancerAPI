<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Media extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name'];

    public function registerMediaCollections(): void
    {

        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);

        $this
            ->addMediaCollection('videos')
            ->acceptsMimeTypes(['video/mp4', 'video/quicktime']);

        $this
            ->addMediaCollection('audios')
            ->acceptsMimeTypes(['audio/mpeg', 'audio/wav']);

        $this
            ->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'application/vnd.ms-excel', 'text/csv']);
    }
}

