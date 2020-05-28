<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberRenewalRequest;
use Illuminate\Support\Facades\Auth;
use PDF;
class EmailRenewalsController extends Controller
{
    public function emailRenewals(Request $request)
    {
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }

            //return (new MemberRenewalRequest($user))->render();
            Mail::to($user)->send(new MemberRenewalRequest($user));
            $admin_user = Auth::user();
            $user->addComment('Emailed Renewal Request with total amount Payable $' . $user->totalRenewalAmount(), $admin_user->name);
            $user->save();
        }
    }

    public function printRenewals(Request $request)
    {
        $users = [];
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
            array_push($users, $user);
        }
            $pdf = PDF::loadView('membership_renewal', ['users' => $users]);

            return $pdf->download('renewal_documents.pdf');
            $admin_user = Auth::user();
            $user->addComment('Emailed Renewal Request with total amount Payable $' . $user->totalRenewalAmount(), $admin_user->name);
            $user->save();
    }
}