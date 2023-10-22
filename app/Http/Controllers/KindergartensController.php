<?php
namespace App\Http\Controllers;
use App\Exports\KindergartensExport;
use App\Models\Kindergarten;
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

class KindergartensController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Kindergarten::class);
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

        $kindergartens = Kindergarten::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($kindergartens, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('kindergartens.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('kindergartens.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $kindergartens = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($kindergartens as $kindergarten) {
            $item['id'] = $kindergarten->id;
            $item['en_name'] = $kindergarten->en_name;
            $item['ar_name'] = $kindergarten->ar_name;

          

            $item['en_info'] = $kindergarten->en_info;
            $item['ar_info'] = $kindergarten->ar_info;
            $item['facilities_ar'] = $kindergarten->facilities_ar;
            $item['facilities_en'] = $kindergarten->facilities_en;
            $item['activities_ar'] = $kindergarten->activities_ar;
            $item['activities_en'] = $kindergarten->activities_en;
            $item['url'] = $kindergarten->url;
            $item['phone'] = $kindergarten->phone;
            $item['share'] = $kindergarten->share;
            $item['institution'] = Institution::find($kindergarten->institution_id)->ar_name;
            $firstimage = explode(',', $kindergarten->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Kindergarten->activities_image = $request['activities_image'];
        // $Kindergarten->institution_id = $request['institution_id'];
        // // $Kindergarten->review_id = $request['review_id'];

 

        return response()->json([
 
            'kindergartens' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Kindergarten  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Kindergarten::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

 
                $helpers = new helpers();
                $Kindergarten = new Kindergarten;
                $Kindergarten =  $helpers->store($Kindergarten , $request);
                //-- Create New Kindergarten
                // $Kindergarten = new Kindergarten;
                //-- Field Required






                


             $helpers = new helpers();
             $images =  $helpers->StoreImagesV($request , "images");
             $images_tow =   $helpers->StoreImagesV($request , "images_tow");

   
                $Kindergarten->image =  $images;
                $Kindergarten->images_tow =  $images_tow ;
                $Kindergarten->save();

  

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

    //-------------- Update Kindergarten  ---------------\
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
        // $this->authorizeForUser($request->user('api'), 'update', Kindergarten::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Kindergarten = Kindergarten::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
 
                     
                $helpers = new helpers();


            
                $Kindergarten =  $helpers->store($Kindergarten , $request);
                //-- Update Kindergarten
               

 

   
                // $logo =  $this->UpdateImage( 'logo',  "educations" , $request , $request->logo , $Kindergarten->logo );
              
                  $imagesa  = $helpers->updateImagesActiv($request , $Kindergarten->image,  "images");
                  $images_tow  = $helpers->updateImagesActiv($request , $Kindergarten->images_tow,  "images_tow");

                // $banner =  $this->UpdateImage( 'banner',  "educations" , $request , $request->banner , $Kindergarten->banner );
 
                $Kindergarten->image =  $imagesa;
                $Kindergarten->images_tow =  $images_tow;
       
                $Kindergarten->save();

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

    //-------------- Remove Kindergarten  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Kindergarten::class);

        \DB::transaction(function () use ($id) {

            $Kindergarten = Kindergarten::findOrFail($id);
            $Kindergarten->deleted_at = Carbon::now();
            $Kindergarten->save();

            foreach (explode(',', $Kindergarten->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Kindergarten::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $kindergarten_id) {

                $Kindergarten = Kindergarten::findOrFail($kindergarten_id);
                $Kindergarten->deleted_at = Carbon::now();
                $Kindergarten->save();

                foreach (explode(',', $Kindergarten->image) as $img) {
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

    //-------------- Export All Kindergarten to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Kindergarten::class);

        return Excel::download(new KindergartensExport, 'List_Kindergartens.xlsx');
    }




    //--------------  Show Kindergarten Details ---------------\
    public function Get_Kindergartens_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Kindergarten::class);

        $Kindergarten = Kindergarten::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Kindergarten->id;
        $item['ar_name'] = $Kindergarten->ar_name;
        $item['en_name'] = $Kindergarten->en_name;
 
        $item['en_info'] = $Kindergarten->en_info;
        $item['ar_info'] = $Kindergarten->ar_info;

        $item['facilities_ar'] = $Kindergarten->facilities_ar;
        $item['facilities_en'] = $Kindergarten->facilities_en;


        $item['activities_ar'] = $Kindergarten->activities_ar;
        $item['activities_en'] = $Kindergarten->activities_en;


        $item['url'] = $Kindergarten->url;
        $item['phone'] = $Kindergarten->phone;


        $item['share'] = $Kindergarten->share;
        $item['institution_id'] = $Kindergarten->institution_id;

 
   
        if ($Kindergarten->image != '') {
            foreach (explode(',', $Kindergarten->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Kindergartens By Warehouse -----------------\

 
    //------------ Get kindergarten By ID -----------------\

    public function show($id)
    {

        $Kindergarten_data = Kindergarten::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Kindergarten_data['id'];
        $item['ar_name'] = $Kindergarten_data['ar_name'];
        $item['en_name'] = $Kindergarten_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Kindergarten ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', Kindergarten::class);
        $Kindergarten_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $govs = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
            'govs' => $govs , 
            'kindergartens' =>  $Kindergarten_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit Kindergarten ---------------\

    public function edit(Request $request, $id)
    {

        $Kindergarten_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Kindergarten::class);
        $Kindergarten = Kindergarten::where('deleted_at', '=', null)->findOrFail($id);
        
        
        $helpers = new helpers();
        $item =  $helpers->edit( $Kindergarten );
        // $images = $helpers->editImageV($Kindergarten->image, "images",  "image");
        // $images_tow = $helpers->editImageV($Kindergarten->images_tow, "images_tow",  "image_tow");
        

        // $item[]   = $images;
        // $item[]   =  $images_tow;


        $firstimage = explode(',', $Kindergarten->image);
        $item['image'] = $firstimage[0];
        $item['images'] = [];
        if ($Kindergarten->image != '' && $Kindergarten->image != 'no-image.png') {
            foreach (explode(',', $Kindergarten->image) as $img) {
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






        $firstimage = explode(',', $Kindergarten->images_tow);
        $item['image_tow'] = $firstimage[0];
        $item['images_tow'] = [];
        if ($Kindergarten->images_tow != '' && $Kindergarten->images_tow != 'no-image.png') {
            foreach (explode(',', $Kindergarten->images_tow) as $img) {
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
        $drops =  $this->getSectionsWithDrops( $Kindergarten->selected_ids);
        $goves = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
           
            'kindergarten' => $data, 
            'govs' => $goves,
            'drops' => $drops,
       
            'kindergartens' =>  $Kindergarten_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Kindergartens
    public function import_kindergartens(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('kindergartens');
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


                 

                    //-- Create New Kindergarten
                    foreach ($data as $key => $value) {
    
 
                        $Kindergarten = new Kindergarten;
                        $Kindergarten->ar_name = $value['ar_name'] ;
                        $Kindergarten->en_name = $value['en_name'] ;
 
                        $Kindergarten->image = 'no-image.png';
                        $Kindergarten->save();

                
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