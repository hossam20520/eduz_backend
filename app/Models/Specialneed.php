<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\utils\helpers;
class Specialneed extends Model
{
    protected $table = 'specialneeds';
    protected $dates = ['deleted_at'];
    protected $appends = ['Fav'];
    protected $fillable = [
         'en_name', 'ar_name', 'en_info', 
         'ar_info', 'facilities_ar', 'facilities_en',  
         'activities_ar', 'activities_en', 'url',
         'phone', 'activities_image', 'institution_id',    'review_id',  'share', 'image',
         'lat', 'long_a' , 'area_id'  ,   'selected_ids'  ,  'gov'
    ];

    protected $casts = [
 
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getFavAttribute()
    {
    
        $helpers = new helpers();
        $found = $helpers->IsInWhishlistInst($this->id ,  "SPECIALNEEDS");
     
        return  $found;
    }
}
