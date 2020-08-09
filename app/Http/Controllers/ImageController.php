<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Intervention\Image as ImageHandler;

class ImageController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        $image = $request->file('image');

        $filename = $image->storePublicly('avatars', 'public');

        Image::create([
            'filename' => $filename
        ]);

        return $filename;
    }
}
