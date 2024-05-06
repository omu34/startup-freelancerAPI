<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'time',
        'content',
        'name',
        'mime_type',
        'file',
        'file_path',
        'model', // Polymorphic relationship with other models
        'size',
        ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg','image/jpg', 'image/png']);

        $this
            ->addMediaCollection('videos')
            ->acceptsMimeTypes(['video/mp4', 'video/quicktime']);

        $this
            ->addMediaCollection('audios')
            ->acceptsMimeTypes(['audio/mpeg','audio/mp3', 'audio/wav']);

        $this
            ->addMediaCollection('documents')
            ->acceptsMimeTypes([
            'text/csv',
            'application/pdf',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
