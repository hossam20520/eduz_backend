<?php
namespace App\Http\Controllers;
use App\Exports\UniversitiesExport;
use App\Models\Universitie;
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


class UniversitiesController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Universitie::class);
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

        $universities = Universitie::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($universities, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('universities.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('universities.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $universities = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($universities as $universitie) {
            $item['id'] = $universitie->id;
            $item['en_name'] = $universitie->en_name;
            $item['ar_name'] = $universitie->ar_name;

          

            $item['en_info'] = $universitie->en_info;
            $item['ar_info'] = $universitie->ar_info;
            $item['facilities_ar'] = $universitie->facilities_ar;
            $item['facilities_en'] = $universitie->facilities_en;
            $item['activities_ar'] = $universitie->activities_ar;
            $item['activities_en'] = $universitie->activities_en;
            $item['url'] = $universitie->url;
            $item['phone'] = $universitie->phone;
            $item['share'] = $universitie->share;
            $item['institution'] = Institution::find($universitie->institution_id)->ar_name;
            $firstimage = explode(',', $universitie->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Universitie->activities_image = $request['activities_image'];
        // $Universitie->institution_id = $request['institution_id'];
        // // $Universitie->review_id = $request['review_id'];

 

        return response()->json([
 
            'universities' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Universitie  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Universitie::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {


 

            
                //-- Field Required
                $helpers = new helpers();
                $Universitie = new Universitie;
                $Universitie =  $helpers->store($Universitie , $request);

                $images =  $helpers->StoreImagesV($request , "images");
                $images_tow =   $helpers->StoreImagesV($request , "images_tow");
                $Universitie->image =  $images;
                $Universitie->images_tow =  $images_tow ;
                $Universitie->save();

            
  

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

    //-------------- Update Universitie  ---------------\
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
        // $this->authorizeForUser($request->user('api'), 'update', Universitie::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Universitie = Universitie::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
 
                             
                    $helpers = new helpers();
                    $Universitie =  $helpers->store($Universitie , $request);
                    $imagesa  = $helpers->updateImagesActiv($request , $Universitie->image,  "images");
                    $images_tow  = $helpers->updateImagesActiv($request , $Universitie->images_tow,  "images_tow");
                    $Universitie->image =  $imagesa;
                    $Universitie->images_tow =  $images_tow;
                    $Universitie->save();

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

    //-------------- Remove Universitie  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Universitie::class);

        \DB::transaction(function () use ($id) {

            $Universitie = Universitie::findOrFail($id);
            $Universitie->deleted_at = Carbon::now();
            $Universitie->save();

            foreach (explode(',', $Universitie->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Universitie::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $universitie_id) {

                $Universitie = Universitie::findOrFail($universitie_id);
                $Universitie->deleted_at = Carbon::now();
                $Universitie->save();

                foreach (explode(',', $Universitie->image) as $img) {
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

    //-------------- Export All Universitie to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Universitie::class);

        return Excel::download(new UniversitiesExport, 'List_Universities.xlsx');
    }




    //--------------  Show Universitie Details ---------------\
    public function Get_Universities_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Universitie::class);

        $Universitie = Universitie::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Universitie->id;
        $item['ar_name'] = $Universitie->ar_name;
        $item['en_name'] = $Universitie->en_name;
 
        $item['en_info'] = $Universitie->en_info;
        $item['ar_info'] = $Universitie->ar_info;

        $item['facilities_ar'] = $Universitie->facilities_ar;
        $item['facilities_en'] = $Universitie->facilities_en;


        $item['activities_ar'] = $Universitie->activities_ar;
        $item['activities_en'] = $Universitie->activities_en;


        $item['url'] = $Universitie->url;
        $item['phone'] = $Universitie->phone;


        $item['share'] = $Universitie->share;
        $item['institution_id'] = $Universitie->institution_id;

 
   
        if ($Universitie->image != '') {
            foreach (explode(',', $Universitie->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Universities By Warehouse -----------------\

    public function Universities_by_Warehouse(request $request, $id)
    {
        $data = [];
        $universitie_warehouse_data = universitie_warehouse::with('warehouse', 'Universitie', 'universitieVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($universitie_warehouse_data as $universitie_warehouse) {

            if ($universitie_warehouse->universitie_variant_id) {
                $item['universitie_variant_id'] = $universitie_warehouse->universitie_variant_id;
                $item['code'] = $universitie_warehouse['universitieVariant']->name . '-' . $universitie_warehouse['universitie']->code;
                $item['Variant'] = $universitie_warehouse['universitieVariant']->name;
            } else {
                $item['universitie_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $universitie_warehouse['universitie']->code;
            }

            $item['id'] = $universitie_warehouse->universitie_id;
            $item['name'] = $universitie_warehouse['universitie']->name;
            $item['barcode'] = $universitie_warehouse['universitie']->code;
            $item['Type_barcode'] = $universitie_warehouse['universitie']->Type_barcode;
            $firstimage = explode(',', $universitie_warehouse['universitie']->image);
            $item['image'] = $firstimage[0];

            if ($universitie_warehouse['universitie']['unitSale']->operator == '/') {
                $item['qte_sale'] = $universitie_warehouse->qte * $universitie_warehouse['universitie']['unitSale']->operator_value;
                $price = $universitie_warehouse['universitie']->price / $universitie_warehouse['universitie']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $universitie_warehouse->qte / $universitie_warehouse['universitie']['unitSale']->operator_value;
                $price = $universitie_warehouse['universitie']->price * $universitie_warehouse['universitie']['unitSale']->operator_value;
            }

            if ($universitie_warehouse['universitie']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($universitie_warehouse->qte * $universitie_warehouse['universitie']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($universitie_warehouse->qte / $universitie_warehouse['universitie']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $universitie_warehouse->qte;
            $item['unitSale'] = $universitie_warehouse['universitie']['unitSale']->ShortName;
            $item['unitPurchase'] = $universitie_warehouse['universitie']['unitPurchase']->ShortName;

            if ($universitie_warehouse['universitie']->TaxNet !== 0.0) {
                //Exclusive
                if ($universitie_warehouse['universitie']->tax_method == '1') {
                    $tax_price = $price * $universitie_warehouse['universitie']->TaxNet / 100;
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

    //------------ Get universitie By ID -----------------\

    public function show($id)
    {

        $Universitie_data = Universitie::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Universitie_data['id'];
        $item['ar_name'] = $Universitie_data['ar_name'];
        $item['en_name'] = $Universitie_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Universitie ---------------\

    public function create(Request $request)
    {



        // $this->authorizeForUser($request->user('api'), 'create', Universitie::class);
        $Universitie_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $govs = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
            'govs' => $govs , 
            'universities' =>  $Universitie_data ,
            'areas' =>  $area
        ]);

    }

 

    //---------------- Show Form Edit Universitie ---------------\

    public function edit(Request $request, $id)
    {

        $Universitie_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Universitie::class);
        $Universitie = Universitie::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Universitie->id;
        $item['en_info'] = $Universitie->en_info;
        $item['ar_info'] = $Universitie->ar_info;

        $item['facilities_ar'] = $Universitie->facilities_ar;
        $item['facilities_en'] = $Universitie->facilities_en;


        $item['activities_ar'] = $Universitie->activities_ar;
        $item['activities_en'] = $Universitie->activities_en;
        $item['area_id'] = $Universitie->area_id;
        $item['url'] = $Universitie->url;
        $item['phone'] = $Universitie->phone;


        $item['share'] = $Universitie->share;
        $item['institution_id'] = $Universitie->institution_id;


        $item['en_name'] =  $Universitie->en_name;
        $item['ar_name'] =  $Universitie->ar_name;


        $item['lat'] =  $Universitie->lat;
        $item['long'] =  $Universitie->long_a;




        
        $item['selected_ids'] =  $Universitie->selected_ids;

 
         

        $firstimage = explode(',', $Universitie->image);
        $item['image'] = $firstimage[0];
          
 
 
        $item['images'] = [];
        if ($Universitie->image != '' && $Universitie->image != 'no-image.png') {
            foreach (explode(',', $Universitie->image) as $img) {
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
        $drops =  $this->getSectionsWithDrops( $Universitie->selected_ids);
   
        return response()->json([
            'universitie' => $data,
            'drops' => $drops,
            'universities' =>  $Universitie_data ,
            'areas'=>$area 
        ]);

    }

   
    // import Universities
    public function import_universities(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('universities');
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


                 

                    //-- Create New Universitie
                    foreach ($data as $key => $value) {
    
 
                        $Universitie = new Universitie;
                        $Universitie->ar_name = $value['ar_name'] ;
                        $Universitie->en_name = $value['en_name'] ;
 
                        $Universitie->image = 'no-image.png';
                        $Universitie->save();

                
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