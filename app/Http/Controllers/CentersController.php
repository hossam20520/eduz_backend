<?php
namespace App\Http\Controllers;
use App\Exports\CentersExport;
use App\Models\Center;
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

class CentersController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Center::class);
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

        $centers = Center::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($centers, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('centers.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('centers.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $centers = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($centers as $center) {
            $item['id'] = $center->id;
            $item['en_name'] = $center->en_name;
            $item['ar_name'] = $center->ar_name;

          

            $item['en_info'] = $center->en_info;
            $item['ar_info'] = $center->ar_info;
            $item['facilities_ar'] = $center->facilities_ar;
            $item['facilities_en'] = $center->facilities_en;
            $item['activities_ar'] = $center->activities_ar;
            $item['activities_en'] = $center->activities_en;
            $item['url'] = $center->url;
            $item['phone'] = $center->phone;
            $item['share'] = $center->share;
            $item['institution'] = Institution::find($center->institution_id)->ar_name;
            $firstimage = explode(',', $center->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Center->activities_image = $request['activities_image'];
        // $Center->institution_id = $request['institution_id'];
        // // $Center->review_id = $request['review_id'];

 

        return response()->json([
 
            'centers' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Center  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Center::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

 
                $helpers = new helpers();
                $Center = new Center;
                $Center =  $helpers->store($Center , $request);
 

          
             $images =  $helpers->StoreImagesV($request , "images");
             $images_tow =   $helpers->StoreImagesV($request , "images_tow");

   
                $Center->image =  $images;
                $Center->images_tow =  $images_tow ;
                $Center->save();

  

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

    //-------------- Update Center  ---------------\
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
        // $this->authorizeForUser($request->user('api'), 'update', Center::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Center = Center::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
 
                     
                $helpers = new helpers();
                $Center =  $helpers->store($Center , $request);

                $imagesa  = $helpers->updateImagesActiv($request , $Center->image,  "images");
                $images_tow  = $helpers->updateImagesActiv($request , $Center->images_tow,  "images_tow");
                $Center->image =  $imagesa;
                $Center->images_tow =  $images_tow;
                $Center->save();

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

    //-------------- Remove Center  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Center::class);

        \DB::transaction(function () use ($id) {

            $Center = Center::findOrFail($id);
            $Center->deleted_at = Carbon::now();
            $Center->save();

            foreach (explode(',', $Center->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Center::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $center_id) {

                $Center = Center::findOrFail($center_id);
                $Center->deleted_at = Carbon::now();
                $Center->save();

                foreach (explode(',', $Center->image) as $img) {
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

    //-------------- Export All Center to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Center::class);

        return Excel::download(new CentersExport, 'List_Centers.xlsx');
    }




    //--------------  Show Center Details ---------------\
    public function Get_Centers_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Center::class);

        $Center = Center::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Center->id;
        $item['ar_name'] = $Center->ar_name;
        $item['en_name'] = $Center->en_name;
 
        $item['en_info'] = $Center->en_info;
        $item['ar_info'] = $Center->ar_info;

        $item['facilities_ar'] = $Center->facilities_ar;
        $item['facilities_en'] = $Center->facilities_en;


        $item['activities_ar'] = $Center->activities_ar;
        $item['activities_en'] = $Center->activities_en;


        $item['url'] = $Center->url;
        $item['phone'] = $Center->phone;


        $item['share'] = $Center->share;
        $item['institution_id'] = $Center->institution_id;

 
   
        if ($Center->image != '') {
            foreach (explode(',', $Center->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Centers By Warehouse -----------------\

 
    //------------ Get center By ID -----------------\

    public function show($id)
    {

        $Center_data = Center::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Center_data['id'];
        $item['ar_name'] = $Center_data['ar_name'];
        $item['en_name'] = $Center_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Center ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', Center::class);
        $Center_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $govs = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
            'govs' => $govs , 
            'centers' =>  $Center_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit Center ---------------\

    public function edit(Request $request, $id)
    {

        $Center_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Center::class);
        $Center = Center::where('deleted_at', '=', null)->findOrFail($id);
        
        
        $helpers = new helpers();
        $item =  $helpers->edit( $Center );
        // $images = $helpers->editImageV($Center->image, "images",  "image");
        // $images_tow = $helpers->editImageV($Center->images_tow, "images_tow",  "image_tow");
        

        // $item[]   = $images;
        // $item[]   =  $images_tow;


        $firstimage = explode(',', $Center->image);
        $item['image'] = $firstimage[0];
        $item['images'] = [];
        if ($Center->image != '' && $Center->image != 'no-image.png') {
            foreach (explode(',', $Center->image) as $img) {
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






        $firstimage = explode(',', $Center->images_tow);
        $item['image_tow'] = $firstimage[0];
        $item['images_tow'] = [];
        if ($Center->images_tow != '' && $Center->images_tow != 'no-image.png') {
            foreach (explode(',', $Center->images_tow) as $img) {
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
        $drops =  $this->getSectionsWithDrops( $Center->selected_ids);
        $goves = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
           
            'center' => $data, 
            'govs' => $goves,
            'drops' => $drops,
       
            'centers' =>  $Center_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Centers
    public function import_centers(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('centers');
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


                 

                    //-- Create New Center
                    foreach ($data as $key => $value) {
    
 
                        $Center = new Center;
                        $Center->ar_name = $value['ar_name'] ;
                        $Center->en_name = $value['en_name'] ;
 
                        $Center->image = 'no-image.png';
                        $Center->save();

                
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