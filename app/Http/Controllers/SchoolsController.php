<?php
namespace App\Http\Controllers;
use App\Exports\SchoolsExport;
use App\Models\School;
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




                
    
      
 
 

                //-- Create New School
                $School = new School;
                //-- Field Required
                $School->en_info = $request['en_info'];
                $School->ar_info = $request['ar_info'];
                $School->facilities_ar = $request['facilities_ar'];
                $School->facilities_en = $request['facilities_en'];
                $School->activities_ar = $request['activities_ar'];
                $School->activities_en = $request['activities_en'];
                $School->url = $request['url'];
                $School->phone = $request['phone'];
                $School->share = $request['share'];
                $School->en_name = $request['en_name'];
                $School->ar_name = $request['ar_name'];
                $School->lat = $request['lat'];
                $School->long_a = $request['long'];
                $School->area_id = $request['area_id'];


                $School->second_lang = $request['second_lang'];
                $School->first_lang = $request['first_lang'];
                $School->other_lang = $request['other_lang'];
                $School->years_accepted = $request['years_accepted'];
                $School->weekend = $request['weekend'];
                $School->expense_from = $request['expFrom'];
                $School->expense_to = $request['expTo'];
                $School->children_numbers = $request['children_numbers'];
                $School->is_accept = $request['is_accept'];




 


                $School->selected_ids = $request['selected_ids'];
              
             
                // $School->activities_image = $request['activities_image'];
                $School->institution_id = $request['inst_id'];
                // $School->review_id = $request['review_id'];

 

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

                $School->image = $filename;
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
 

                    
                //-- Update School
                $School->en_info = $request['en_info'];
                $School->ar_info = $request['ar_info'];
                $School->facilities_ar = $request['facilities_ar'];
                $School->facilities_en = $request['facilities_en'];
                $School->activities_ar = $request['activities_ar'];
                $School->activities_en = $request['activities_en'];
                $School->url = $request['url'];
                $School->phone = $request['phone'];
                $School->share = $request['share'];

                $School->en_name = $request['en_name'];
                $School->ar_name = $request['ar_name'];

                $School->area_id = $request['area_id'];
                

                // $School->activities_image = $request['activities_image'];
                // $School->institution_id = $request['institution_id'];
                $School->institution_id = $request['institution_id'];
                $School->lat = $request['lat'];
                $School->long_a = $request['long'];

 



                
                $School->second_lang = $request['second_lang'];
                $School->first_lang = $request['first_lang'];
                $School->other_lang = $request['other_lang'];
                $School->years_accepted = $request['years_accepted'];
                $School->weekend = $request['weekend'];
                $School->expense_from = $request['expFrom'];
                $School->expense_to = $request['expTo'];
                $School->children_numbers = $request['children_numbers'];
                $School->is_accept = $request['is_accept'];
                $School->selected_ids = $request['selected_ids'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($School->image !== null) {
                        foreach (explode(',', $School->image) as $img) {
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
                    if ($School->image !== null) {
                        foreach (explode(',', $School->image) as $img) {
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

                $School->image = $filename;
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

    public function Schools_by_Warehouse(request $request, $id)
    {
        $data = [];
        $school_warehouse_data = school_warehouse::with('warehouse', 'School', 'schoolVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($school_warehouse_data as $school_warehouse) {

            if ($school_warehouse->school_variant_id) {
                $item['school_variant_id'] = $school_warehouse->school_variant_id;
                $item['code'] = $school_warehouse['schoolVariant']->name . '-' . $school_warehouse['school']->code;
                $item['Variant'] = $school_warehouse['schoolVariant']->name;
            } else {
                $item['school_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $school_warehouse['school']->code;
            }

            $item['id'] = $school_warehouse->school_id;
            $item['name'] = $school_warehouse['school']->name;
            $item['barcode'] = $school_warehouse['school']->code;
            $item['Type_barcode'] = $school_warehouse['school']->Type_barcode;
            $firstimage = explode(',', $school_warehouse['school']->image);
            $item['image'] = $firstimage[0];

            if ($school_warehouse['school']['unitSale']->operator == '/') {
                $item['qte_sale'] = $school_warehouse->qte * $school_warehouse['school']['unitSale']->operator_value;
                $price = $school_warehouse['school']->price / $school_warehouse['school']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $school_warehouse->qte / $school_warehouse['school']['unitSale']->operator_value;
                $price = $school_warehouse['school']->price * $school_warehouse['school']['unitSale']->operator_value;
            }

            if ($school_warehouse['school']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($school_warehouse->qte * $school_warehouse['school']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($school_warehouse->qte / $school_warehouse['school']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $school_warehouse->qte;
            $item['unitSale'] = $school_warehouse['school']['unitSale']->ShortName;
            $item['unitPurchase'] = $school_warehouse['school']['unitPurchase']->ShortName;

            if ($school_warehouse['school']->TaxNet !== 0.0) {
                //Exclusive
                if ($school_warehouse['school']->tax_method == '1') {
                    $tax_price = $price * $school_warehouse['school']->TaxNet / 100;
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

        return response()->json([
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
        $item['id'] = $School->id;
        $item['en_info'] = $School->en_info;
        $item['ar_info'] = $School->ar_info;

        $item['facilities_ar'] = $School->facilities_ar;
        $item['facilities_en'] = $School->facilities_en;


        $item['activities_ar'] = $School->activities_ar;
        $item['activities_en'] = $School->activities_en;
        $item['area_id'] = $School->area_id;
        $item['url'] = $School->url;
        $item['phone'] = $School->phone;


        $item['share'] = $School->share;
        $item['institution_id'] = $School->institution_id;


        $item['en_name'] =  $School->en_name;
        $item['ar_name'] =  $School->ar_name;


        $item['lat'] =  $School->lat;
        $item['long'] =  $School->long_a;



        $item['second_lang'] =  $School->second_lang;
        $item['first_lang'] =  $School->first_lang;
        $item['other_lang'] =  $School->other_lang;
        $item['years_accepted'] =  $School->years_accepted;
        $item['weekend'] =  $School->weekend;
        $item['expFrom'] =  $School->expense_from;
        $item['expTo'] =  $School->expense_to;
        $item['children_numbers'] =  $School->children_numbers;
        $item['is_accept'] =  $School->is_accept;
        $item['selected_ids'] =  $School->selected_ids;

 
         

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
 
        $data = $item;


        
        $area = Area::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        $drops =  $this->getSectionsWithDrops( $School->selected_ids);
   
        return response()->json([
            'school' => $data,
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