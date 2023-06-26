<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;


class InstitutionsController extends Controller
{
    //


    public function get(Request $request  ){

        $id = $request->id;
       $education =  Education::where('institution_id' , $id)->get();

       return response()->json([
        'inst' =>  $education,
 
    ]);


         
    }
}
