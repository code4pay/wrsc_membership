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
        'comment'
    ];
    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function course() {
        return $this->belongsTo('\App\Models\Course');
    }


}
