<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kindergarten extends Model
{
    protected $table = 'kindergartens';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'en_name', 'ar_name', 'en_info', 
        'ar_info', 'facilities_ar', 'facilities_en',  
        'activities_ar', 'activities_en', 'url',
        'phone', 'activities_image', 'institution_id',    'review_id',  'share', 'image',
        'lat', 'long_a' , 'area_id' ,   'selected_ids'  ,    'gov'  ,  'images_tow',
   ];


    protected $casts = [
 
    ];


    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}

