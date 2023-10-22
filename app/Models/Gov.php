<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gov extends Model
{
    protected $table = 'govs';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name',
    ];

    protected $casts = [
 
    ];


 
}

