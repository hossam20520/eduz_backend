<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourit extends Model
{ 

    protected $table = 'favourits';
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'title', 'user_id', 'teacher_id', 
         'product_id', 'inst_id', 'type'   
    ];


    public function teachers()
    {
        return $this->belongsTo('App\Models\Teacher' , 'teacher_id');
    }
    

   
    public function product()
    {
        return $this->belongsTo('App\Models\Product' , 'product_id');
    }

    

    public function inst()
    {
        return $this->belongsTo('App\Models\Education' , 'inst_id');
    }
}
