<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,mp4,mov,wav,mp3,pdf,csv,xls,xlsx,zip|max:1048576',
            'content' => 'nullable|string',

        ]);

        $file = $request->file('file');
        $title = $file->getClientOriginalName();
        $fileSize = $file->getSize();


        // $fileContents = file_get_contents($file->getRealPath());
        // $content = Str::limit($fileContents, 255);
        $media = File::create([
            'title' => $title,
            'content' =>$request->input('content'),
            'size'=>$fileSize,
            'file_path' => $file->store('files', 'public'),
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'media' => $media], 201);
    }






    /**
     * Show the form for editing the specified resource.
     */
    // public function download($id)
    // {
    //     try {
    //         $media = File::findOrFail($id);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return response()->json(['error' => 'File not found'], 404);
    //     }

    //     $filePath = storage_path('app/files' . $media->file_path);

    //     if (!\Storage::disk('local')->exists($media->file_path)) {
    //         return response()->json(['error' => 'File not found'], 404);
    //     }

    //     return response()->download($filePath, $media->name);
    // }



    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string|max:255',
    //         'file' => 'nullable|file|mimes:jpeg,png,mp4,mp3,pdf,excel,csv,docx|max:2048', // Example MIME types and max file size
    //     ]);

    //     $media = File::findOrFail($id);

    //     if ($request->hasFile('file')) {
    //         $media = $request->file('file');
    //         $media->file_path = $media->store('files', 'public'); // Update file_path if a new file is uploaded
    //     }

    //     $media->update([
    //         'title' => $request->input('title', $media->title),
    //         'content' => $request->input('content', $media->content),

    //     ]);

    //     return response()->json(['message' => 'File updated successfully', 'file' => $media], 200);
    // }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $media = File::findOrFail($id);
    //     \Storage::disk('public')->delete($media->file_path);
    //     $media->delete();
    //     return response()->json(['message' => 'File deleted successfully'], 200);
    // }
}
