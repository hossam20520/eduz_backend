<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $table = 'cats';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', 'image'
    ];

    protected $casts = [
 
    ];



}

