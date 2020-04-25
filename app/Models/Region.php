<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
class Region extends Model
{
    use CrudTrait;
    use Notifiable;
    use HasRoles;
    protected $fillable = [
        
        'region_name',
        'description',
    ];
}
