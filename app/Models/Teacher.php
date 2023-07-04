<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', "ar_country",
        'en_country', 'en_subject', "ar_subject",
        'age_from', 'age_to', "ar_about",
        'en_about', 'share', "image" , "user_id",
        'lat', 'long_a'
    ];

    protected $casts = [
 
    ];

 
}

