<?php

namespace App\Http\Controllers\Admin;

/**
 * Page for general Admin functions like preparing for renewals.  
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteAdminController extends \App\Http\Controllers\Controller
{
    public function index()
    {

        if (!backpack_user()->hasRole('admin')) {
            abort('403');
        }
        $current_paid_to = \App\Models\Setting::currentPaidTo();
     
        return view('admin.index',['current_paid_to' => $current_paid_to]);
    }
    public function download_presidents_report()
    {
        if (!backpack_user()->can('View Documents')) {
            abort('403');
        }
        if (!Storage::disk('private')->exists('documents/presidents_report.pdf')) { // note that disk()->exists() expect a relative path, from your disk root path. so in our example we pass directly the path (/.../laravelProject/storage/app) is the default one (referenced with the helper storage_path('app')
            abort('404'); // we redirect to 404 page if it doesn't exist
        }
        return response()->file(storage_path('app/private/documents/presidents_report.pdf'));
    }

    public function upload_presidents_report(Request $request)
    {
        if (!backpack_user()->hasRole('admin')) {
            abort('403');
        }

        $request->validate([
            'presidents_report' => 'required|mimes:pdf'
        ]);

        if ($request->file()) {
            $file = $request->file('presidents_report');
            $fileName = 'presidents_report.pdf';
            $file->storeAs('documents', $fileName, 'private');
        return response("OK", 200);
        }

        return response("OK", 500);
    }

    public function setCurrentPaidTo(Request $request)
    {
        if (!backpack_user()->hasRole('admin')) {
            abort('403');
        }
        $current_paid_to = \App\Models\Setting::where('name', '=', 'current_paid_to')->first();
        $current_paid_to->value = $request->input('current_paid_to');
        
        $current_paid_to->save();
        return $this->index();
    }

}
