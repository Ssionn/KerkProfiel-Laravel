<?php

namespace App\Services;

use App\Models\TemporaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageHolderService
{
    public function store(Request $request): string
    {
        if ($request->hasFile($requestedFileName = $request->keys()[0])) {
            try {
                $tempFile = $request->file($requestedFileName);
                $fileName = str_replace(' ', '_', $tempFile->getClientOriginalName());
                $folder = uniqid() . '-' . now()->timestamp;
                $path = 'avatars/tmp/' . $folder;

                if ($tempFile->storeAs($path, $fileName, ['disk' => 'public'])) {
                    TemporaryImage::create([
                        'folder' => $folder,
                        'filename' => $fileName,
                        'owner_id' => Auth::user()->id,
                    ]);

                    return $folder;
                }
            } catch (\Exception $e) {
                throw new \Exception('Error storing temporary image: ' . $e->getMessage());
            }
        }

        return '';
    }

    public static function getRecentFolder(): string
    {
        $tempImage = TemporaryImage::where('owner_id', Auth::user()->id)
            ->latest()
            ->first();

        return $tempImage->folder ?? '';
    }
}
