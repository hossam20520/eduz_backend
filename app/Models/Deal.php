<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', "image"
    ];

    protected $casts = [
 
    ];



}

