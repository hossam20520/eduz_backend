<?php
namespace App\Http\Controllers;
use App\Exports\EducationsExport;
use App\Models\Education;
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


class EducationsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Education::class);
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

        $educations = Education::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($educations, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('educations.en_info', 'LIKE', "%{$request->search}%")
                        ->orWhere('educations.ar_info', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $educations = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($educations as $education) {
            $item['id'] = $education->id;
            $item['en_name'] = $education->en_name;
            $item['ar_name'] = $education->ar_name;

            $item['en_info'] = $education->en_info;
            $item['ar_info'] = $education->ar_info;
            $item['facilities_ar'] = $education->facilities_ar;
            $item['facilities_en'] = $education->facilities_en;
            $item['activities_ar'] = $education->activities_ar;
            $item['activities_en'] = $education->activities_en;
            $item['url'] = $education->url;
            $item['phone'] = $education->phone;
            $item['share'] = $education->share;
            $item['institution'] = Institution::find($education->institution_id)->ar_name;
            $firstimage = explode(',', $education->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
 
 
 
 
        // // $Education->activities_image = $request['activities_image'];
        // $Education->institution_id = $request['institution_id'];
        // // $Education->review_id = $request['review_id'];

 

        return response()->json([
 
            'educations' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Education  ---------------\

    public function store(Request $request)
    {


        // $this->authorizeForUser($request->user('api'), 'create', Education::class);

        try {
            $this->validate($request, [
                'en_info' => 'required',
                'ar_info' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {




                
    
      
 
 

                //-- Create New Education
                $Education = new Education;

                //-- Field Required
                $Education->en_info = $request['en_info'];
                $Education->ar_info = $request['ar_info'];
                $Education->facilities_ar = $request['facilities_ar'];
                $Education->facilities_en = $request['facilities_en'];
                $Education->activities_ar = $request['activities_ar'];
                $Education->activities_en = $request['activities_en'];
                $Education->url = $request['url'];
                $Education->phone = $request['phone'];
                $Education->share = $request['share'];
                $Education->en_name = $request['en_name'];
                $Education->ar_name = $request['ar_name'];

  
                // $Education->activities_image = $request['activities_image'];
                $Education->institution_id = $request['inst_id'];
                // $Education->review_id = $request['review_id'];

 

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/educations/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Education->image = $filename;
                $Education->save();

  

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

    //-------------- Update Education  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', Education::class);
        try {
            $this->validate($request, [
  
                'en_info' => 'required',
                'ar_info' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Education = Education::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 

                    
                //-- Update Education
                $Education->en_info = $request['en_info'];
                $Education->ar_info = $request['ar_info'];
                $Education->facilities_ar = $request['facilities_ar'];
                $Education->facilities_en = $request['facilities_en'];
                $Education->activities_ar = $request['activities_ar'];
                $Education->activities_en = $request['activities_en'];
                $Education->url = $request['url'];
                $Education->phone = $request['phone'];
                $Education->share = $request['share'];

                $Education->en_name = $request['en_name'];
                $Education->ar_name = $request['ar_name'];
                // $Education->activities_image = $request['activities_image'];
                // $Education->institution_id = $request['institution_id'];
                $Education->institution_id = $request['institution_id'];
                // $Education->review_id = $request['review_id'];
                 
         
         
    


 

                if ($request['images'] === null) {

                    if ($Education->image !== null) {
                        foreach (explode(',', $Education->image) as $img) {
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
                    if ($Education->image !== null) {
                        foreach (explode(',', $Education->image) as $img) {
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
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/educations/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Education->image = $filename;
                $Education->save();

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

    //-------------- Remove Education  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Education::class);

        \DB::transaction(function () use ($id) {

            $Education = Education::findOrFail($id);
            $Education->deleted_at = Carbon::now();
            $Education->save();

            foreach (explode(',', $Education->image) as $img) {
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
        // $this->authorizeForUser($request->user('api'), 'delete', Education::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $education_id) {

                $Education = Education::findOrFail($education_id);
                $Education->deleted_at = Carbon::now();
                $Education->save();

                foreach (explode(',', $Education->image) as $img) {
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

    //-------------- Export All Education to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Education::class);

        return Excel::download(new EducationsExport, 'List_Educations.xlsx');
    }




    //--------------  Show Education Details ---------------\
    public function Get_Educations_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Education::class);

        $Education = Education::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Education->id;
        $item['ar_name'] = $Education->ar_name;
        $item['en_name'] = $Education->en_name;
 
        $item['en_info'] = $Education->en_info;
        $item['ar_info'] = $Education->ar_info;

        $item['facilities_ar'] = $Education->facilities_ar;
        $item['facilities_en'] = $Education->facilities_en;


        $item['activities_ar'] = $Education->activities_ar;
        $item['activities_en'] = $Education->activities_en;


        $item['url'] = $Education->url;
        $item['phone'] = $Education->phone;


        $item['share'] = $Education->share;
        $item['institution_id'] = $Education->institution_id;

 
   
        if ($Education->image != '') {
            foreach (explode(',', $Education->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Educations By Warehouse -----------------\

    public function Educations_by_Warehouse(request $request, $id)
    {
        $data = [];
        $education_warehouse_data = education_warehouse::with('warehouse', 'Education', 'educationVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($education_warehouse_data as $education_warehouse) {

            if ($education_warehouse->education_variant_id) {
                $item['education_variant_id'] = $education_warehouse->education_variant_id;
                $item['code'] = $education_warehouse['educationVariant']->name . '-' . $education_warehouse['education']->code;
                $item['Variant'] = $education_warehouse['educationVariant']->name;
            } else {
                $item['education_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $education_warehouse['education']->code;
            }

            $item['id'] = $education_warehouse->education_id;
            $item['name'] = $education_warehouse['education']->name;
            $item['barcode'] = $education_warehouse['education']->code;
            $item['Type_barcode'] = $education_warehouse['education']->Type_barcode;
            $firstimage = explode(',', $education_warehouse['education']->image);
            $item['image'] = $firstimage[0];

            if ($education_warehouse['education']['unitSale']->operator == '/') {
                $item['qte_sale'] = $education_warehouse->qte * $education_warehouse['education']['unitSale']->operator_value;
                $price = $education_warehouse['education']->price / $education_warehouse['education']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $education_warehouse->qte / $education_warehouse['education']['unitSale']->operator_value;
                $price = $education_warehouse['education']->price * $education_warehouse['education']['unitSale']->operator_value;
            }

            if ($education_warehouse['education']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($education_warehouse->qte * $education_warehouse['education']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($education_warehouse->qte / $education_warehouse['education']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $education_warehouse->qte;
            $item['unitSale'] = $education_warehouse['education']['unitSale']->ShortName;
            $item['unitPurchase'] = $education_warehouse['education']['unitPurchase']->ShortName;

            if ($education_warehouse['education']->TaxNet !== 0.0) {
                //Exclusive
                if ($education_warehouse['education']->tax_method == '1') {
                    $tax_price = $price * $education_warehouse['education']->TaxNet / 100;
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

    //------------ Get education By ID -----------------\

    public function show($id)
    {

        $Education_data = Education::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Education_data['id'];
        $item['ar_name'] = $Education_data['ar_name'];
        $item['en_name'] = $Education_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Education ---------------\

    public function create(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'create', Education::class);

        $Education_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        return response()->json([
            'educations' =>  $Education_data ,
        ]);

    }

 

    //---------------- Show Form Edit Education ---------------\

    public function edit(Request $request, $id)
    {

        $Education_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
    
        // $this->authorizeForUser($request->user('api'), 'update', Education::class);
        $Education = Education::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Education->id;
        $item['en_info'] = $Education->en_info;
        $item['ar_info'] = $Education->ar_info;

        $item['facilities_ar'] = $Education->facilities_ar;
        $item['facilities_en'] = $Education->facilities_en;


        $item['activities_ar'] = $Education->activities_ar;
        $item['activities_en'] = $Education->activities_en;


        $item['url'] = $Education->url;
        $item['phone'] = $Education->phone;


        $item['share'] = $Education->share;
        $item['institution_id'] = $Education->institution_id;


        $item['en_name'] =  $Education->en_name;
        $item['ar_name'] =  $Education->ar_name;


        $firstimage = explode(',', $Education->image);
        $item['image'] = $firstimage[0];
          
 
 
        $item['images'] = [];
        if ($Education->image != '' && $Education->image != 'no-image.png') {
            foreach (explode(',', $Education->image) as $img) {
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

        return response()->json([
            'education' => $data,
            'educations' =>  $Education_data ,
        ]);

    }

   
    // import Educations
    public function import_educations(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('educations');
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


                 

                    //-- Create New Education
                    foreach ($data as $key => $value) {
    
 
                        $Education = new Education;
                        $Education->ar_name = $value['ar_name'] ;
                        $Education->en_name = $value['en_name'] ;
 
                        $Education->image = 'no-image.png';
                        $Education->save();

                
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