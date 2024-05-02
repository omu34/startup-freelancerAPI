<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Media extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'content',
        'file'
        
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
            // ->size();
        $this
            ->addMediaCollection('videos')
            ->acceptsMimeTypes(['video/mp4', 'video/quicktime']);
            // ->size();
        $this
            ->addMediaCollection('audios')
            ->acceptsMimeTypes(['audio/mpeg', 'audio/wav']);
            // ->size();
        $this
            ->addMediaCollection('documents')
            ->acceptsMimeTypes([ // Adjust mime types if needed
                'application/pdf',
                'text/csv',
                'application/vnd.ms-excel', // xls
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
            ]);
            // ->size();
    }
}
