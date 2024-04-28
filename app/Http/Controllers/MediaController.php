<?php

namespace App\Http\Controllers;


use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MediaController extends Controller
{
    public function storeMedia(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpeg,png,mp4,mov,wav,mp3,pdf,csv,xls,xlsx|max:1048576',
            'collection' => 'required|string',
            'content' => 'nullable|string',
        ]);

        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        $fileTitle = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $media = new Media();
        $media->title = $fileTitle;
        $media->content = $request->input('content');
        $media->size = $fileSize;

        $media->addMediaFromRequest('file')
            ->toMediaCollection($validatedData['collection']);

        return response()->json($media, 201);
    }





    // public function updateMedia(Request $request, Media $media)
    // {
    //     $validatedData = $request->validate([
    //         'content' => 'nullable|string',
    //     ]);

    //     $media->update($validatedData);

    //     if ($request->hasFile('file')) {
    //         $media->addMediaFromRequest('file')
    //             ->toMediaCollection($request->collection);
    //     }

    //     return response()->json($media, 200);
    // }


    // public function destroyMedia(Media $media)
    // {
    //     $media->delete();

    //     return response()->json(null, 204);
    // }

    // public function downloadMedia(Media $media)
    // {
    //     return $media->download();
    // }
}
