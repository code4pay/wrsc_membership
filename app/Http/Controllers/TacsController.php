<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TacsController extends Controller
{
    public function show ($tokenValue){
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) { abort(404, "Unkown Request"); }
       // dd($token->user()->first());
        return view('tac_form', ['user' => $token->user()->first(), 'token' => $token]);
}

    public function update (Request $request) {
        $tokenValue = $request->input('token');
        if (!$tokenValue) { abort(404, "Unkown Request"); }
        $token = \App\Models\Token::where('token', $tokenValue)->first();
        if (!$token) { abort(404, "Unkown Request"); }
       // dd($token->user()->first());
        $tokenUser = $token->user()->first();
        $user = \App\Models\BackpackUser::where('member_number', $request->input('member_number'))->first();
        if (!$user) { abort(404, "Unkown Request"); }
        if ($user->id != $tokenUser->id) { abort(404, "Unkown Request"); }; 
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'post_code' => 'required|digits:4',
            'address_residential' => 'required|max:255',
            'city_residential' => 'required|max:255',
            'post_code_residential' =>'required|digits:4',
            'email' => 'required|email:rfc',
            'agree_to_conditions' => 'required|accepted'
            
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

        if ($request->input('mobile')) { $user->mobile = $request->input('mobile');}
        if ($request->input('home_phone')) { $user->mobile = $request->input('home_phone');}
        $user->tac_date = date("Y-m-d H:i:s");
        $user->addComment('Terms and Conditions accepted from Web site');
        $user->save();
        return view('member_payment', ['user' => $user]);
    }
}