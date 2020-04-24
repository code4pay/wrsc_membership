<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class CourseUser extends Model

{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'course_by',
        'date_completed',
        'upload',
    ];
    public function user() {
        return $this->belongsTo('\App\Models\BackpackUser');
    }

    public function course() {
        return $this->belongsTo('\App\Models\Course');
    }
    public function setUploadAttribute($value)
    {
        $attribute_name = "upload";
        $disk = "public";
        $destination_path = "folder";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
