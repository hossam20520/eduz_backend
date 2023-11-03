<?php
namespace App\Http\Controllers;
use App\Exports\SchoolsExport;
use App\Models\School;
use App\Models\Area;
use App\Models\Section;
use App\Models\Gov;


use App\Models\Institution;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use \Gumlet\ImageResize;
use Intervention\Image\ImageManagerStatic as Image;

class SchoolsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', School::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        // Filter fields With Params to retrieve
        $columns = array(0 => 'ar_name', 1 => 'en_name' );
        $param = array(0 => 'like', 1 => '='   );
        $data = array();

        $schools = School::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($schools, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('schools.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('schools.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $schools = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($schools as $school) {
            $item['id'] = $school->id;
            $item['en_name'] = $school->en_name;
            $item['ar_name'] = $school->ar_name;

          

            $item['en_info'] = $school->en_info;
            $item['ar_info'] = $school->ar_info;
            $item['facilities_ar'] = $school->facilities_ar;
            $item['facilities_en'] = $school->facilities_en;
            $item['activities_ar'] = $school->activities_ar;
            $item['activities_en'] = $school->activities_en;
            $item['url'] = $school->url;
            $item['phone'] = $school->phone;
            $item['share'] = $school->share;
            $item['institution'] = Institution::find($school->institution_id)->ar_name;
            $firstimage = explode(',', $school->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $School->activities_image = $request['activities_image'];
        // $School->institution_id = $request['institution_id'];
        // // $School->review_id = $request['review_id'];

 

        return response()->json([
 
            'schools' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  School  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', School::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

 
                $helpers = new helpers();
                $School = new School;
                $School =  $helpers->store($School , $request);
 

             $helpers = new helpers();
             $images =  $helpers->StoreImagesV($request , "images");
             $images_tow =   $helpers->StoreImagesV($request , "images_tow");

   
                $School->image =  $images;
                $School->images_tow =  $images_tow ;
                $School->save();

  

            }, 10);

            return response()->json(['success' => true]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'msg' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }

    }

    //-------------- Update School  ---------------\
    //-----------------------------------------------\


    public function getSectionsWithDrops($ids)
    {

        $dropIds = json_decode($ids, true);
        // $sections = Section::with('drop')->get();
        $sections = Section::with(['drop' => function ($query) use ($dropIds) {
            $query->whereIn('id', $dropIds);
        }])->whereHas('drop', function ($query) use ($dropIds) {
            $query->whereIn('id', $dropIds);
        })->get();

        $data = [];
        foreach ($sections as $section) {
            $sectionData = [
                'id' => $section->id,
                'ar_name' => $section->ar_name,
                'en_name' => $section->en_name,
                'type' => $section->type,
                'created_at' => $section->created_at,
                'updated_at' => $section->updated_at,
                'deleted_at' => $section->deleted_at,
                'drop' => $section->drop->map(function ($drop) {
                    return [
                        'id' => $drop->id,
                        'ar_name' => $drop->ar_name,
                        'en_name' => $drop->en_name,
                        'type' => $drop->type,
                        'section_type' => $drop->section_type,
                        'created_at' => $drop->created_at,
                        'updated_at' => $drop->updated_at,
                        'deleted_at' => $drop->deleted_at,
                    ];
                }),
            ];

            $data[] = $sectionData;
        }

        $result =  $data ;

        return response()->json($result);
    }


public function StoreImage($name , $pathUrl , $request){
    if ($request->hasFile($name)) {

        $image = $request->file($name);
        $filename_logo = rand(11111111, 99999999) . $image->getClientOriginalName();

        $image_resize = Image::make($image->getRealPath());
        // $image_resize->resize(200, 200);
        $image_resize->save(public_path('/images/'.$pathUrl."/".$filename_logo));

    } else {
        $filename_logo = 'no-image.png';
    }

 

    return  $filename_logo;
}

  public function UpdateImage($name , $pathURL , $request ,  $requImage , $currentImage ){
    if ($currentImage &&  $requImage != $currentImage) {
        $image = $request->file($name);
        $path = public_path() . '/images/'. $pathURL;
        $filename_logo = rand(11111111, 99999999) . $image->getClientOriginalName();

        $image_resize = Image::make($image->getRealPath());
        // $image_resize->resize(200, 200);
        $image_resize->save(public_path('/images/'.$pathURL.'/'. $filename_logo));

        $BrandImage = $path . '/' . $currentImage;
        if (file_exists($BrandImage)) {
            if ($currentImage != 'no-image.png') {
                @unlink($BrandImage);
            }
        }
    } else if (!$currentImage && $requImage !='null'){
        $image = $request->file($name);
        $path = public_path() . '/images/'.$pathURL;
        $filename_logo = rand(11111111, 99999999) . $image->getClientOriginalName();

        $image_resize = Image::make($image->getRealPath());
        // $image_resize->resize(200, 200);
        $image_resize->save(public_path('/images/'.$pathURL.'/'.  $filename_logo));
    }

    else {
        $filename_logo = $currentImage?$currentImage:'no-image.png';
    }


    return $filename_logo;
  }



    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', School::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $School = School::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
 
                     
                $helpers = new helpers();


            
                $School =  $helpers->store($School , $request);
                //-- Update School
               

 

   
                // $logo =  $this->UpdateImage( 'logo',  "educations" , $request , $request->logo , $School->logo );
              
                  $imagesa  = $helpers->updateImagesActiv($request , $School->image,  "images");
                  $images_tow  = $helpers->updateImagesActiv($request , $School->images_tow,  "images_tow");

                // $banner =  $this->UpdateImage( 'banner',  "educations" , $request , $request->banner , $School->banner );
 
                $School->image =  $imagesa;
                $School->images_tow =  $images_tow;
       
                $School->save();

            }, 10);

            return response()->json(['success' => true]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'msg' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }

    }

    //-------------- Remove School  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', School::class);

        \DB::transaction(function () use ($id) {

            $School = School::findOrFail($id);
            $School->deleted_at = Carbon::now();
            $School->save();

            foreach (explode(',', $School->image) as $img) {
                $pathIMG = public_path() . '/images/educations/' . $img;
                if (file_exists($pathIMG)) {
                    if ($img != 'no-image.png') {
                        @unlink($pathIMG);
                    }
                }
            }

   

        }, 10);

        return response()->json(['success' => true]);

    }


      //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', School::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $school_id) {

                $School = School::findOrFail($school_id);
                $School->deleted_at = Carbon::now();
                $School->save();

                foreach (explode(',', $School->image) as $img) {
                    $pathIMG = public_path() . '/images/educations/' . $img;
                    if (file_exists($pathIMG)) {
                        if ($img != 'no-image.png') {
                            @unlink($pathIMG);
                        }
                    }
                }

            
            }

        }, 10);

        return response()->json(['success' => true]);

    }

    //-------------- Export All School to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', School::class);

        return Excel::download(new SchoolsExport, 'List_Schools.xlsx');
    }




    //--------------  Show School Details ---------------\
    public function Get_Schools_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', School::class);

        $School = School::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $School->id;
        $item['ar_name'] = $School->ar_name;
        $item['en_name'] = $School->en_name;
 
        $item['en_info'] = $School->en_info;
        $item['ar_info'] = $School->ar_info;

        $item['facilities_ar'] = $School->facilities_ar;
        $item['facilities_en'] = $School->facilities_en;


        $item['activities_ar'] = $School->activities_ar;
        $item['activities_en'] = $School->activities_en;


        $item['url'] = $School->url;
        $item['phone'] = $School->phone;


        $item['share'] = $School->share;
        $item['institution_id'] = $School->institution_id;

 
   
        if ($School->image != '') {
            foreach (explode(',', $School->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Schools By Warehouse -----------------\

 
    //------------ Get school By ID -----------------\

    public function show($id)
    {

        $School_data = School::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $School_data['id'];
        $item['ar_name'] = $School_data['ar_name'];
        $item['en_name'] = $School_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create School ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', School::class);
        $School_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $govs = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
            'govs' => $govs , 
            'schools' =>  $School_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit School ---------------\

    public function edit(Request $request, $id)
    {

        $School_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', School::class);
        $School = School::where('deleted_at', '=', null)->findOrFail($id);
        
        
        $helpers = new helpers();
        $item =  $helpers->edit( $School );
        // $images = $helpers->editImageV($School->image, "images",  "image");
        // $images_tow = $helpers->editImageV($School->images_tow, "images_tow",  "image_tow");
        

        // $item[]   = $images;
        // $item[]   =  $images_tow;


        $firstimage = explode(',', $School->image);
        $item['image'] = $firstimage[0];
        $item['images'] = [];
        if ($School->image != '' && $School->image != 'no-image.png') {
            foreach (explode(',', $School->image) as $img) {
                $path = public_path() . '/images/educations/' . $img;
                if (file_exists($path)) {
                    $itemImg['name'] = $img;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $item['images'][] = $itemImg;
                }
            }
        } else {
            $item['images'] = [];
        }






        $firstimage = explode(',', $School->images_tow);
        $item['image_tow'] = $firstimage[0];
        $item['images_tow'] = [];
        if ($School->images_tow != '' && $School->images_tow != 'no-image.png') {
            foreach (explode(',', $School->images_tow) as $img) {
                $path = public_path() . '/images/educations/' . $img;
                if (file_exists($path)) {
                    $itemImg['name'] = $img;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $item['images_tow'][] = $itemImg;
                }
            }
        } else {
            $item['images_tow'] = [];
        }


        // $item[]   = $images_tow;

        // $data = array();
       
        $data = $item;
 
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $drops =  $this->getSectionsWithDrops( $School->selected_ids);
        $goves = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
           
            'school' => $data, 
            'govs' => $goves,
            'drops' => $drops,
       
            'schools' =>  $School_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Schools
    public function import_schools(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('schools');
                $ext = pathinfo($file_upload->getClientOriginalName(), PATHINFO_EXTENSION);
                if ($ext != 'csv') {
                    return response()->json([
                        'msg' => 'must be in csv format',
                        'status' => false,
                    ]);
                } else {
                    $data = array();
                    $rowcount = 0;
                    if (($handle = fopen($file_upload, "r")) !== false) {

                        $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
                        $header = fgetcsv($handle, $max_line_length);
                        $header_colcount = count($header);
                        while (($row = fgetcsv($handle, $max_line_length)) !== false) {
                            $row_colcount = count($row);
                            if ($row_colcount == $header_colcount) {
                                $entry = array_combine($header, $row);
                                $data[] = $entry;
                            } else {
                                return null;
                            }
                            $rowcount++;
                        }
                        fclose($handle);
                    } else {
                        return null;
                    }


                 

                    //-- Create New School
                    foreach ($data as $key => $value) {
    
 
                        $School = new School;
                        $School->ar_name = $value['ar_name'] ;
                        $School->en_name = $value['en_name'] ;
 
                        $School->image = 'no-image.png';
                        $School->save();

                
                    }
                
                }
            }, 10);
            return response()->json([
                'status' => true,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'error',
                'errors' => $e->errors(),
            ]);
        }

    }


    // Generate_random_code
    public function generate_random_code($value_code)
    {
        if($value_code == ''){
            $gen_code = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 8);
            $this->check_code_exist($gen_code);
        }else{
            $this->check_code_exist($value_code);
        }
    }

   }