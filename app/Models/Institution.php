<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'institutions';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', 'image',
    ];

    protected $casts = [
 
    ];



}

