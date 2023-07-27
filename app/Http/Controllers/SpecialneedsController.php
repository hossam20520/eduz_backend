<?php
namespace App\Http\Controllers;
use App\Exports\SpecialneedsExport;
use App\Models\Specialneed;
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


class SpecialneedsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Specialneed::class);
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

        $specialneeds = Specialneed::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($specialneeds, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('specialneeds.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('specialneeds.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $specialneeds = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($specialneeds as $specialneed) {
            $item['id'] = $specialneed->id;
            $item['en_name'] = $specialneed->en_name;
            $item['ar_name'] = $specialneed->ar_name;

          

            $item['en_info'] = $specialneed->en_info;
            $item['ar_info'] = $specialneed->ar_info;
            $item['facilities_ar'] = $specialneed->facilities_ar;
            $item['facilities_en'] = $specialneed->facilities_en;
            $item['activities_ar'] = $specialneed->activities_ar;
            $item['activities_en'] = $specialneed->activities_en;
            $item['url'] = $specialneed->url;
            $item['phone'] = $specialneed->phone;
            $item['share'] = $specialneed->share;
            $item['institution'] = Institution::find($specialneed->institution_id)->ar_name;
            $firstimage = explode(',', $specialneed->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Specialneed->activities_image = $request['activities_image'];
        // $Specialneed->institution_id = $request['institution_id'];
        // // $Specialneed->review_id = $request['review_id'];

 

        return response()->json([
 
            'specialneeds' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Specialneed  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Specialneed::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {




                
    
      
 
 

                //-- Create New Specialneed
                $Specialneed = new Specialneed;
                //-- Field Required
                $Specialneed->en_info = $request['en_info'];
                $Specialneed->ar_info = $request['ar_info'];
                $Specialneed->facilities_ar = $request['facilities_ar'];
                $Specialneed->facilities_en = $request['facilities_en'];
                $Specialneed->activities_ar = $request['activities_ar'];
                $Specialneed->activities_en = $request['activities_en'];
                $Specialneed->url = $request['url'];
                $Specialneed->phone = $request['phone'];
                $Specialneed->share = $request['share'];
                $Specialneed->en_name = $request['en_name'];
                $Specialneed->ar_name = $request['ar_name'];
                $Specialneed->lat = $request['lat'];
                $Specialneed->long_a = $request['long'];
                $Specialneed->area_id = $request['area_id'];

 
                $Specialneed->selected_ids = $request['selected_ids'];
              
             
                // $Specialneed->activities_image = $request['activities_image'];
                $Specialneed->institution_id = $request['inst_id'];
                // $Specialneed->review_id = $request['review_id'];

 

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

                $Specialneed->image = $filename;
                $Specialneed->save();

  

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

    //-------------- Update Specialneed  ---------------\
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
        // $this->authorizeForUser($request->user('api'), 'update', Specialneed::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Specialneed = Specialneed::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 

                    
                //-- Update Specialneed
                $Specialneed->en_info = $request['en_info'];
                $Specialneed->ar_info = $request['ar_info'];
                $Specialneed->facilities_ar = $request['facilities_ar'];
                $Specialneed->facilities_en = $request['facilities_en'];
                $Specialneed->activities_ar = $request['activities_ar'];
                $Specialneed->activities_en = $request['activities_en'];
                $Specialneed->url = $request['url'];
                $Specialneed->phone = $request['phone'];
                $Specialneed->share = $request['share'];
 

                $Specialneed->en_name = $request['en_name'];
                $Specialneed->ar_name = $request['ar_name'];
                $Specialneed->area_id = $request['area_id'];
 
                $Specialneed->institution_id = $request['institution_id'];
                $Specialneed->lat = $request['lat'];
                $Specialneed->long_a = $request['long'];

 


 
                $Specialneed->selected_ids = $request['selected_ids'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($Specialneed->image !== null) {
                        foreach (explode(',', $Specialneed->image) as $img) {
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
                    if ($Specialneed->image !== null) {
                        foreach (explode(',', $Specialneed->image) as $img) {
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

                $Specialneed->image = $filename;
                $Specialneed->save();

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

    //-------------- Remove Specialneed  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Specialneed::class);

        \DB::transaction(function () use ($id) {

            $Specialneed = Specialneed::findOrFail($id);
            $Specialneed->deleted_at = Carbon::now();
            $Specialneed->save();

            foreach (explode(',', $Specialneed->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Specialneed::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $specialneed_id) {

                $Specialneed = Specialneed::findOrFail($specialneed_id);
                $Specialneed->deleted_at = Carbon::now();
                $Specialneed->save();

                foreach (explode(',', $Specialneed->image) as $img) {
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

    //-------------- Export All Specialneed to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Specialneed::class);

        return Excel::download(new SpecialneedsExport, 'List_Specialneeds.xlsx');
    }




    //--------------  Show Specialneed Details ---------------\
    public function Get_Specialneeds_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Specialneed::class);

        $Specialneed = Specialneed::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Specialneed->id;
        $item['ar_name'] = $Specialneed->ar_name;
        $item['en_name'] = $Specialneed->en_name;
 
        $item['en_info'] = $Specialneed->en_info;
        $item['ar_info'] = $Specialneed->ar_info;

        $item['facilities_ar'] = $Specialneed->facilities_ar;
        $item['facilities_en'] = $Specialneed->facilities_en;


        $item['activities_ar'] = $Specialneed->activities_ar;
        $item['activities_en'] = $Specialneed->activities_en;


        $item['url'] = $Specialneed->url;
        $item['phone'] = $Specialneed->phone;


        $item['share'] = $Specialneed->share;
        $item['institution_id'] = $Specialneed->institution_id;

 
   
        if ($Specialneed->image != '') {
            foreach (explode(',', $Specialneed->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Specialneeds By Warehouse -----------------\

    public function Specialneeds_by_Warehouse(request $request, $id)
    {
        $data = [];
        $specialneed_warehouse_data = specialneed_warehouse::with('warehouse', 'Specialneed', 'specialneedVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($specialneed_warehouse_data as $specialneed_warehouse) {

            if ($specialneed_warehouse->specialneed_variant_id) {
                $item['specialneed_variant_id'] = $specialneed_warehouse->specialneed_variant_id;
                $item['code'] = $specialneed_warehouse['specialneedVariant']->name . '-' . $specialneed_warehouse['specialneed']->code;
                $item['Variant'] = $specialneed_warehouse['specialneedVariant']->name;
            } else {
                $item['specialneed_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $specialneed_warehouse['specialneed']->code;
            }

            $item['id'] = $specialneed_warehouse->specialneed_id;
            $item['name'] = $specialneed_warehouse['specialneed']->name;
            $item['barcode'] = $specialneed_warehouse['specialneed']->code;
            $item['Type_barcode'] = $specialneed_warehouse['specialneed']->Type_barcode;
            $firstimage = explode(',', $specialneed_warehouse['specialneed']->image);
            $item['image'] = $firstimage[0];

            if ($specialneed_warehouse['specialneed']['unitSale']->operator == '/') {
                $item['qte_sale'] = $specialneed_warehouse->qte * $specialneed_warehouse['specialneed']['unitSale']->operator_value;
                $price = $specialneed_warehouse['specialneed']->price / $specialneed_warehouse['specialneed']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $specialneed_warehouse->qte / $specialneed_warehouse['specialneed']['unitSale']->operator_value;
                $price = $specialneed_warehouse['specialneed']->price * $specialneed_warehouse['specialneed']['unitSale']->operator_value;
            }

            if ($specialneed_warehouse['specialneed']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($specialneed_warehouse->qte * $specialneed_warehouse['specialneed']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($specialneed_warehouse->qte / $specialneed_warehouse['specialneed']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $specialneed_warehouse->qte;
            $item['unitSale'] = $specialneed_warehouse['specialneed']['unitSale']->ShortName;
            $item['unitPurchase'] = $specialneed_warehouse['specialneed']['unitPurchase']->ShortName;

            if ($specialneed_warehouse['specialneed']->TaxNet !== 0.0) {
                //Exclusive
                if ($specialneed_warehouse['specialneed']->tax_method == '1') {
                    $tax_price = $price * $specialneed_warehouse['specialneed']->TaxNet / 100;
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

    //------------ Get specialneed By ID -----------------\

    public function show($id)
    {

        $Specialneed_data = Specialneed::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Specialneed_data['id'];
        $item['ar_name'] = $Specialneed_data['ar_name'];
        $item['en_name'] = $Specialneed_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Specialneed ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', Specialneed::class);
        $Specialneed_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);

        return response()->json([
            'specialneeds' =>  $Specialneed_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit Specialneed ---------------\

    public function edit(Request $request, $id)
    {

        $Specialneed_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Specialneed::class);
        $Specialneed = Specialneed::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Specialneed->id;
        $item['en_info'] = $Specialneed->en_info;
        $item['ar_info'] = $Specialneed->ar_info;

        $item['facilities_ar'] = $Specialneed->facilities_ar;
        $item['facilities_en'] = $Specialneed->facilities_en;


        $item['activities_ar'] = $Specialneed->activities_ar;
        $item['activities_en'] = $Specialneed->activities_en;
        $item['area_id'] = $Specialneed->area_id;
        $item['url'] = $Specialneed->url;
        $item['phone'] = $Specialneed->phone;


        $item['share'] = $Specialneed->share;
        $item['institution_id'] = $Specialneed->institution_id;


        $item['en_name'] =  $Specialneed->en_name;
        $item['ar_name'] =  $Specialneed->ar_name;


        $item['lat'] =  $Specialneed->lat;
        $item['long'] =  $Specialneed->long_a;




        
        $item['selected_ids'] =  $Specialneed->selected_ids;

 
         

        $firstimage = explode(',', $Specialneed->image);
        $item['image'] = $firstimage[0];
          
 
 
        $item['images'] = [];
        if ($Specialneed->image != '' && $Specialneed->image != 'no-image.png') {
            foreach (explode(',', $Specialneed->image) as $img) {
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
        $drops =  $this->getSectionsWithDrops( $Specialneed->selected_ids);
   
        return response()->json([
            'specialneed' => $data,
            'drops' => $drops,
            'specialneeds' =>  $Specialneed_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Specialneeds
    public function import_specialneeds(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('specialneeds');
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


                 

                    //-- Create New Specialneed
                    foreach ($data as $key => $value) {
    
 
                        $Specialneed = new Specialneed;
                        $Specialneed->ar_name = $value['ar_name'] ;
                        $Specialneed->en_name = $value['en_name'] ;
 
                        $Specialneed->image = 'no-image.png';
                        $Specialneed->save();

                
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