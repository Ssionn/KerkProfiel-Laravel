<?php

namespace App\Services;

use App\Models\TemporaryImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageHolderService
{
    public function store(
        Request $request
    ): string {
        $uploadedFile = $request->allFiles()[$request->keys()[0]];

        if (!$uploadedFile instanceof UploadedFile) {
            throw new Exception('Image is not an uploaded file');
        }

        $newFileName = str_replace(' ', '_', $uploadedFile->getClientOriginalName());
        $uniqueFolder = uniqid() . '-' . now()->timestamp;
        $path =  'avatars/tmp/' . $uniqueFolder;

        if ($uploadedFile->storeAs($path, $newFileName, ['disk' => 'public'])) {
            TemporaryImage::create([
                'folder' => $uniqueFolder,
                'filename' => $newFileName,
                'owner_id' => auth()->user()->id,
            ]);

            return $uniqueFolder;
        }

        return '';
    }
}
