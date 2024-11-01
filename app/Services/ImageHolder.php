<?php

namespace App\Services;

use App\Models\TemporaryImage;
use Illuminate\Http\Request;

class ImageHolder
{
    public function store(Request $request)
    {
        if ($request->hasFile('team_avatar')) {
            $tempFile = $request->file('team_avatar');
            $fileName = $tempFile->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $tempFile->storeAs('avatars/tmp/' . $folder, $fileName, 'public');

            TemporaryImage::create([
                'folder' => $folder,
                'filename' => $fileName,
            ]);

            return $folder;
        }

        return '';
    }
}
