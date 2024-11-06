<?php

namespace App\Services;

use App\Models\TemporaryImage;
use Illuminate\Http\Request;

class ImageHolder
{
    public function store(Request $request)
    {
        if ($request->hasFile('team_avatar')) {
            try {
                $tempFile = $request->file('team_avatar');
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
