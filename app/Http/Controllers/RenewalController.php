<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberRenewalRequest;
use Illuminate\Support\Facades\Auth;
use PDF;

class RenewalController extends Controller
{

    /**
     * Gets called like /tac_accept/{token}
     */
    public function show($tokenValue)
    {
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) {
            abort(404, "Unkown Request");
        }
        $user = $token->user()->first();
        if (!$user) {
            abort(404, "Unkown User");
        }
        return view('membership_renewal.index', ['user' => $user, 'token' => $token]);
    }

    public function update(Request $request)
    {

        $tokenValue = $request->input('token');
        if (!$tokenValue) {
            abort(404, "Unkown Request Missing Token ");
        }

        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) {
            abort(404, "Unkown Token");
        }
        $tokenUser = $token->user()->first();
        $user = \App\Models\BackpackUser::where('member_number', $request->input('member_number'))->first();
        if (!$user) {
            abort(404, "Unkown User");
        }
        if ($user->id != $tokenUser->id) {
            abort(404, "Mismatch Request");
        };
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'last_name' => 'required|max:255',
            'post_code' => 'required|digits:4',
            'address_residential' => 'required|max:255',
            'city_residential' => 'required|max:255',
            'post_code_residential' => 'required|digits:4',
            'email' => 'nullable|required|email:rfc',
            'agree_to_conditions' => 'required|accepted',
            'mobile' => 'nullable|min:10|max:20',
            'home_phone' =>'nullable|min:8|max:15',

        ]);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->post_code = $request->input('post_code');
        $user->address_residential = $request->input('address_residential');
        $user->city_residential = $request->input('city_residential');
        $user->post_code_residential = $request->input('post_code_residential');
        $user->email = $request->input('email');

        if ($request->input('mobile')) {
            $user->mobile = $request->input('mobile');
        }
        if ($request->input('home_phone')) {
            $user->home_phone = $request->input('home_phone');
        }
        $user->tac_date = date("Y-m-d H:i:s");
        $user->addComment('Terms and Conditions accepted from Web site');
        $user->save();
        return view('membership_renewal.payment', ['user' => $user, 'token' => $tokenValue, 'current_paid_to' => config('app.current_paid_to')]);
    }

    public function dontRenewShow($tokenValue)
    {
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) {
            abort(404, "Unkown Request");
        }
        return view('membership_renewal.dont_renew', ['user' => $token->user()->first(), 'token' => $token]);
    }

    public function didntRenew(Request $request)
    {
        $tokenValue = $request->input('token');
        if (!$tokenValue) {
            abort(404, "Unkown Request");
        }
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) {
            abort(404, "Unkown Request");
        }
        $tokenUser = $token->user()->first();
        $user = \App\Models\BackpackUser::where('member_number', $request->input('member_number'))->first();
        if (!$user) {
            abort(404, "Unkown Request");
        }
        if ($user->id != $tokenUser->id) {
            abort(404, "Unkown Request");
        };
        $user->dont_renew = true;
        $user->addComment('Member chose not to renew.');
        $user->save();
        return view('membership_renewal.didnt_renew');
    }

    public function paidPayPal(Request $request)
    {
        $tokenValue = $request->input('token');
        if (!$tokenValue) {
            abort(404, "Unkown Request missing token");
        }
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) {
            abort(404, "Unkown Token");
        }
        $tokenUser = $token->user()->first();
        $user = \App\Models\BackpackUser::where('member_number', $request->input('member_number'))->first();
        if (!$user) {
            abort(404, "Unkown User");
        }
        if ($user->id != $tokenUser->id) {
            abort(404, "Unkown Request Mismatch");
        };
        if ($request->input('amount')) {
            $user->paypalRenewal($request->input('amount'), $request->input('order_id'));
        }
    }

    /**
     * Below here these are routes for Admins 
     * They should  have access protected in the routes file.
     * This is called by the Email Renewals button in the admin interface
     */

    public function emailRenewals(Request $request)
    {
        if (!backpack_user()->can('Send Renewals')) {
            abort(403, 'You do not have access to this action');
        }
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
            //return (new MemberRenewalRequest($user))->render();
            Mail::to($user)->send(new MemberRenewalRequest($user));
            $admin_user = Auth::user();
            $user->tac_email_date = date('Y-m-d');
            $user->addComment('Emailed Renewal Request with total amount Payable $' . $user->totalRenewalAmount(), "$admin_user->first_name $admin_user->last_name");
            $user->save();
        }
    }

    public function printRenewals(Request $request)
    {
        if (!backpack_user()->can('Send Renewals')) {
            abort(403, 'You do not have access to this action');
        }
        $users = [];
        foreach ($request->get('users') as $user_id) {
            $user = \App\Models\BackpackUser::find($user_id);
            if (!$user) {
                abort(400, 'Could not find that user.');
            }
            array_push($users, $user);
        }
        $pdf = PDF::loadView('membership_renewal.pdf.membership_renewal', ['users' => $users]);

        $admin_user = Auth::user();
        $user->tac_email_date = date('Y-m-d');
        $user->addComment('Printed Renewal Request ', "$admin_user->first_name $admin_user->last_name");
        $user->save();
        return $pdf->download('renewal_documents.pdf');
    }
}
