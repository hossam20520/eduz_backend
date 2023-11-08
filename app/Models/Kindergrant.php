<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\utils\helpers;
class Kindergrant extends Model
{
    protected $table = 'Kindergrants';
    protected $dates = ['deleted_at'];
    protected $appends = ['Fav'];
    protected $fillable = [
        'ar_name', 'en_name',
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
        $found = $helpers->IsInWhishlistInst($this->id ,  "KINDERGARTENS");
     
        return  $found;
    }
}

