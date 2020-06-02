<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'email',
            'first_name'     => 'required',
            'last_name'     => 'required',
            //I cant get this workng the end query always ends up containing
            // select count(*) as aggregate from `users` where `users`.`primary_member_id` = 1 and `users`.`primary_member_id` is not null 
            // 'primary_member_id' => [
            //     Rule::exists('users')->where(function ($query) {
            //         $query->where('primary_member_id', '>', 0);
            //     })
            // ],
            'password' => 'confirmed',
            'member_type_id' => 'required|integer'
        ];
    }
        /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'primary_member_id.exists' => 'The primary member can not be themselves or a sibling',
        ];
    }
}
