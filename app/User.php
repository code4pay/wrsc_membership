<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\NullQueue;
use Illuminate\Support\Str;
use Monolog\Handler\NullHandler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Venturecraft\Revisionable\RevisionableTrait;
class User extends Authenticatable 
{
    use CrudTrait;
    use Notifiable;
    use HasRoles;
    use RevisionableTrait;
    use HasFactory;

    protected $table = 'users';
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
        'primary_member_id',
        'comments',
        'image',
        'receipt_date', 
        'receipt_number',
        'dont_renew',
        'tac_date',
        'tac_email_date',
        'lyssa_serology_comment',
        'dob',
        'documents',
        'pending_approval'
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
        'date_of_birth' => 'datetime',
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
        return $this->hasMany('App\User','primary_member_id');
    }
    public function primary() {
           return $this->belongsTo('App\User','primary_member_id','id');
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
        $token->token = Str::random(50);
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


    public function renewalAmount($isApplication=false)
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
         if ($isApplication){
         
             $primaryFeeOverrideOnApplication = config('app.primary_member_fee_override_on_application');
             if (isset($primaryFeeOverrideOnApplication)){
                return config('app.primary_member_fee_override_on_application');
             }
         } 

         return config('app.primary_member_fee');
          

    }

    public function totalRenewalAmount($isApplication=false)
    {
        $amount = $this->renewalAmount($isApplication);
        foreach($this->siblings()->get() as $sibling){
            $amount = $amount + $sibling->renewalAmount($isApplication);
        }
        return $amount;
    }

    public function totalApplicationAmount()
    {
        return config('app.application_fee') + $this->totalRenewalAmount(true);
    }

    public function addComment($comment,  $user='system')
    {
        $comments = json_decode($this->comments);
        if (!$comments) { $comments = [];}
        array_push($comments,['comment'=> $comment, 'date' => date('Y-m-d'), 'author' => $user]); 
        $this->comments = json_encode($comments);
    }

    public function getCommentsAsArray()
    {
        
        $comments = json_decode($this->comments,1);
        return $comments;
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
        if (Str::startsWith($value, 'data:image'))
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
