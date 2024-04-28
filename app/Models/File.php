<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'file_path'
    ];

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
