<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberCardRequest;
use Illuminate\Support\Facades\Auth;
use PDF;
class MembershipCardController extends Controller
{
    public function emailMembershipCard(Request $request)
    {
        if(!backpack_user()->can('Print Membership Cards')){
            abort(403, 'You do not have access to this action');
        }
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
           
            //return (new MemberRenewalRequest($user))->render();
            Mail::to($user)->send(new MemberCardRequest($user));
            $admin_user = Auth::user();
            $user->addComment('Emailed Membership Card', "$admin_user->first_name $admin_user->last_name");
            $user->save();
        }
        return 1;
    }

    public function printMembershipCard(Request $request)
    {
        if(!backpack_user()->can('Print Membership Cards')){
            abort(403, 'You do not have access to this action');
        }
        ini_set("pcre.backtrack_limit", "9000000");
        $users = [];
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
            array_push($users, $user);
        }     
           $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->showImageErrors =true;
        }];
                    $pdf = PDF::loadView('membership_card.membership_card', ['users' => $users],[],$config);
        


            $admin_user = Auth::user();
            $user->addComment('Printed Membership Card', "$admin_user->first_name $admin_user->last_name");
            $user->save();
            return $pdf->download('membership_cards.pdf');
    }
}
