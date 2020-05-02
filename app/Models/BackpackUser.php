<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use \Venturecraft\Revisionable\RevisionableTrait;
class BackpackUser extends User
{
    use InheritsRelationsFromParentModel;
    use Notifiable;
    use RevisionableTrait;
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
    protected $table = 'users';


    // this is here for the revsionable https://backpackforlaravel.com/docs/4.0/crud-operation-revisions
    public function identifiableName()
    {
        return $this->fullname;
    }


    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
    /* Naming this 'get'*'Attribute' turns it into field attribute
    *  but istill  won't get returned in JSON results see this link for
    * that https://laravel.com/docs/7.x/eloquent-serialization#appending-values-to-json 
    */
    public function getFullnameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }
    public function courses(){
        return $this->hasMany('App\Models\CourseUser');
    }

    public function memberType() {
        return $this->belongsTo('App\Models\Membershiptype','member_type_id');
    }

    public function region() {
        return $this->belongsTo('App\Models\Region');
    }

    public function siblings() {
        return $this->hasMany('App\Models\BackpackUser','primary_member_id');
    }
    public function primary() {
           return $this->belongsTo('App\Models\BackpackUser','primary_member_id','id');
    } 


}
