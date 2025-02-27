<?php

namespace App\Repositories;

use App\Models\TemporaryImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TemporaryImageRepository
{
    public function updateRecentTemporaryImageWithModel(TemporaryImage $temporaryImage, Model $model): TemporaryImage
    {
        $temporaryImage->update([
            'model_type' => $model->getMorphClass(),
            'model_id' => $model->getKey(),
        ]);

        $temporaryImage->refresh();

        return $temporaryImage;
    }

    public function findRecentTemporaryImageByUser(User $user)
    {
        return TemporaryImage::where('owner_id', $user->id)->first();
    }

    public function deleteTemporaryImage(string $folder): void
    {
        TemporaryImage::where('folder', $folder)->delete();
    }
}
