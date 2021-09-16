<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "jpeg", "gif"];

    public function saveImage($file, $resize = true)
    {
        $relative_path = "uploads/images/" . date("Ym/d", time());
        $absolute_path = public_path() . '/' . $relative_path;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        $file->move($absolute_path, $filename);
        if ($resize) {
            $image = Image::make("$absolute_path/$filename");
            $image->resize(400, 400)->save();
        }
        return config('app.url') . "/$relative_path/$filename";
    }
}
