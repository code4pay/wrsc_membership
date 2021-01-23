<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackpackUser;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('application_form'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $password = str_random(50);
        $request->merge(['password' => $password]);
        $request->merge(['password_confirmation' => $password]);
        $latest_membership_id = BackpackUser::max('member_number');
        if (!$request->input('member_number')) {
            $request->merge(['member_number' => $latest_membership_id + 1]);
        }
        $user = BackpackUser::create($request->all());
        $user->save();
        return view('application_uploads',['user' => $user]); 
    }
  /**
     * Add a Mebership Card image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function id_upload(Request $request)
    {
        
        $user = BackpackUser::findOrFail($request->input('user_id'));
        if (!$user) {
            abort(400, 'Could not find that entry in the database X.');
        }
        $user->image = $request->input('image');
        $user->save();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
