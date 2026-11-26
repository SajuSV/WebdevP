<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;

// A small reusable helper used by the admin controllers.
trait UploadsImages
{
    // Rules for an uploaded picture (max 4 MB). SVG upload is blocked for safety.
    protected function fileRules(): array
    {
        return ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'];
    }

    // Rules for the text box: a web link (https://...) or an already uploaded file
    protected function pathRules(): array
    {
        return ['nullable', 'string', 'max:500', 'regex:#^(https?://|uploads/)#i'];
    }

    // If a new file was chosen, save it in public/uploads and return its path.
    // Otherwise keep the value from the text box.
    protected function imagePath(?UploadedFile $file, ?string $current): ?string
    {
        if (! $file) {
            return $current;
        }

        // hashName() creates a random, safe file name
        $name = $file->hashName();
        $file->move(public_path('uploads'), $name);

        return 'uploads/'.$name;
    }
}
