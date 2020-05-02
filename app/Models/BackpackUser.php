<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Support\Str;
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

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = config('backpack.base.root_disk_name'); // or use your own disk, defined in config/filesystems.php
        $destination_path = "public/uploads/images/profile_pictures/"; // path relative to the disk above

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);

        // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

        // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

        // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
        // but first, remove "public/" from the path, since we're pointing to it from the root folder
        // that way, what gets saved in the database is the user-accesible URL
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;

        }
    }


}
