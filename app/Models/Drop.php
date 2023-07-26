<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drop extends Model
{
    protected $table = 'drops';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', 'type' , 'section_type'
    ];

    protected $casts = [
 
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Section' , 'section_type');
    }




}

