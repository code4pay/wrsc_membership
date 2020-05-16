<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberRenewalRequest;
class EmailRenewalsController extends Controller
{
    public function emailRenewals(Request $request){
        foreach ($request->get('users') as $user_id){
           $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
            abort(400, 'Could not find that user.');
            }
        
        //return (new MemberRenewalRequest($user))->render();
        Mail::to($user)->send(new MemberRenewalRequest($user));
        $user->addComment('Emailed Renewal Request with total amount Payable $'. $user->totalRenewalAmount());
        }

    }
}
