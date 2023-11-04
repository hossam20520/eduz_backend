<?php
namespace App\Http\Controllers;
use App\Exports\EducentersExport;
use App\Models\Educenter;
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

class EducentersController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Educenter::class);
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

        $educenters = Educenter::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($educenters, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('educenters.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('educenters.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $educenters = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($educenters as $educenter) {
            $item['id'] = $educenter->id;
            $item['en_name'] = $educenter->en_name;
            $item['ar_name'] = $educenter->ar_name;

          

            $item['en_info'] = $educenter->en_info;
            $item['ar_info'] = $educenter->ar_info;
            $item['facilities_ar'] = $educenter->facilities_ar;
            $item['facilities_en'] = $educenter->facilities_en;
            $item['activities_ar'] = $educenter->activities_ar;
            $item['activities_en'] = $educenter->activities_en;
            $item['url'] = $educenter->url;
            $item['phone'] = $educenter->phone;
            $item['share'] = $educenter->share;
            $item['institution'] = Institution::find($educenter->institution_id)->ar_name;
            $firstimage = explode(',', $educenter->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Educenter->activities_image = $request['activities_image'];
        // $Educenter->institution_id = $request['institution_id'];
        // // $Educenter->review_id = $request['review_id'];

 

        return response()->json([
 
            'educenters' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Educenter  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Educenter::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

 
                $helpers = new helpers();
                $Educenter = new Educenter;
                $Educenter =  $helpers->store($Educenter , $request);
 

          
             $images =  $helpers->StoreImagesV($request , "images");
             $images_tow =   $helpers->StoreImagesV($request , "images_tow");

   
                $Educenter->image =  $images;
                $Educenter->images_tow =  $images_tow ;
                $Educenter->save();

  

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

    //-------------- Update Educenter  ---------------\
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
        // $this->authorizeForUser($request->user('api'), 'update', Educenter::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Educenter = Educenter::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
 
                     
                $helpers = new helpers();
                $Educenter =  $helpers->store($Educenter , $request);

                  $imagesa  = $helpers->updateImagesActiv($request , $Educenter->image,  "images");
                  $images_tow  = $helpers->updateImagesActiv($request , $Educenter->images_tow,  "images_tow");
                $Educenter->image =  $imagesa;
                $Educenter->images_tow =  $images_tow;
                $Educenter->save();

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

    //-------------- Remove Educenter  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Educenter::class);

        \DB::transaction(function () use ($id) {

            $Educenter = Educenter::findOrFail($id);
            $Educenter->deleted_at = Carbon::now();
            $Educenter->save();

            foreach (explode(',', $Educenter->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Educenter::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $educenter_id) {

                $Educenter = Educenter::findOrFail($educenter_id);
                $Educenter->deleted_at = Carbon::now();
                $Educenter->save();

                foreach (explode(',', $Educenter->image) as $img) {
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

    //-------------- Export All Educenter to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Educenter::class);

        return Excel::download(new EducentersExport, 'List_Educenters.xlsx');
    }




    //--------------  Show Educenter Details ---------------\
    public function Get_Educenters_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Educenter::class);

        $Educenter = Educenter::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Educenter->id;
        $item['ar_name'] = $Educenter->ar_name;
        $item['en_name'] = $Educenter->en_name;
 
        $item['en_info'] = $Educenter->en_info;
        $item['ar_info'] = $Educenter->ar_info;

        $item['facilities_ar'] = $Educenter->facilities_ar;
        $item['facilities_en'] = $Educenter->facilities_en;


        $item['activities_ar'] = $Educenter->activities_ar;
        $item['activities_en'] = $Educenter->activities_en;


        $item['url'] = $Educenter->url;
        $item['phone'] = $Educenter->phone;


        $item['share'] = $Educenter->share;
        $item['institution_id'] = $Educenter->institution_id;

 
   
        if ($Educenter->image != '') {
            foreach (explode(',', $Educenter->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Educenters By Warehouse -----------------\

 
    //------------ Get educenter By ID -----------------\

    public function show($id)
    {

        $Educenter_data = Educenter::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Educenter_data['id'];
        $item['ar_name'] = $Educenter_data['ar_name'];
        $item['en_name'] = $Educenter_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Educenter ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', Educenter::class);
        $Educenter_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $govs = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
            'govs' => $govs , 
            'educenters' =>  $Educenter_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit Educenter ---------------\

    public function edit(Request $request, $id)
    {

        $Educenter_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Educenter::class);
        $Educenter = Educenter::where('deleted_at', '=', null)->findOrFail($id);
        
        
        $helpers = new helpers();
        $item =  $helpers->edit( $Educenter );
        // $images = $helpers->editImageV($Educenter->image, "images",  "image");
        // $images_tow = $helpers->editImageV($Educenter->images_tow, "images_tow",  "image_tow");
        

        // $item[]   = $images;
        // $item[]   =  $images_tow;


        $firstimage = explode(',', $Educenter->image);
        $item['image'] = $firstimage[0];
        $item['images'] = [];
        if ($Educenter->image != '' && $Educenter->image != 'no-image.png') {
            foreach (explode(',', $Educenter->image) as $img) {
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






        $firstimage = explode(',', $Educenter->images_tow);
        $item['image_tow'] = $firstimage[0];
        $item['images_tow'] = [];
        if ($Educenter->images_tow != '' && $Educenter->images_tow != 'no-image.png') {
            foreach (explode(',', $Educenter->images_tow) as $img) {
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
        $drops =  $this->getSectionsWithDrops( $Educenter->selected_ids);
        $goves = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
           
            'educenter' => $data, 
            'govs' => $goves,
            'drops' => $drops,
       
            'educenters' =>  $Educenter_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Educenters
    public function import_educenters(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('educenters');
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


                 

                    //-- Create New Educenter
                    foreach ($data as $key => $value) {
    
 
                        $Educenter = new Educenter;
                        $Educenter->ar_name = $value['ar_name'] ;
                        $Educenter->en_name = $value['en_name'] ;
 
                        $Educenter->image = 'no-image.png';
                        $Educenter->save();

                
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