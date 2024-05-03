<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class FileUploaderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,mp4,mov,wav,mp3,pdf,csv,xls,xlsx,zip|max:1048576',
            'title' => 'nullable|string',

        ]);

        $file = $request->file('file');
        $fileTime = $file->getMTime();
        $fileName = $file->getFilename();
        $content = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileMimeType = $file->getMimeType();




        // $fileContents = file_get_contents($file->getRealPath());
        // $content = Str::limit($fileContents, 255);
        $media = File::create([
            'title' => $request->input('title'),
            'content' => $content,
            'time' => $fileTime,
            'name' => $fileName,
            'mime_type' => $fileMimeType,
            'size' => $fileSize,
            'file_path' => $file->store('files', 'public'),
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'media' => $media], 201);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $media = File::findOrFail($id);
        \Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);
    }


    public function download($id)
    {
        $file = File::findOrFail($id);

        if (!\Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $headers = [
            'Content-Type' => $file->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
        ];

        return response()->download(storage_path('app/public/' . $file->file_path), $file->name, $headers);
    }

}
