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
        $idsString = $request->ids;

        $areas = Area::where('deleted_at', '=', null )->get();



       if( $type == "TEACHERS"){
       $teacher =  Teacher::where('deleted_at', '=', null )->get();
       return response()->json([
        'countries' => $areas,
        'inst' =>   [],
         'teacher' =>  $teacher ]);
       }else  if($type == "SCHOOL") {

        if (!is_null($idsString)) {
        $idsArray = explode(',', $idsString);
        $education = School::where('deleted_at', '=', null)->where(function ($query) use ($idsArray) {
          foreach ($idsArray as $id) {
              $query->orWhereJsonContains('selected_ids', (int)$id);
             }
        })->get();



        return response()->json([

          'countries' => $areas ,
          'inst' =>  $education,
          'teacher' =>  []
  
          ]);

          

        }else{
          $education = School::where('deleted_at', '=', null)->get();


    //     $idsString = $request->ids;


    //     if (!is_null($idsString)) {

 
    //     $idsArray = explode(',', $idsString);
    //     $education = School::where('deleted_at', '=', null)->where(function ($query) use ($idsArray) {
    //       foreach ($idsArray as $id) {
    //           $query->orWhereJsonContains('selected_ids', (int)$id);
    //          }
    //     })->get();


      
    //   return response()->json([

    //     'countries' => $areas ,
    //     'inst' =>  $education,
    //     'teacher' =>  []

    //     ]);
 

    // }

    return response()->json([

        'countries' => $areas ,
        'inst' =>  $education,
        'teacher' =>  []

        ]);
    

       }





         
    }
}
