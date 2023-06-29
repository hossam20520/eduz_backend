<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    


  public function GetCategories(Request $request){

       $categories = Category::where('deleted_at', '=', null )->get();

        return response()->json([
          'categories' =>  $categories,
        
  
     ]);



  }


}
