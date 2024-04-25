<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'content' => 'required',
            'attachment'=> ['image', 'pdf','video', 'audio']
        ]);
        // 'attachment'=[
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $imagemimes = ['image/jpeg', 'image/png'];
            $videomimes = ['video/mp4'];
            $audiomimes = ['audio/mpeg'];
            $audiomimes = ['pdf/pdf'];


            $filevalidate = 'required';

            if (in_array($file->getMimeType(), $imagemimes)) {
                $filevalidate .= '|mimes:jpeg,png|max:2048';
            } elseif (in_array($file->getMimeType(), $videomimes)) {
                $filevalidate .= '|mimes:mp4';
            } elseif (in_array($file->getMimeType(), $audiomimes)) {
                $filevalidate .= '|mimes:mp3';
            } elseif (in_array($file->getMimeType(), $audiomimes)) {
                $filevalidate .= '|mimes:mp3';
            }


            $request->validate([
                'file' => $filevalidate,
            ]);

            // Generate a unique filename to prevent collisions
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // Save the file to storage
            $file->storeAs('uploads', $filename, 'public');

            // You can perform additional actions here, like saving file details to database

            return redirect()->back()->with('success', 'File uploaded successfully!');
        }

    }

    public function delete($filename)
    {
        if (Storage::disk('public')->exists('uploads/' . $filename)) {
            Storage::disk('public')->delete('uploads/' . $filename);

            return redirect()->back()->with('success', 'File deleted successfully!');
        }

        return redirect()->back()->with('error', 'File not found!');
    }
}
