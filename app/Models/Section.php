<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name' , 'type'
    ];

    protected $casts = [
 
    ];


    public function drop()
    {
        return $this->hasMany('App\Models\Drop' , 'section_type');
    }



    
}

