<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Area;
use App\Models\School;
use App\Models\Blog;
use App\Models\Kindergarten;
use App\Models\Center;
use App\Models\Educenter;
use App\Models\Specialneed;
use App\Models\Universitie;
use App\Models\Institution;
use App\Models\Review;
use App\Models\Recently;
use App\Models\Drop;
use App\Models\Section;

use App\Models\Product;
use App\utils\helpers;
use Carbon\Carbon;
use App\Models\Teacher;
use App\Models\Deal;
use App\Models\Gov;


class InstitutionsController extends Controller
{
    //


  public function getgov(Request $request){
    $area = Gov::where('deleted_at' , '=' ,   null  )->get();
    return response()->json([   'govs'=>    $area ], 200);

  }
    public function getAreaa(Request $request){
      $gov_id = $request->gov_id;
      $area = Area::where('gov_id' ,$gov_id )->get();

      
      return response()->json([   'areas'=>    $area ], 200);

    }

    public function SendReview(Request $request){  
      $review_id = $request->id;
      $count = $request->count;
      $review = $request->review;
 
      Review::where('deleted_at', '=', null)->where('id' , $review_id)->update([
          'review'=> $review,
          'count'=> $count
      ]);
     
      return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
       
    }




    public function reviews(Request $request){
        // $this->authorizeForUser($request->user('api'), 'view', Review::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $reviews = Review::with('user')->where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $reviews->count();
        $reviews = $reviews->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


          $data = array();
            foreach ( $reviews  as   $value) {
               $item['name']  = $value->user->firstname." ". $value->user->lastname;
               $item['image']  =  "/public/images/avatar/".$value->user->avatar;
               $item['count']  = $value->count;
               $item['review'] = $value->review;
               $data[] = $item;

            }

        return response()->json([
            'reviews' => $data,
       
            // 'totalRows' => $totalRows,
        ]);



    }


    public function GetSearchData($model , $search , $type  , $offSet , $perPage , $order , $dir ){


      if($type == "EDUSERVICES"){


        $deals = $model::where('deleted_at', '=', null)->where(function ($query) use ($search) {
          return $query->when($search, function ($query) use ($search) {
              return $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
          });
      });


 

      }else{
        $deals = $model::where('deleted_at', '=', null)->where(function ($query) use ($search) {
          return $query->when($search, function ($query) use ($search) {
              return $query->where('ar_name', 'LIKE', "%{$search}%")
                  ->orWhere('en_name', 'LIKE', "%{$search}%");
          });
      });
      }

  

      $totalRows = $deals->count();
      $deals = $deals->offset($offSet)
          ->limit($perPage)
          ->orderBy($order, $dir)
          ->get();

          $data = array();
          if($type == "EDUSERVICES"){
            foreach ($deals as   $deal) {
              $item['id'] = $deal->id;
              $item['ar_name'] = $deal->name;
              $item['en_name'] = $deal->code;


              $item['type'] = $type;
              $firstimage = explode(',', $deal->image);
              $item['image'] =   '/public/images/products/'. $firstimage[0];
              $data[] = $item;
            
          }

          }else{
            foreach ($deals as   $deal) {
              $item['id'] = $deal->id;
              $item['ar_name'] = $deal->ar_name;
              $item['en_name'] = $deal->en_name;
              $item['type'] = $type;
              $item['ar_address'] = $deal->ar_address;
              $item['en_address'] = $deal->en_address;
              $item['acti']  = $deal->actives;

              $firstimage = explode(',', $deal->image);
              $item['image'] =   '/public/images/educations/'. $firstimage[0];
              $data[] = $item;
            
          }
          }
  
           
       

      return   $data;
    }


