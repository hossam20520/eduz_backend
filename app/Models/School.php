<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\utils\helpers;
class School extends Model
{
    protected $table = 'schools';
    protected $dates = ['deleted_at'];
    protected $appends = ['Fav'];

    protected $fillable = [
        'id' ,     'en_name', 'ar_name', 'en_info', 
         'ar_info', 'facilities_ar', 'facilities_en',  
         'activities_ar', 'activities_en', 'url',
         'phone', 'activities_image', 'institution_id',    'review_id',  'share', 'image',
         'lat', 'long_a' , 'area_id' ,
          'other_lang' , 'years_accepted' , 'weekend' , 'children_numbers' , 
          'is_accept',
          'selected_ids' ,
          'expense_from' ,
          'expense_to' ,
          'second_lang' , 'first_lang'  , 
          'actives',
          'images_tow'
    ];

 
    protected $casts = [
 
    ];


    public function getFavAttribute()
    {
        $helpers = new helpers();
        $found = $helpers->IsInWhishlistInst($this->id ,  "SCHOOLS");
        // Access the role_name through the relationship
        // $avatar =  '/public/images/avatar/'.$this->avatar;

        // Modify the role_name as needed
        // For example, you can convert it to uppercase
        return  $found;
    }
}

