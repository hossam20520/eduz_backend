<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', "image"
    ];

    protected $casts = [
 
    ];



}

