<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryImage extends Model
{
    protected $fillable = [
        'folder',
        'filename',
    ];
}
