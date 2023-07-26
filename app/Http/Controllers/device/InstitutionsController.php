<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Area;
use App\Models\School;

use App\utils\helpers;
use Carbon\Carbon;
use App\Models\Teacher;
class InstitutionsController extends Controller
{
    //


    public function GetAllEducation(Request $request ){

      



      $id =  $request->id;
      $education =  Education::where('deleted_at', '=', null )->where('area_id',   $id   )->select('id', 'ar_name' , 'en_name' , 'image' , 'lat' , 'long_a' )->get();





      return response()->json([
        'educations' =>  $education,
   

         ]);



    }

    public function get(Request $request  ){

        $id = $request->id;
        $type = $request->type;
        $idsString = $request->ids;

        $typeSearch = $request->searchType;



        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();







        $areas = Area::where('deleted_at', '=', null )->get();



       if( $type == "TEACHERS"){
       $teacher =  Teacher::where('deleted_at', '=', null )->get();
       return response()->json([
        'countries' => $areas,
        'inst' =>   [],
         'teacher' =>  $teacher ]);
       }else   {

          $model = School::class;
        if($type == "SCHOOLS"){
          $model  = School::class;
        }


  if( $typeSearch == "ids"){
    $idsArray = explode(',', $idsString);
    $education = $model::where('deleted_at', '=', null)->where(function ($query) use ($idsArray) {
      foreach ($idsArray as $id) {
          $query->orWhereJsonContains('selected_ids', (int)$id);
         }
    })->get();



    return response()->json([

      'countries' => $areas ,
      'inst' =>  $education,
      'teacher' =>  []

      ]);

  }else if ($typeSearch == "search"){

    $education = $model::where('deleted_at', '=', null)->where(function ($query) use ($request) {
      return $query->when($request->filled('search'), function ($query) use ($request) {
          return $query->where('ar_name', 'LIKE', "%{$request->search}%")
              ->orWhere('en_name', 'LIKE', "%{$request->search}%");
      });
  });
$totalRows = $education->count();
$education = $education->offset($offSet)
  ->limit($perPage)
  ->orderBy($order, $dir)
  ->get();





  return response()->json([
    'countries' => $areas ,
    'inst' =>  $education,
    'teacher' =>  [] ,
    'search' => 'search'
  
  
  ]);

    
  }else if($typeSearch == "home"){
    $education = $model::where('deleted_at', '=', null)->get();
    return response()->json([
        'countries' => $areas ,
        'inst' =>  $education,
        'teacher' =>  [] ]);
  }




 


}
      
    }

    }
 
