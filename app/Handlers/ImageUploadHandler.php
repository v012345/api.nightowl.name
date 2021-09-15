<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "jpeg", "gif"];

    public function saveImage($file, $type)
    {
        $folder = "uploads/images/" . date("Ym/d", time());
        $save_path = public_path() . '/' . $folder;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $type . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        $file->move($save_path, $filename);
        $image = Image::make("$save_path/$filename");
        $image->resize(400, 400)->save();
        return config('app.url') . "/$save_path/$filename";
    }
}
