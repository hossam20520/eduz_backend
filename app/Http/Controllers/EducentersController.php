<?php
namespace App\Http\Controllers;
use App\Exports\EducentersExport;
use App\Models\Educenter;
use App\Models\Area;
use App\Models\Gov;
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




                
    
      
 
 

                //-- Create New Educenter
                $Educenter = new Educenter;
                //-- Field Required
                $Educenter->en_info = $request['en_info'];
                $Educenter->ar_info = $request['ar_info'];
                $Educenter->facilities_ar = $request['facilities_ar'];
                $Educenter->facilities_en = $request['facilities_en'];
                $Educenter->activities_ar = $request['activities_ar'];
                $Educenter->activities_en = $request['activities_en'];
                $Educenter->url = $request['url'];
                $Educenter->phone = $request['phone'];
                $Educenter->share = $request['share'];
                $Educenter->en_name = $request['en_name'];
                $Educenter->ar_name = $request['ar_name'];
                $Educenter->lat = $request['lat'];
                $Educenter->long_a = $request['long'];
                $Educenter->area_id = $request['area_id'];

 
                $Educenter->selected_ids = $request['selected_ids'];
              
             
                // $Educenter->activities_image = $request['activities_image'];
                $Educenter->institution_id = $request['inst_id'];
                // $Educenter->review_id = $request['review_id'];

 

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

                $Educenter->image = $filename;
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
 

                    
                //-- Update Educenter
                $Educenter->en_info = $request['en_info'];
                $Educenter->ar_info = $request['ar_info'];
                $Educenter->facilities_ar = $request['facilities_ar'];
                $Educenter->facilities_en = $request['facilities_en'];
                $Educenter->activities_ar = $request['activities_ar'];
                $Educenter->activities_en = $request['activities_en'];
                $Educenter->url = $request['url'];
                $Educenter->phone = $request['phone'];
                $Educenter->share = $request['share'];

                $Educenter->en_name = $request['en_name'];
                $Educenter->ar_name = $request['ar_name'];

                $Educenter->area_id = $request['area_id'];
                

                // $Educenter->activities_image = $request['activities_image'];
                // $Educenter->institution_id = $request['institution_id'];
                $Educenter->institution_id = $request['institution_id'];
                $Educenter->lat = $request['lat'];
                $Educenter->long_a = $request['long'];

 


 
                $Educenter->selected_ids = $request['selected_ids'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($Educenter->image !== null) {
                        foreach (explode(',', $Educenter->image) as $img) {
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
                    if ($Educenter->image !== null) {
                        foreach (explode(',', $Educenter->image) as $img) {
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

                $Educenter->image = $filename;
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

    public function Educenters_by_Warehouse(request $request, $id)
    {
        $data = [];
        $educenter_warehouse_data = educenter_warehouse::with('warehouse', 'Educenter', 'educenterVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($educenter_warehouse_data as $educenter_warehouse) {

            if ($educenter_warehouse->educenter_variant_id) {
                $item['educenter_variant_id'] = $educenter_warehouse->educenter_variant_id;
                $item['code'] = $educenter_warehouse['educenterVariant']->name . '-' . $educenter_warehouse['educenter']->code;
                $item['Variant'] = $educenter_warehouse['educenterVariant']->name;
            } else {
                $item['educenter_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $educenter_warehouse['educenter']->code;
            }

            $item['id'] = $educenter_warehouse->educenter_id;
            $item['name'] = $educenter_warehouse['educenter']->name;
            $item['barcode'] = $educenter_warehouse['educenter']->code;
            $item['Type_barcode'] = $educenter_warehouse['educenter']->Type_barcode;
            $firstimage = explode(',', $educenter_warehouse['educenter']->image);
            $item['image'] = $firstimage[0];

            if ($educenter_warehouse['educenter']['unitSale']->operator == '/') {
                $item['qte_sale'] = $educenter_warehouse->qte * $educenter_warehouse['educenter']['unitSale']->operator_value;
                $price = $educenter_warehouse['educenter']->price / $educenter_warehouse['educenter']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $educenter_warehouse->qte / $educenter_warehouse['educenter']['unitSale']->operator_value;
                $price = $educenter_warehouse['educenter']->price * $educenter_warehouse['educenter']['unitSale']->operator_value;
            }

            if ($educenter_warehouse['educenter']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($educenter_warehouse->qte * $educenter_warehouse['educenter']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($educenter_warehouse->qte / $educenter_warehouse['educenter']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $educenter_warehouse->qte;
            $item['unitSale'] = $educenter_warehouse['educenter']['unitSale']->ShortName;
            $item['unitPurchase'] = $educenter_warehouse['educenter']['unitPurchase']->ShortName;

            if ($educenter_warehouse['educenter']->TaxNet !== 0.0) {
                //Exclusive
                if ($educenter_warehouse['educenter']->tax_method == '1') {
                    $tax_price = $price * $educenter_warehouse['educenter']->TaxNet / 100;
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
        $item['id'] = $Educenter->id;
        $item['en_info'] = $Educenter->en_info;
        $item['ar_info'] = $Educenter->ar_info;

        $item['facilities_ar'] = $Educenter->facilities_ar;
        $item['facilities_en'] = $Educenter->facilities_en;


        $item['activities_ar'] = $Educenter->activities_ar;
        $item['activities_en'] = $Educenter->activities_en;
        $item['area_id'] = $Educenter->area_id;
        $item['url'] = $Educenter->url;
        $item['phone'] = $Educenter->phone;


        $item['share'] = $Educenter->share;
        $item['institution_id'] = $Educenter->institution_id;


        $item['en_name'] =  $Educenter->en_name;
        $item['ar_name'] =  $Educenter->ar_name;


        $item['lat'] =  $Educenter->lat;
        $item['long'] =  $Educenter->long_a;




        
        $item['selected_ids'] =  $Educenter->selected_ids;

 
         

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
 
        $data = $item;


        
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $drops =  $this->getSectionsWithDrops( $Educenter->selected_ids);
   
        return response()->json([
            'educenter' => $data,
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