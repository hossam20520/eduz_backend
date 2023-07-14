<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;

use App\Models\Teacher;
class InstitutionsController extends Controller
{
    //


    public function GetAllEducation(Request $request ){


      $education =  Education::where('deleted_at', '=', null )->select('id', 'ar_name' , 'en_name' , 'image' , 'lat' , 'long_a' )->get();

      return response()->json([
        'educations' =>  $education,
   

         ]);



    }

    public function get(Request $request  ){

        $id = $request->id;
        $type = $request->type;
       if( $type == "TEACHERS"){
       $teacher =  Teacher::where('deleted_at', '=', null )->get();
       return response()->json([
        'inst' =>   [],
         'teacher' =>  $teacher
 
    ]);
       }else{

        $education =  Education::where('institution_id' , $id)->get();
        return response()->json([
          'inst' =>  $education,
          'teacher' =>  []
  
     ]);

       }





         
    }
}
