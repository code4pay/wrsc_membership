<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
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
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);

        if (!$userModel->find($userId)) {
            abort(400, 'Could not find that entry in the database.');
        }
        return [
            'email'    => 'email',
            'password' => 'confirmed',
            'first_name'     => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'post_code' => 'required',
            'address_residential' => 'required',
            'city_residential' => 'required',
            'post_code_residential' => 'required',
            'member_number',
            'wildman_number',
            'region_id' => 'required',
            'mobile',
            'home_phone',
            'joined',
            'lyssa_sereology_date',
            'lyssa_sereology_value',
            'paid_to',
            'member_type_id',         
            
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
