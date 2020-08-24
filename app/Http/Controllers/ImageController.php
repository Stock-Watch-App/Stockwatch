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

        $image = Image::create([
            'filename' => '/storage/'.$filename
        ]);

        $image->user()->save(auth()->user());

        return $filename;
    }
}
