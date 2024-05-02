<?php

namespace App\Http\Controllers;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class MediaController extends Controller
{
    // public function storeMedia(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'file' => 'required|file|mimes:jpeg,png,mp4,mov,wav,mp3,mpeg,pdf,csv,xls,xlsx,zip|max:1048576',
    //         'collection' => 'required|string',
    //         'title' => 'nullable|string',
    //     ]);

    //     if (!$request->hasFile('file')) {
    //         return response()->json(['error' => 'No file uploaded'], 400);
    //     }

    //     $file = $request->file('file');
    //     $fileContent = $file->getClientOriginalName();
    //     $fileSize = $file->getSize();
    //     $filePath=$file->getFilePath();

    //     $media = new Media();
    //     $media->title = $request->input('title');
    //     $media->content = $fileContent;
    //     $media->size = $fileSize;
    //     $media->path=$filePath;

    //     $media->addMediaFromRequest('file')->toMediaCollection($validatedData['collection']);

    //     return response()->json($media, 201);
    // }


    public function storeMedia(Request $request)
{
    $validatedData = $request->validate([
        'file' => 'required|file|mimes:jpeg,png,mp4,mov,wav,mp3,mpeg,pdf,csv,xls,xlsx,zip|max:1048576',
        'collection' => 'required|string',
        'title' => 'nullable|string',
    ]);

    if (!$request->hasFile('file')) {
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    $file = $request->file('file');
    $fileContent = $file->getClientOriginalName();
    $fileSize = $file->getSize();

    $media = new Media();
    $media->title = $request->input('title');
    $media->content = $fileContent;
    $media->size = $fileSize;

    
    $media->addMediaFromRequest('file')
        ->toMediaCollection($validatedData['collection'], 'public');


    return response()->json($media, 201);
}










public function downloadMedia($mediaId)
{

    $media = Media::find($mediaId);

    if (!$media) {

        return response()->json(['error' => 'Media not found'], 404);
    }


    $filePath = $media->getPath();


    if (!Storage::disk('files')->exists($filePath)) {
        abort(404, 'File not found');
    }


    $headers = [
        'Content-Type' => $media->mime_type,
        'Content-Disposition' => 'attachment; filename="' . $media->file_name . '"',
    ];


    return response()->file($filePath, $headers);
}






    // public function downloadMedia($mediaId)
    // {
    //     // Find the media file by ID
    //     $media = Media::where('id', $mediaId)->firstOrFail();
    //     // Update the "view_at" timestamp
    //     $media->update(['view_at' => now()]);

    //     // Get the file path from the media
    //     $filePath = $media->getPath();

    //     // Set headers for download response
    //     $headers = [
    //         "Cache-Control: public, max-age=31536000",
    //         "Expires: " . gmdate("D, d M Y H:i:s", time() + 31536000),
    //         "Content-Description: File Transfer",
    //         "Content-Disposition: attachment; filename=\"{$media->file_name}\"",
    //         "Content-Type: {$media->mime_type}",
    //     ];

    //     // Return the file as a response
    //     return response()->file($filePath, $headers);
    // }







}
