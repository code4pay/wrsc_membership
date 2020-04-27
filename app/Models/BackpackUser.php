<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
class BackpackUser extends User
{
    use InheritsRelationsFromParentModel;
    use Notifiable;

    protected $table = 'users';

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

    public function fullName() {
        return $this->first_name.' '.$this->last_name;
    }
    public function courses(){
        return $this->hasMany('App\Models\CourseUser');
    }

    public function memberType() {
        return $this->belongsTo('App\Models\Membershiptype');
    }

    public function region() {
        return $this->belongsTo('App\Models\Region');
    }

    public function siblings() {
        return $this->hasMany('App\Models\BackpackUser','id','primary_member_id');
    }

}
