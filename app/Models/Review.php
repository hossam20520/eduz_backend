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


    public function user()
    {
        return $this->belongsTo('App\Models\User' , 'user_id');
    }



}

