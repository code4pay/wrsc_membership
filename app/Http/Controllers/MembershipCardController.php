<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberRenewalRequest;
use Illuminate\Support\Facades\Auth;
use PDF;
class MembershipCardController extends Controller
{
    public function emailMembershipCard(Request $request)
    {
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }

            //return (new MemberRenewalRequest($user))->render();
            Mail::to($user)->send(new MemberRenewalRequest($user));
            $admin_user = Auth::user();
            $user->addComment('Emailed Membership Card', $admin_user->name);
            $user->save();
        }
    }

    public function printMembershipCard(Request $request)
    {
        $users = [];
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
            array_push($users, $user);
        }
            $pdf = PDF::loadView('membership_card', ['users' => $users]);

            $admin_user = Auth::user();
            $user->addComment('Printed Membership Card', $admin_user->name);
            $user->save();
            return $pdf->download('membership_cards.pdf');
    }
}
