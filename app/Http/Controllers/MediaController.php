<?php

namespace App\Http\Controllers;


use App\Models\Library;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\File; // For downloading

class MediaController extends Controller
{
    public function storeMedia(Request $request, Library $model)
    {
        $request->validate([
            'file' => 'required|mimetypes:' . $this->getAllowedMimeTypes($request->collection), // Dynamic validation based on collection
            'size' => 'max:2048', // Adjust size limit as needed
        ]);

        $media = $model->addMediaFromRequest('file')->toMediaCollection($request->collection);

        return response()->json([
            'message' => 'Media uploaded successfully!',
            'data' => [
                'id' => $media->id,
                'url' => $media->getUrl(), // Use getUrl() for flexibility (adjust if needed)
                'type' => $media->mime_type,
                // Add other relevant media details
            ],
        ], 201);
    }

    public function getMedia(Library $model, string $collection)
    {
        $media = $model->getMedia($collection);

        return response()->json([
            'message' => 'Media retrieved successfully!',
            'data' => $media->map(function (Media $mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'url' => $mediaItem->getUrl(), // Use getUrl() for flexibility (adjust if needed)
                    'type' => $mediaItem->mime_type,
                    // Add other relevant media details
                ];
            })->toArray(),
        ]);
    }

    public function updateMedia(Request $request, Library $model, int $mediaId)
    {
        $media = $model->getMedia('')->find($mediaId); // Find media from any collection

        if ($media) {
            $request->validate([
                'name' => 'nullable|string', // Allow optional name update
            ]);

            if ($request->has('name')) {
                $media->name = $request->name;
            }

            $media->save();

            return response()->json([
                'message' => 'Media updated successfully!',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'url' => $media->getUrl(), // Use getUrl() for flexibility (adjust if needed)
                    'type' => $media->mime_type,
                    // Add other relevant media details
                ],
            ]);
        }

        return response()->json(['message' => 'Media not found'], 404);
    }

    public function deleteMedia(Library $model, int $mediaId)
    {
        $media = $model->getMedia('')->find($mediaId); // Find media from any collection

        if ($media) {
            $media->delete();

            return response()->json(['message' => 'Media deleted successfully!']);
        }

        return response()->json(['message' => 'Media not found'], 404);
    }

    public function downloadMedia(Library $model, int $mediaId)
    {
        $media = $model->getMedia('')->find($mediaId); // Find media from any collection

        if ($media) {
            $file = \File::createFromMedia($media);
            return response()->download($file->getPath(), $file->name);
        }

        return response()->json(['message' => 'Media not found'], 404);
    }

    private function getAllowedMimeTypes(string $collection): string
    {
        $mimeTypes = [
            'images' => 'image/*',
            'videos' => 'video/*',
            'audios' => 'audio/*',
            'documents' => 'application/pdf,application/vnd.ms-excel',
        ];

        return isset($mimeTypes[$collection]) ? $mimeTypes[$collection] : '*/*'; // Allow all if collection not found
    }
}