    public function search(Request $request){

      $perPage = $request->limit;
      $pageStart = \Request::get('page', 1);
      // Start displaying items from this number;
      $offSet = ($pageStart * $perPage) - $perPage;
      $order = $request->SortField;
      $dir = $request->SortType;
      $helpers = new helpers();

      $area_id = $request->area_id;
      if( $request->type == "filter"){

        $typeinsta = $request->type_inst;
      $ids = $request->ids;
      
      $selected_id = $request->selected_id;

      $model = School::class;
      if( $typeinsta == "SCHOOLS"){
        $model = School::class;
      }else if( $typeinsta == "KINDERGARTENS"){
        $model  = Kindergarten::class;
      }else if( $typeinsta == "CENTERS"){
        $model  = Center::class;
      }else if( $typeinsta == "EDUCENTERS"){
        $model  = Educenter::class;
      }else if($typeinsta == "SPECIALNEEDS"){
        $model  = Specialneed::class;
      }else if( $typeinsta == "UNIVERSITIES"){
        $model  = Universitie::class;
      } 
     
     
            $idsArray = explode(',', $ids);
  
         
              $query = $model::query();
              
              // if( $area_id  != "0"){
              //   $query->where('area_id', $area_id);
              // }
              $idsToRemove = [9, 10]; // Numbers to be removed

              $idsArray = array_diff($idsArray, $idsToRemove);
        
              foreach ($idsArray as $id) {
             
                $query->whereRaw('FIND_IN_SET(?, selected_ids) > 0', [$id]);
                $drop =  Drop::where('id' , $id )->first();
                $section = Section::where('id' , $drop->section_type)->first();

                if( $section->en_name ==   "Area" ){
                  $query->orWhereRaw('FIND_IN_SET(?, selected_ids) > 0', [$id]);
                }
      
                }

              // foreach ($idsArray as $id) {
              // $query->whereRaw('FIND_IN_SET(?, selected_ids) > 0', [$id]);
              
              // }



           
            //   $query->where(function ($query) use ($idsArray) {
            //     foreach ($idsArray as $id) {
            //         $query->orWhereRaw('FIND_IN_SET(?, selected_ids) > 0', [$id]);
            //     }
            // });  

              $results = $query->get();
              // $results = $query->whereIn('id', $idsArray)
              // ->groupBy('id')
              // ->havingRaw('COUNT(*)', '=', count($idsArray))
              // ->get();

              $count = $query->count();

            $data_search = array();
             foreach ($results as   $da) {
              $item['id'] = $da->id;
              $item['ar_name'] = $da->ar_name;
              $item['en_name'] = $da->en_name;
              $item['ar_address'] = $da->ar_address;
              $item['en_address'] = $da->en_address;
              $item['acti']  = $da->actives;
              $item['type'] =  $typeinsta;
              $firstimage = explode(',', $da->image);
         
              $item['image'] = "/images/educations/".$firstimage[0];
              $data_search[] = $item;
             }

             return response()->json([
              'search' =>  $data_search  ,
              'count'=>  $count,
            
          ]);
       
 
      }


 
        $EDUCENTERS = $this->GetSearchData(Educenter::class ,   $request->search , "EDUCENTERS" , $offSet ,$perPage   ,  $order  ,  $dir );
      $SCHOOLS = $this->GetSearchData(School::class ,   $request->search , "SCHOOLS" , $offSet ,$perPage   ,  $order  ,  $dir );
      $KINDERGARTENS = $this->GetSearchData(Kindergarten::class ,   $request->search , "KINDERGARTENS" , $offSet ,$perPage   ,  $order  ,  $dir );
      $SPECIALNEEDS = $this->GetSearchData(Specialneed::class ,   $request->search , "SPECIALNEEDS" , $offSet ,$perPage   ,  $order  ,  $dir );
      $UNIVERSITIES = $this->GetSearchData(Universitie::class ,   $request->search , "UNIVERSITIES" , $offSet ,$perPage   ,  $order  ,  $dir );
      $CENTERS = $this->GetSearchData(Center::class ,   $request->search , "CENTERS" , $offSet ,$perPage   ,  $order  ,  $dir );
      $EDUSERVICES = $this->GetSearchData(Product::class ,   $request->search , "EDUSERVICES" , $offSet ,$perPage   ,  $order  ,  $dir );
      $allResults = array_merge($SCHOOLS, $KINDERGARTENS, $SPECIALNEEDS, $UNIVERSITIES, $CENTERS , $EDUSERVICES ,  $EDUCENTERS);


      return response()->json([
        'search' => $allResults  ,
      
    ]);

    

    }


