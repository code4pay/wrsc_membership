<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class User extends Authenticatable 
{
    use CrudTrait;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name',
        'email',
        'password', 
        'address',
        'address',
        'city',
        'state',
        'country',
        'post_code',
        'address_residential',
        'city_residential',
        'state_residential',
        'country_residential',
        'post_code_residential',
        'member_number',
        'wildman_number',
        'region_id',
        'mobile',
        'home_phone',
        'joined',
        'lyssa_serology_date',
        'lyssa_serology_value',
        'paid_to',
        'date_of_birth',
        'member_type_id',
        'comments'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'datetime'
    ];
}
