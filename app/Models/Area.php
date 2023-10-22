<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name',   'gov_id'
    ];

    protected $casts = [
 
    ];

    public function Gov()
    {
        return $this->belongsTo('App\Models\Gov' , 'gov_id');
    }

}

