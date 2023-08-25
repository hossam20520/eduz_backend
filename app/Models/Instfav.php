<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instfav extends Model
{
   
    protected $fillable = [
        'user_id', 
          'inst_id' , 'type'
   ];
    
}
