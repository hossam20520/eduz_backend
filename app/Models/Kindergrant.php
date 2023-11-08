<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kindergrant extends Model
{
    protected $table = 'Kindergrants';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name',
    ];

    protected $casts = [
 
    ];


    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}

