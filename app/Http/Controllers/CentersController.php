<?php
namespace App\Http\Controllers;
use App\Exports\CentersExport;
use App\Models\Center;
use App\Models\Area;
use App\Models\Section;

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




                
    
      
 
 

                //-- Create New Center
                $Center = new Center;
                //-- Field Required
                $Center->en_info = $request['en_info'];
                $Center->ar_info = $request['ar_info'];
                $Center->facilities_ar = $request['facilities_ar'];
                $Center->facilities_en = $request['facilities_en'];
                $Center->activities_ar = $request['activities_ar'];
                $Center->activities_en = $request['activities_en'];
                $Center->url = $request['url'];
                $Center->phone = $request['phone'];
                $Center->share = $request['share'];
                $Center->en_name = $request['en_name'];
                $Center->ar_name = $request['ar_name'];
                $Center->lat = $request['lat'];
                $Center->long_a = $request['long'];
                $Center->area_id = $request['area_id'];

 
                $Center->selected_ids = $request['selected_ids'];
              
             
                // $Center->activities_image = $request['activities_image'];
                $Center->institution_id = $request['inst_id'];
                // $Center->review_id = $request['review_id'];

 

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        // $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/educations/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Center->image = $filename;
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
 

                    
                //-- Update Center
                $Center->en_info = $request['en_info'];
                $Center->ar_info = $request['ar_info'];
                $Center->facilities_ar = $request['facilities_ar'];
                $Center->facilities_en = $request['facilities_en'];
                $Center->activities_ar = $request['activities_ar'];
                $Center->activities_en = $request['activities_en'];
                $Center->url = $request['url'];
                $Center->phone = $request['phone'];
                $Center->share = $request['share'];

                $Center->en_name = $request['en_name'];
                $Center->ar_name = $request['ar_name'];

                $Center->area_id = $request['area_id'];
                

                // $Center->activities_image = $request['activities_image'];
                // $Center->institution_id = $request['institution_id'];
                $Center->institution_id = $request['institution_id'];
                $Center->lat = $request['lat'];
                $Center->long_a = $request['long'];

 


 
                $Center->selected_ids = $request['selected_ids'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($Center->image !== null) {
                        foreach (explode(',', $Center->image) as $img) {
                            $pathIMG = public_path() . '/images/educations/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Center->image !== null) {
                        foreach (explode(',', $Center->image) as $img) {
                            $pathIMG = public_path() . '/images/educations/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData =  base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path']));
                        // $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/educations/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Center->image = $filename;
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

    public function Centers_by_Warehouse(request $request, $id)
    {
        $data = [];
        $center_warehouse_data = center_warehouse::with('warehouse', 'Center', 'centerVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($center_warehouse_data as $center_warehouse) {

            if ($center_warehouse->center_variant_id) {
                $item['center_variant_id'] = $center_warehouse->center_variant_id;
                $item['code'] = $center_warehouse['centerVariant']->name . '-' . $center_warehouse['center']->code;
                $item['Variant'] = $center_warehouse['centerVariant']->name;
            } else {
                $item['center_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $center_warehouse['center']->code;
            }

            $item['id'] = $center_warehouse->center_id;
            $item['name'] = $center_warehouse['center']->name;
            $item['barcode'] = $center_warehouse['center']->code;
            $item['Type_barcode'] = $center_warehouse['center']->Type_barcode;
            $firstimage = explode(',', $center_warehouse['center']->image);
            $item['image'] = $firstimage[0];

            if ($center_warehouse['center']['unitSale']->operator == '/') {
                $item['qte_sale'] = $center_warehouse->qte * $center_warehouse['center']['unitSale']->operator_value;
                $price = $center_warehouse['center']->price / $center_warehouse['center']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $center_warehouse->qte / $center_warehouse['center']['unitSale']->operator_value;
                $price = $center_warehouse['center']->price * $center_warehouse['center']['unitSale']->operator_value;
            }

            if ($center_warehouse['center']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($center_warehouse->qte * $center_warehouse['center']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($center_warehouse->qte / $center_warehouse['center']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $center_warehouse->qte;
            $item['unitSale'] = $center_warehouse['center']['unitSale']->ShortName;
            $item['unitPurchase'] = $center_warehouse['center']['unitPurchase']->ShortName;

            if ($center_warehouse['center']->TaxNet !== 0.0) {
                //Exclusive
                if ($center_warehouse['center']->tax_method == '1') {
                    $tax_price = $price * $center_warehouse['center']->TaxNet / 100;
                    $item['Net_price'] = $price + $tax_price;
                    // Inxclusive
                } else {
                    $item['Net_price'] = $price;
                }
            } else {
                $item['Net_price'] = $price;
            }

            $data[] = $item;
        }

        return response()->json($data);
    }

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

        return response()->json([
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
        $item['id'] = $Center->id;
        $item['en_info'] = $Center->en_info;
        $item['ar_info'] = $Center->ar_info;

        $item['facilities_ar'] = $Center->facilities_ar;
        $item['facilities_en'] = $Center->facilities_en;


        $item['activities_ar'] = $Center->activities_ar;
        $item['activities_en'] = $Center->activities_en;
        $item['area_id'] = $Center->area_id;
        $item['url'] = $Center->url;
        $item['phone'] = $Center->phone;


        $item['share'] = $Center->share;
        $item['institution_id'] = $Center->institution_id;


        $item['en_name'] =  $Center->en_name;
        $item['ar_name'] =  $Center->ar_name;


        $item['lat'] =  $Center->lat;
        $item['long'] =  $Center->long_a;




        
        $item['selected_ids'] =  $Center->selected_ids;

 
         

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
 
        $data = $item;


        
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $drops =  $this->getSectionsWithDrops( $Center->selected_ids);
   
        return response()->json([
            'center' => $data,
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