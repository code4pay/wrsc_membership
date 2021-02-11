<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait; 
use Illuminate\Queue\NullQueue;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Monolog\Handler\NullHandler;
use \Venturecraft\Revisionable\RevisionableTrait;
class BackpackUser extends User
{
    use InheritsRelationsFromParentModel;
    use Notifiable;
    use RevisionableTrait;
    use CrudTrait; 
    use HasRoles; 
    protected $table = 'users';

    protected $casts = [
        'documents' => 'array' //document names are stored as JSON string.
    ];

    protected $dates = [
        'tac_date'
    ];
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
    /** turn off password reset for now we dont want ordinary members resetting their passwords. 
    *   At some point we will allow users to login and change there details 
    *   then we can turn this back on. 
    */
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
    *  but it still  won't get returned in JSON results see this link for
    * that https://laravel.com/docs/7.x/eloquent-serialization#appending-values-to-json 
    */
    public function getFullnameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }
    /** 
    * Added this becuase the mailer uses name as a field automatically
    * For sending
    */
    public function getNameAttribute() {
        return $this->getFullnameAttribute();
    }

    /** Relationship mapping  */
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

    public function tokens () {
        return $this->hasMany('App\Models\Token');
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

    /**
     * For creating one time tokens for things like the Membership renewal where we don;t want 
     * to make members login.  Note at this stage there is no expiry on tokens. 
     */
    public function createToken($type) {
        $token = new \App\Models\Token;
        $token->user_id = $this->id;
        $token->type = $type;
        $token->token = str_random(50);
        $token->save();
        return $token->token;

    }

    /**
     * sends back a json formmatted string for use with paypal
     * It includes the description to use on the statements 
     */
    public function renewalAmountForPayPal()
    {

        $sibling_names ='';
        foreach($this->siblings()->get() as $sibling){
            $sibling_names .= ', '.$sibling ->fullname.' (' . $sibling->member_number. ')';
        }

       $purchaseUnits =[
        [
            
            'amount' =>[ 
              'value'=> $this->totalRenewalAmount(),
                ]
            ,
            'description' => 'WRSC Renewal Fee for '.$this->fullname.' (' . $this->member_number. ')'. $sibling_names,
        ] ];

     
       return json_encode($purchaseUnits,true);

    }

    /**
     * sends back a json formmatted string for use with paypal
     * It includes the description to use on the statements 
     */
    public function applicationAmountForPayPal()
    {

        $sibling_names ='';
        foreach($this->siblings()->get() as $sibling){
            $sibling_names .= ', '.$sibling ->fullname.' (' . $sibling->member_number. ')';
        }

       $purchaseUnits =[
        [
            
            'amount' =>[ 
              'value'=> $this->totalApplicationAmount(),
                ]
            ,
            'description' => 'WRSC Application Fee for '.$this->fullname.' (' . $this->member_number. ')'. $sibling_names,
        ] ];

     
       return json_encode($purchaseUnits,true);

    }
    //Update Records after Paypal  payment success.
    public function paypalRenewal($amount, $orderId)
    {

        $this->addComment('Member Paid  by Paypal $' . $amount . ' id:' . $orderId);
        $this->paid_paypal_date =  date('Y-m-d');
        $this->paid_paypal_amount = $amount;
        $this->save();
        foreach ($this->siblings()->get() as $sibling) {
            $sibling->paid_paypal_date =  date('Y-m-d');
            $sibling->addComment('Membership Paid via Paypal by Primary Member $' . $amount . ' id:' . $orderId);
            $sibling->save();
        }
    }


    public function renewalAmount()
    {
        if ($this->memberType->name == 'Honorary'){
         return config('app.honorary_member_fee');   
        }
        
       if($this->memberType->name == 'Life') {
         return config('app.life_member_fee');   
        }
         
        //Family Members get a reduced rate.  
        if ($this->primary_member_id ){ 
            $primary_member = $this->primary()->first();
            //If life or Honorary then family members also get a different rate
           if ($primary_member->memberType->name == 'Honorary' || $primary_member->memberType->name == 'Life' ) {
                return config('app.honorary_or_life_family_member_fee');
            } else {
                return  config('app.family_member_fee');
            }
         }
        return config('app.primary_member_fee');

    }

    public function totalRenewalAmount()
    {
        $amount = $this->renewalAmount();
        foreach($this->siblings()->get() as $sibling){
            $amount = $amount + $sibling->renewalAmount();
        }
        return $amount;
    }

    public function totalApplicationAmount()
    {
        return config('app.application_fee') + $this->totalRenewalAmount();
    }

    public function addComment($comment,  $user='system')
    {
        $comments = json_decode($this->comments);
        if (!$comments) { $comments = [];}
        array_push($comments,['comment'=> $comment, 'date' => date('Y-m-d'), 'author' => $user]); 
        $this->comments = json_encode($comments);
    }


    /**
     * this takes an image stream and saves it as a file,  mostly designed for the profile image upload. 
     */
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
        //
        // if it was an actual file passed in rather than an image stream
        if (is_a($value, 'Symfony\Component\HttpFoundation\File\UploadedFile' )){
           $fileName =   $value->store($destination_path);
           $this->attributes[$attribute_name] = $fileName;
        }
    }

    public function setDocumentsAttribute($value)
    {
        $attribute_name = "documents";
        $disk = "private";
        $destination_path = "documents";

        $this->uploadMultipleFiles($value, $attribute_name, $disk, $destination_path);
    }
     /**
     *  Copied from the Orginal BackPack function and modified to not
     * give a randome name.  
     * Handle multiple file upload and DB storage:
     * - if files are sent
     *     - stores the files at the destination path
     *     - stores the full path in the DB, as JSON array;
     * - if a hidden input is sent to clear one or more files
     *     - deletes the file
     *     - removes that file from the DB.
     *
     * @param string $value            Value for that column sent from the input.
     * @param string $attribute_name   Model attribute name (and column in the db).
     * @param string $disk             Filesystem disk used to store files.
     * @param string $destination_path Path in disk where to store the files.
     */
    private function uploadMultipleFiles($value, $attribute_name, $disk, $destination_path)
    {
        if (! is_array($this->{$attribute_name})) {
            $attribute_value = json_decode($this->{$attribute_name}, true) ?? [];
        } else {
            $attribute_value = $this->{$attribute_name};
        }
        $files_to_clear = request()->get('clear_'.$attribute_name);

        // if a file has been marked for removal,
        // delete it from the disk and from the db
        if ($files_to_clear) {
            foreach ($files_to_clear as $key => $filename) {
                \Storage::disk($disk)->delete($filename);
                $attribute_value = array_where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        
        if (request()->hasFile($attribute_name)) {
            foreach (request()->file($attribute_name) as $file) {
                if ($file->isValid()) {
                    $new_file_name = $file->getClientOriginalName();

                    // 2. Move the new file to the correct path
                    $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                    // 3. Add the public path to the database
                    $attribute_value[] = $file_path;
                }
            }
        }

        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }


}
