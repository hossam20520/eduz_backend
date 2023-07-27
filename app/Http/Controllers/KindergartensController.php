<?php
namespace App\Http\Controllers;
use App\Exports\KindergartensExport;
use App\Models\Kindergarten;
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




                
    
      
 
 

                //-- Create New Kindergarten
                $Kindergarten = new Kindergarten;
                //-- Field Required
                $Kindergarten->en_info = $request['en_info'];
                $Kindergarten->ar_info = $request['ar_info'];
                $Kindergarten->facilities_ar = $request['facilities_ar'];
                $Kindergarten->facilities_en = $request['facilities_en'];
                $Kindergarten->activities_ar = $request['activities_ar'];
                $Kindergarten->activities_en = $request['activities_en'];
                $Kindergarten->url = $request['url'];
                $Kindergarten->phone = $request['phone'];
                $Kindergarten->share = $request['share'];
                $Kindergarten->en_name = $request['en_name'];
                $Kindergarten->ar_name = $request['ar_name'];
                $Kindergarten->lat = $request['lat'];
                $Kindergarten->long_a = $request['long'];
                $Kindergarten->area_id = $request['area_id'];


 




 


                $Kindergarten->selected_ids = $request['selected_ids'];
              
             
                // $Kindergarten->activities_image = $request['activities_image'];
                $Kindergarten->institution_id = $request['inst_id'];
                // $Kindergarten->review_id = $request['review_id'];

 

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

                $Kindergarten->image = $filename;
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
 

                    
                //-- Update Kindergarten
                $Kindergarten->en_info = $request['en_info'];
                $Kindergarten->ar_info = $request['ar_info'];
                $Kindergarten->facilities_ar = $request['facilities_ar'];
                $Kindergarten->facilities_en = $request['facilities_en'];
                $Kindergarten->activities_ar = $request['activities_ar'];
                $Kindergarten->activities_en = $request['activities_en'];
                $Kindergarten->url = $request['url'];
                $Kindergarten->phone = $request['phone'];
                $Kindergarten->share = $request['share'];

                $Kindergarten->en_name = $request['en_name'];
                $Kindergarten->ar_name = $request['ar_name'];

                $Kindergarten->area_id = $request['area_id'];
                

                // $Kindergarten->activities_image = $request['activities_image'];
                // $Kindergarten->institution_id = $request['institution_id'];
                $Kindergarten->institution_id = $request['institution_id'];
                $Kindergarten->lat = $request['lat'];
                $Kindergarten->long_a = $request['long'];

 
 
                $Kindergarten->selected_ids = $request['selected_ids'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($Kindergarten->image !== null) {
                        foreach (explode(',', $Kindergarten->image) as $img) {
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
                    if ($Kindergarten->image !== null) {
                        foreach (explode(',', $Kindergarten->image) as $img) {
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

                $Kindergarten->image = $filename;
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

    public function Kindergartens_by_Warehouse(request $request, $id)
    {
        $data = [];
        $kindergarten_warehouse_data = kindergarten_warehouse::with('warehouse', 'Kindergarten', 'kindergartenVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($kindergarten_warehouse_data as $kindergarten_warehouse) {

            if ($kindergarten_warehouse->kindergarten_variant_id) {
                $item['kindergarten_variant_id'] = $kindergarten_warehouse->kindergarten_variant_id;
                $item['code'] = $kindergarten_warehouse['kindergartenVariant']->name . '-' . $kindergarten_warehouse['kindergarten']->code;
                $item['Variant'] = $kindergarten_warehouse['kindergartenVariant']->name;
            } else {
                $item['kindergarten_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $kindergarten_warehouse['kindergarten']->code;
            }

            $item['id'] = $kindergarten_warehouse->kindergarten_id;
            $item['name'] = $kindergarten_warehouse['kindergarten']->name;
            $item['barcode'] = $kindergarten_warehouse['kindergarten']->code;
            $item['Type_barcode'] = $kindergarten_warehouse['kindergarten']->Type_barcode;
            $firstimage = explode(',', $kindergarten_warehouse['kindergarten']->image);
            $item['image'] = $firstimage[0];

            if ($kindergarten_warehouse['kindergarten']['unitSale']->operator == '/') {
                $item['qte_sale'] = $kindergarten_warehouse->qte * $kindergarten_warehouse['kindergarten']['unitSale']->operator_value;
                $price = $kindergarten_warehouse['kindergarten']->price / $kindergarten_warehouse['kindergarten']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $kindergarten_warehouse->qte / $kindergarten_warehouse['kindergarten']['unitSale']->operator_value;
                $price = $kindergarten_warehouse['kindergarten']->price * $kindergarten_warehouse['kindergarten']['unitSale']->operator_value;
            }

            if ($kindergarten_warehouse['kindergarten']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($kindergarten_warehouse->qte * $kindergarten_warehouse['kindergarten']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($kindergarten_warehouse->qte / $kindergarten_warehouse['kindergarten']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $kindergarten_warehouse->qte;
            $item['unitSale'] = $kindergarten_warehouse['kindergarten']['unitSale']->ShortName;
            $item['unitPurchase'] = $kindergarten_warehouse['kindergarten']['unitPurchase']->ShortName;

            if ($kindergarten_warehouse['kindergarten']->TaxNet !== 0.0) {
                //Exclusive
                if ($kindergarten_warehouse['kindergarten']->tax_method == '1') {
                    $tax_price = $price * $kindergarten_warehouse['kindergarten']->TaxNet / 100;
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

        return response()->json([
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
        $item['id'] = $Kindergarten->id;
        $item['en_info'] = $Kindergarten->en_info;
        $item['ar_info'] = $Kindergarten->ar_info;

        $item['facilities_ar'] = $Kindergarten->facilities_ar;
        $item['facilities_en'] = $Kindergarten->facilities_en;


        $item['activities_ar'] = $Kindergarten->activities_ar;
        $item['activities_en'] = $Kindergarten->activities_en;
        $item['area_id'] = $Kindergarten->area_id;
        $item['url'] = $Kindergarten->url;
        $item['phone'] = $Kindergarten->phone;


        $item['share'] = $Kindergarten->share;
        $item['institution_id'] = $Kindergarten->institution_id;


        $item['en_name'] =  $Kindergarten->en_name;
        $item['ar_name'] =  $Kindergarten->ar_name;


        $item['lat'] =  $Kindergarten->lat;
        $item['long'] =  $Kindergarten->long_a;


 
        $item['selected_ids'] =  $Kindergarten->selected_ids;

 
         

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
 
        $data = $item;


        
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $drops =  $this->getSectionsWithDrops( $Kindergarten->selected_ids);
   
        return response()->json([
            'kindergarten' => $data,
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