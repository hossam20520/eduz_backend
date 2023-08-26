<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Recently extends Model
{
    protected $table = 'recentlys';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', 
    ];

    protected $casts = [
 
    ];



}

