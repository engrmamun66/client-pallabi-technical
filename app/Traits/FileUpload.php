<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    public function uploadFile($file, $folder)
    {
        if (!$file) {
            return null;
        }

        // Make sure directory exists
        $path = storage_path("app/public/{$folder}");
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Generate a unique name
        $extension = $file->getClientOriginalExtension() ?: 'bin';
        $fileName = uniqid() . '.' . $extension;

        // Move the uploaded file to storage/app/public/{folder}
        $file->move($path, $fileName);

        // Return the relative path for saving in DB
        return "{$folder}/{$fileName}";
    }
}
