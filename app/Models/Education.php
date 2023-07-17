<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'en_name', 'ar_name', 'en_info', 
         'ar_info', 'facilities_ar', 'facilities_en',  
         'activities_ar', 'activities_en', 'url',
         'phone', 'activities_image', 'institution_id',    'review_id',  'share', 'image',
         'lat', 'long_a' , 'area_id'
    ];

    protected $casts = [
 
    ];



}