    public function deals(Request $request){

      $perPage = $request->limit;
      $pageStart = \Request::get('page', 1);
      // Start displaying items from this number;
      $offSet = ($pageStart * $perPage) - $perPage;
      $order = $request->SortField;
      $dir = $request->SortType;
      $helpers = new helpers();

      $deals = Deal::where('deleted_at', '=', null)->where(function ($query) use ($request) {
              return $query->when($request->filled('search'), function ($query) use ($request) {
                  return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                      ->orWhere('en_name', 'LIKE', "%{$request->search}%");
              });
          });
      $totalRows = $deals->count();
      $deals = $deals->offset($offSet)
          ->limit($perPage)
          ->orderBy($order, $dir)
          ->get();

          $data = array();
            foreach ($deals as   $deal) {
                $item['id'] = $deal->id;
                $item['ar_name'] = $deal->ar_name;
                $item['en_name'] = $deal->en_name;
                $item['ar_desc'] = $deal->ar_desc;
                $item['en_desc'] = $deal->en_desc;
                $item['type'] = $deal->type;
                $item['child_id'] = $deal->child_id;
                $item['image'] =   '/public/images/deals/'. $deal->image;
 

                $data[] = $item;
              # code...
            }

      return response()->json([
          'deals' => $data,
          'totalRows' => $totalRows,
      ]);


    }

