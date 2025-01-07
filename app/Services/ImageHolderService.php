<?php

namespace App\Services;

use App\Models\TemporaryImage;
use Illuminate\Http\Request;

class ImageHolderService
{
    public function store(Request $request)
    {
        if ($request->hasFile($requestedFileName = $request->keys()[0])) {
            try {
                $tempFile = $request->file($requestedFileName);
                $fileName = $tempFile->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $path = 'avatars/tmp/' . $folder;

                if ($tempFile->storeAs($path, $fileName, 'public')) {
                    TemporaryImage::create([
                        'folder' => $folder,
                        'filename' => $fileName,
                    ]);

                    return $folder;
                }
            } catch (\Exception $e) {
                throw new \Exception('Error storing temporary image: ' . $e->getMessage());
            }
        }

        return '';
    }
}
