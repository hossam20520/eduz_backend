<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Area;
use App\Models\School;

use App\Models\Kindergarten;
use App\Models\Center;
use App\Models\Educenter;
use App\Models\Specialneed;
use App\Models\Universitie;
use App\Models\Institution;



use App\utils\helpers;
use Carbon\Carbon;
use App\Models\Teacher;
class InstitutionsController extends Controller
{
    //

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Institution::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $institutions = Institution::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $institutions->count();
        $institutions = $institutions->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


            $areas = Area::where('deleted_at', '=', null )->get();
   

        return response()->json([
            'countries' => $areas ,
            'institutions' =>$institutions,
            'totalRows' => $totalRows,
        ]);

    }

    public function GetDetailEdu(Request $request ){


      $data = array();
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



         $model  = Kindergarten::class;
        
        if($type == "SCHOOLS"){
          $model = School::class;
        }else if($type == "KINDERGARTENS"){
          $model  = Kindergarten::class;
        }else if($type == "CENTERS"){
          $model  = Center::class;
        }else if($type == "SPECIALNEEDS"){
          $model  = Specialneed::class;
        }
 
        $education = $model::where('deleted_at', '=', null)->where('institution_id' ,  $id  )->where(function ($query) use ($request) {
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



      foreach ($education as $edu) {
        $item['id'] = $edu->id;
        $item['en_name'] = $edu->en_name;
        $item['ar_name'] = $edu->ar_name;
        $item['ar_address'] = $edu->ar_address;
        $item['en_address'] = $edu->en_address;
        $item['location'] =  "Caironn";
        $item['review'] =    "4.2";
        $item['activities_have'] =  [];
        $item['free'] =    $edu->free;
        $firstimage = explode(',', $edu->image);
        $item['image'] = $firstimage[0];
        $item['banner'] = $edu->banner;
        $item['lat'] = $edu->lat;
        $item['long'] = $edu->long_a;
        $item['logo'] = $firstimage[0];


        $data[] = $item;
    }
    
 
      return response()->json([

        'inst' =>  $data,
 
      
      ]);
    

    }



public function MapData(Request $request){

    $type = $request->type;
    
    if($type == "SCHOOLS"){
      $model = School::class;
    }else if($type == "KINDERGARTENS"){
      $model  = Kindergarten::class;
    }else if($type == "CENTERS"){
      $model  = Center::class;
    }else if($type == "SPECIALNEEDS"){
      $model  = Specialneed::class;
    } 

     $dataa  = $model::where('deleted_at', '=', null )->orderBy('id', 'desc')->get(['ar_name' , 'id',  'en_name' , 'lat', 'long_a' , 'image']);

   

     foreach ($dataa as $edu) {
      $item['id'] = $edu->id;
      $item['en_name'] = $edu->en_name;
      $item['ar_name'] = $edu->ar_name;
      $firstimage = explode(',', $edu->image);
      $item['image'] = $firstimage[0];
      $item['banner'] = $edu->banner;
      $item['lat'] = $edu->lat;
      $item['long'] = $edu->long_a;
 


      $data[] = $item;
  }

            
     return response()->json([
      'inst' =>  $data,
    ]);

}


    public function GetTheInstDetail(Request $request ){

        
      $model = School::class;


      $type = $request->type;
      $id = $request->id;

      if($type == "SCHOOLS"){
        $model = School::class;
      }else if($type == "KINDERGARTENS"){
        $model  = Kindergarten::class;
      }else if($type == "CENTERS"){
        $model  = Center::class;
      }else if($type == "SPECIALNEEDS"){
        $model  = Specialneed::class;
      }

      $data  = $model::where('id' , $id )->first();

      return response()->json([

        'detail' =>  $data,
        'files' => [
          [
            "id" => 1 ,
            "file" => "https://th.bing.com/th/id/OIG.lVXjWwlHyIo4QdjnC1YE",
            "type" => "image"
          ],
          [
            "id" => 2 ,
            "file" => "nPt8bK2gbaU",
            "type" => "video"
          ],


          
        ]
 
      
      ]);


    }





    public function GetAllEducation(Request $request ){

      



      $id =  $request->id;
      $education =  Education::where('deleted_at', '=', null )->select('id', 'ar_name' , 'en_name' , 'image' , 'lat' , 'long_a' )->get();
      $schools =  School::where('deleted_at', '=', null )->select('id', 'ar_name' , 'en_name' , 'image' , 'lat' , 'long_a' )->get();





      return response()->json([
        'educations' =>  $education,
        'schools'=> $schools 

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
       }else if($type == "EDUSERVICES"){

        $model  = Kindergarten::class;

        
       } else {

        
        if($type == "SCHOOLS"){
          $model = School::class;
        }else if($type == "KINDERGARTENS"){
          $model  = Kindergarten::class;
        }else if($type == "CENTERS"){
          $model  = Center::class;
        }else if($type == "EDUCENTERS"){
          $model  = Educenter::class;
        }else if($type == "SPECIALNEEDS"){
          $model  = Specialneed::class;
        }else if($type == "UNIVERSITIES"){
          $model  = Universitie::class;
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


    // $education = $model::where('deleted_at', '=', null)->get();
    return response()->json([
        'countries' => $areas ,
        'inst' =>  $education,
        'teacher' =>  [] ]);
  }




 


}
      
    }

    }
 
