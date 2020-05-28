<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfileImagesController extends Controller
{
    public function showImage(Request $request)
    {

        $image = Storage::get('images/' . $slug . '.jpg');

        return response()->make($image, 200, ['content-type' => 'image/jpg']);
    }

}
