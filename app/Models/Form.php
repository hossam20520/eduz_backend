<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'Kid Name', 'en_name',  
    ];

    protected $casts = [
 
    ];



}

