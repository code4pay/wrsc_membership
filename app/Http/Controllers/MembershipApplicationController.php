<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackpackUser;
use App\Models\MembershipType;

class MembershipApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = $this->createToken("prevent_form_resubmit");
        return view('membership_application.application_form', ["token" => $token]);
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
        $tokenValue = $request->input("form_token"); 
        $token = \App\Models\Token::where('token', $tokenValue)
        ->where('type',"prevent_form_resubmit")
        ->first();

        if (!$token) {
            abort(403, "Sorry this form can only be submitted once");
        }
        $token->delete(); 
        $password = str_random(50);
        $request->merge(['password' => $password]);
        $request->merge(['password_confirmation' => $password]);
        $latest_membership_id = BackpackUser::max('member_number');
        $request->merge(['member_number' => $latest_membership_id + 1]);
        $primary_member = null; 
        $validatedData = $request->validate([
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email:rfc',
                'agree_to_conditions' => 'required|accepted',
                'mobile' => 'nullable|min:10|max:20',
                'home_phone' => 'nullable|min:8|max:15',
                'previous_conviction' => 'in:no',
                'member_wires' => 'in:no'
            ]);
        if ($request->input('family_member')) {
                $primary_member = BackpackUser::find($request->input('primary_member_id'));
                if (!$primary_member) { 
                    abort(404, "Invalid Primary User");
                 }
                $validatedData['primary_member_id'] = $primary_member->id;
                $validatedData['address'] = $primary_member->address;
                $validatedData['city'] = $primary_member->city;
                $validatedData['post_code'] = $primary_member->post_code;
                $validatedData['address_residential'] = $primary_member->address_residential;
                $validatedData['city_residential'] = $primary_member->city_residential;
                $validatedData['post_code_residential'] = $primary_member->post_code_residential;

    
        } else {
             $validatedDataPrimary =  $request->validate([
                'address' => 'required|max:255',
                'city' => 'required|max:255',
                'post_code' => 'required|digits:4',
                'address_residential' => 'required|max:255',
                'city_residential' => 'required|max:255',
                'post_code_residential' => 'required|digits:4',
                'over_18' =>'in:yes',
                'capatcha' => 'in:xmqki'
            ]);
        $validatedData = array_merge($validatedData, $validatedDataPrimary);
        }

        $validatedData['documents'] = $request->input('documents');
        $validatedData['password'] = $password;
        $validatedData['member_number'] = $latest_membership_id + 1;
        /*@var $user App\Models\BackpackUser */
        $user = BackpackUser::create($validatedData);
        $user->image = $request->input('image');
        $user->pending_approval = true;
        $comments = [];
        if ($request->input('details_of_previous_group')) {
            $comments[] = "Applicant was a member of another group\n" . $request->input('details_of_previous_group');
        }
        if ($request->input('cared_for_wildlife')) {
            $comments[] = "Applicant has cared for other wildlife\n" . $request->input('cared_for_wildlife');
        }
        if ($request->input('interested_in_species')) {
            $comments[] = "Applicant is interested in these species\n" . $request->input('interested_in_species');
        }
        $comment_string = filter_var(implode("\n\n", $comments), FILTER_SANITIZE_STRING);
        $user->addComment($comment_string);

        if (!$primary_member) {
            $primary_member=$user;
        }
        if ($request->input('family_member')) {
            if ($request->input("over_18") == "no"){
                $user->member_type_id = 9;  
            } else {
                $user->member_type_id = 6;
            }
        } else {
            $user->member_type_id = 5;
        }
        $user->save();
        
        if ($request->input('add_family_members') == "yes") {
            $new_token = $this->createToken("prevent_form_resubmit") ;
            return view('membership_application.application_form_family', ['primary_member' => $primary_member->fresh(), "token" => $new_token]);
        } else {

            return view('membership_application.payment', ['user' => $primary_member->fresh()]);
        }
    }

    /**
     * For creating a one time token to prevent form resubmission
     * they are tied to non user 999999  Note at this stage there is no expiry on tokens. 
     */
    public function createToken($type) {
        $token = new \App\Models\Token;
        $token->user_id = 999999;
        $token->type = $type;
        $token->token = str_random(50);
        $token->save();
        return $token->token;

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
