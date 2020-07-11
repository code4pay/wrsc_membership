<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DocumentsController extends Controller
{
    public function download($fileName)
    {
        if (!Storage::disk('private')->exists('documents/'.$fileName)){ // note that disk()->exists() expect a relative path, from your disk root path. so in our example we pass directly the path (/.../laravelProject/storage/app) is the default one (referenced with the helper storage_path('app')
            abort('404'); // we redirect to 404 page if it doesn't exist
        } 
        if (!backpack_user()->can('View Documents')){abort('403');}
        return response()->file(storage_path('app/private/documents/'.$fileName)); 
    }

}
