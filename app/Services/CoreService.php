<?php

namespace App\Services;

use Illuminate\Support\Str;

class CoreService
{
    public function fileUpload($file, $folder, $title)
    {
        $slug = Str::slug(pathinfo($title, PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();

        $fileName = $slug . '-' . uniqid() . '.' . $extension;
        $file->move(public_path("uploads/$folder"), $fileName);

        return $fileName;
    }
}
