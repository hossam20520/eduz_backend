<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calander extends Model
{
    protected $table = 'calanders';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'place', 'user_id', 'time' ,  'date' ,  'with_one' ,'with_tow' ,
 
    ];
}
