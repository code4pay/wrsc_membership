<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Illuminate\Queue\NullQueue;
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Support\Str;
use Monolog\Handler\NullHandler;
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
    // Don't store comment revisions as it tracks its own history
    protected $dontKeepRevisionOf = ['comments'];


    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        //turn off password reset for now.  
    //    $this->notify(new ResetPasswordNotification($token));

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
    // Added this becuase the mailer uses name as a field automatically
    // For sending
    public function getNameAttribute() {
        return $this->getFullnameAttribute();
    }

    public function courses(){
        return $this->hasMany('App\Models\CourseUser');
    }
    public function authorities(){
        return $this->hasMany('App\Models\AuthoritiesUser');
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


    public function formattedPostalAddress () {
        return '<address>'
        .$this->address.'<br>'
        .$this->city.'<br>'
        .$this->state.'<br>'
        .$this->post_code.'<br>'
        .'</address>';
    }
    public function formattedResidentialAddress () {
        return '<address>'
        .$this->address_residential.'<br>'
        .$this->city_residential.'<br>'
        .$this->state_residential.'<br>'
        .$this->post_code_residential.'<br>'
        .'</address>';
    }

    public function hasAuthority($name) {
        foreach ($this->authorities()->get() as $authority){
            if ($authority->authority->name == $name) {
                return true;
            }
        }
        return false;
    }

    public function tokens () {
        return $this->hasMany('App\Models\Token');
    }

    public function createToken($type) {
        $token = new \App\Models\Token;
        $token->user_id = $this->id;
        $token->type = $type;
        $token->token = str_random(50);
        $token->save();
        return $token->token;

    }

    public function renewalAmount()
    {
        if ($this->memberType->name == 'Honorary' || $this->memberType->name == 'Life') {return 0;}
         
        //Family Members get a reduced rate.  
        if ($this->primary_member_id ){ 
            $primary_member = $this->primary()->first();
            //If life or Honorary then family members are also free     
            if ($primary_member->memberType->name == 'Honorary' || $primary_member->memberType->name == 'Life' ) {
                return 0 ;
            } else {
                return  5;
            }
         }
        return 15;

    }
    public function totalRenewalAmount()
    {
        $amount = $this->renewalAmount();
        foreach($this->siblings()->get() as $sibling){
            $amount = $amount + $sibling->renewalAmount();
        }
        return $amount;
    }

    public function addComment($comment,  $user='system')
    {
        $comments = json_decode($this->comments);
        if (!$comments) { $comments = [];}
        array_push($comments,['comment'=> $comment, 'date' => date('Y-m-d'), 'author' => $user]); 
        $this->comments = json_encode($comments);
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = 'private'; // or use your own disk, defined in config/filesystems.php
        $destination_path = "profile_images"; // path relative to the disk above
        
        
        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }
        //Only added for the initial import where they where all jpg's
        if (ends_with($value, '.jpg')) {

            $this->attributes[$attribute_name] = $value;
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
