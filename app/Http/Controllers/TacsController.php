<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TacsController extends Controller
{
    public function show ($token){
        $token = \App\Models\Token::where('token', $token)->first();
        if (!$token) { abort(404, "Unkown Request"); }
       // dd($token->user()->first());
        return view('tac_form', ['user' => $token->user()->first()]);
}

}