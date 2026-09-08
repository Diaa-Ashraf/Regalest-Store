<?php

namespace App\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{

    public static function uploadImage($request, $file_name, $folder_name, $new_name)
    {
        $file = $request->file($file_name);

        // Team HM -> team-hm
        // -
        // Oats Pasta -> oats-pasta
        // 124345
        // .png, .svg, .webp, .jpg
        // Final: team-hm-oats-pasta-124345.png
        // products/team-hm-oats-pasta-124345.png
        $hashedFilename = Str::slug(config('app.name'), '-') . '-' . Str::slug($new_name, '-') . rand(1, 999999999) . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->put("{$folder_name}/{$hashedFilename}", file_get_contents($file), 'public');

        return $hashedFilename; // team-hm-oats-pasta-124345.png
    }
}
