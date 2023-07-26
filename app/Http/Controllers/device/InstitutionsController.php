<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Area;
use App\Models\School;


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

        $areas = Area::where('deleted_at', '=', null )->get();



       if( $type == "TEACHERS"){
       $teacher =  Teacher::where('deleted_at', '=', null )->get();
       return response()->json([
        'countries' => $areas,
        'inst' =>   [],
         'teacher' =>  $teacher ]);
       }else if($type == "SCHOOLS"){

        // $education =  Education::where('institution_id' , $id)->get();



        

        $education =  School::where('deleted_at', '=', null )->get();




        return response()->json([
               'countries' => $areas ,
               'inst' =>  $education,
               'teacher' =>  []
  
     ]);

       }





         
    }
}
