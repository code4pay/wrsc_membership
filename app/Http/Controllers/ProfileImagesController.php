<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfileImagesController extends Controller
{
    public function showImage($fileName)
    {
        
        $image = Storage::disk('private')->get('profile_images/' . $fileName );

        return response()->make($image, 200, ['content-type' => 'image/jpg']);
    }

}
