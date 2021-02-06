<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackpackUser;

class MembershipApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('membership_application.application_form');
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
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'last_name' => 'required|max:255',
            'post_code' => 'required|digits:4',
            'address_residential' => 'required|max:255',
            'city_residential' => 'required|max:255',
            'post_code_residential' => 'required|digits:4',
            'email' => 'required|email:rfc',
            'agree_to_conditions' => 'required|accepted',
            'mobile' => 'min:10|max:20',
            'home_phone' => 'min:8|max:15',
            
        ]);
        
        $validatedData['documents'] = $request->input('documents');
        $validatedData['password'] = $password;
        $validatedData['member_number'] = $latest_membership_id + 1;
        $user = BackpackUser::create($validatedData);
        $user->image = $request->input('image');
        $user->documents = $request->input('documents[]');
        $user->addComment($request->input('details_of_previous_group'));
        $user->save();
        return;
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