    public function GetRecently(Request $request){
    
          // $this->authorizeForUser($request->user('api'), 'view', Recently::class);
          // How many items do you want to display.
          $perPage = $request->limit;
          $pageStart = \Request::get('page', 1);
          // Start displaying items from this number;
          $offSet = ($pageStart * $perPage) - $perPage;
          $order = $request->SortField;
          $dir = $request->SortType;
          $helpers = new helpers();
  
          $recentlys = Recently::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                  return $query->when($request->filled('search'), function ($query) use ($request) {
                      return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                          ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                  });
              });
          $totalRows = $recentlys->count();
          $recentlys = $recentlys->offset($offSet)
              ->limit($perPage)
              ->orderBy($order, $dir)
              ->get();
  
  
              $data = array();
  
              foreach ($recentlys as  $recen) {
  
               $type =  $recen->type;
  
               $model = School::class;
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
               
               $modV  = $model::where('id' ,$recen->child_id )->first();
                  $item['id'] =  $modV->id;
                  $item['ar_name'] =  $modV->ar_name;
                  $item['en_name'] =  $modV->en_name;
                  $item['type'] =  $recen->type;
                  $firstimage = explode(',', $modV->image);
                  $item['image'] =  '/public/images/educations/'.$firstimage[0];
                  $data[] = $item;
                  # code...
              }
  
          return response()->json([
              'recentlys' =>  $data,
              'totalRows' => $totalRows,
          ]);
  
     
    }

    public function gettypesinst(Request $request){

       $type = $request->type;

       
       $model = School::class;
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
 
      $list =  $model::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
       
      // $secion = Section::where('type',  $type)->where('deleted_at', '=', null)->get(['id', 'ar_name' ,'en_name' ]);

      return response()->json(['types' => $list]);
 

    }

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


    public function GetOneBlog(Request $request){
      $id = $request->id;

      $blog = Blog::where('deleted_at', '=', null)->where('id' ,$id )->first();
      return response()->json([
        'blog' => $blog,
        
    ]);

    }

    public function GetBlogs(Request $request){

      $perPage = $request->limit;
      $pageStart = \Request::get('page', 1);
      // Start displaying items from this number;
      $offSet = ($pageStart * $perPage) - $perPage;
      $order = $request->SortField;
      $dir = $request->SortType;
      $helpers = new helpers();

      $areas = Blog::where('deleted_at', '=', null)->where(function ($query) use ($request) {
              return $query->when($request->filled('search'), function ($query) use ($request) {
                  return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                      ->orWhere('en_name', 'LIKE', "%{$request->search}%");
              });
          });
      $totalRows = $areas->count();
      $areas = $areas->offset($offSet)
          ->limit($perPage)
          ->orderBy($order, $dir)
          ->get();

      return response()->json([
          'blogs' => $areas,
          'totalRows' => $totalRows,
      ]);

    }





    public function UploadFile(Request $request){

  
        if ($request->hasFile('files')) {
          $uploadedFileNames = [];
            foreach ($request->file('files') as $file) {
                // Store or process each file as needed
                // $file->store('uploads');
                // $name = $file->getClientOriginalName();
           

                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                // Generate a unique filename
                $newFileName = rand(11111111, 99999999) . '_' . $originalName;
    
                $path = public_path('images/uploads/');
                
                $file->move($path, $newFileName);



                // Specify the directory where you want to store the files
                // $path = public_path('images/uploads/');
                
                // Move the uploaded file to the specified path
                // $file->move($path, $name);
                $uploadedFileNames[] = $newFileName;
                // $path = public_path() . '/images/educations/';
                // $success = file_put_contents($path . $name, $fileData);

            }
            $fileNamesString = implode(",", $uploadedFileNames);
           
            return response()->json(['files' => $fileNamesString]);
        }
        return response()->json(['files' => 'noImage.png'], 400);
   

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
        }else if($type == "UNIVERSITIES"){
          $model  = Universitie::class;
        }else if($type == "EDUCENTERS"){
          $model  = Educenter::class;
        }
 
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
        $item['acti'] = $edu->actives;

        $data[] = $item;
    }
    
 
      return response()->json([

        'inst' =>  $data,
        'total'=>  $totalRows
 
      
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
    else if( $type == "EDUCENTERS"){
      $model  = Educenter::class;
    } else if( $type == "UNIVERSITIES"){
      $model  = Universitie::class;
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




public function GetTheInstDetailNoAuth(Request $request ){

        
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
  }else if($type == "UNIVERSITIES"){
    $model  = Universitie::class;
  } else if( $typeinsta == "EDUCENTERS"){
    $model  = Educenter::class;
  }

  $data  = $model::where('id' , $id )->first();
  // $model->getFavAttribute(true);
  $reviews  =  Review::with('user')->where('type' , $type )->where('inst_id' ,  $data->id )->get();
 


   $data_images = array();
   foreach (explode(',', $data->images_tow) as $img) {
        $item['file'] =  "/images/educations/". $img;
        $item['type'] = "image";

        $data_images[] = $item;

     }
  
  return response()->json([

    'detail' =>  $data,
    'reviews' =>   $reviews ,
    'files' =>  $data_images

  
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
      }else if($type == "UNIVERSITIES"){
        $model  = Universitie::class;
      }  else if( $typeinsta == "EDUCENTERS"){
        $model  = Educenter::class;
      }

      $data  = $model::where('id' , $id )->first();
      
      $reviews  =  Review::with('user')->where('type' , $type )->where('inst_id' ,  $data->id )->get();


      $data_images = array();
      foreach (explode(',', $data->images_tow) as $img) {
           $item['file'] =  "/images/educations/". $img;
           $item['type'] = "image";
   
           $data_images[] = $item;
   
        }

      
      return response()->json([

        'detail' =>  $data,
        'reviews' =>   $reviews ,
        'files' =>  $data_images
 
      
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
 
