<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'approve',   
    ];

    protected $casts = [
 
    ];



}

