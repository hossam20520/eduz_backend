<?php
namespace App\Http\Controllers;
use App\Exports\KindergrantsExport;
use App\Models\Kindergrant;
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


class KindergrantsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Kindergrant::class);
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

        $kindergrants = Kindergrant::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($kindergrants, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('kindergrants.ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('kindergrants.en_name', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $kindergrants = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($kindergrants as $kindergrant) {
            $item['id'] = $kindergrant->id;
            $item['ar_name'] = $kindergrant->ar_name;
            $item['en_name'] = $kindergrant->en_name;
            $firstimage = explode(',', $kindergrant->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }

 

        return response()->json([
 
            'kindergrants' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Kindergrant  ---------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Kindergrant::class);

        try {
            $this->validate($request, [
                'ar_name' => 'required',
                'en_name' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

                //-- Create New Kindergrant
                $Kindergrant = new Kindergrant;

                //-- Field Required
                $Kindergrant->ar_name = $request['ar_name'];
                $Kindergrant->en_name = $request['en_name'];

 

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/kindergrants/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Kindergrant->image = $filename;
                $Kindergrant->save();

  

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

    //-------------- Update Kindergrant  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', Kindergrant::class);
        try {
            $this->validate($request, [
  
                'ar_name' => 'required',
                'en_name' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Kindergrant = Kindergrant::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();

                //-- Update Kindergrant
                $Kindergrant->ar_name = $request['ar_name'];
                $Kindergrant->en_name = $request['en_name'];
                 

         
    


 

                if ($request['images'] === null) {

                    if ($Kindergrant->image !== null) {
                        foreach (explode(',', $Kindergrant->image) as $img) {
                            $pathIMG = public_path() . '/images/kindergrants/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Kindergrant->image !== null) {
                        foreach (explode(',', $Kindergrant->image) as $img) {
                            $pathIMG = public_path() . '/images/kindergrants/' . $img;
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
                        $path = public_path() . '/images/kindergrants/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Kindergrant->image = $filename;
                $Kindergrant->save();

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

    //-------------- Remove Kindergrant  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Kindergrant::class);

        \DB::transaction(function () use ($id) {

            $Kindergrant = Kindergrant::findOrFail($id);
            $Kindergrant->deleted_at = Carbon::now();
            $Kindergrant->save();

            foreach (explode(',', $Kindergrant->image) as $img) {
                $pathIMG = public_path() . '/images/kindergrants/' . $img;
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
        // $this->authorizeForUser($request->user('api'), 'delete', Kindergrant::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $kindergrant_id) {

                $Kindergrant = Kindergrant::findOrFail($kindergrant_id);
                $Kindergrant->deleted_at = Carbon::now();
                $Kindergrant->save();

                foreach (explode(',', $Kindergrant->image) as $img) {
                    $pathIMG = public_path() . '/images/kindergrants/' . $img;
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

    //-------------- Export All Kindergrant to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'view', Kindergrant::class);

        return Excel::download(new KindergrantsExport, 'List_Kindergrants.xlsx');
    }




    //--------------  Show Kindergrant Details ---------------\
    public function Get_Kindergrants_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Kindergrant::class);

        $Kindergrant = Kindergrant::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Kindergrant->id;
        $item['ar_name'] = $Kindergrant->ar_name;
        $item['en_name'] = $Kindergrant->en_name;
 

   
        if ($Kindergrant->image != '') {
            foreach (explode(',', $Kindergrant->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Kindergrants By Warehouse -----------------\

    public function Kindergrants_by_Warehouse(request $request, $id)
    {
        $data = [];
        $kindergrant_warehouse_data = kindergrant_warehouse::with('warehouse', 'Kindergrant', 'kindergrantVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($kindergrant_warehouse_data as $kindergrant_warehouse) {

            if ($kindergrant_warehouse->kindergrant_variant_id) {
                $item['kindergrant_variant_id'] = $kindergrant_warehouse->kindergrant_variant_id;
                $item['code'] = $kindergrant_warehouse['kindergrantVariant']->name . '-' . $kindergrant_warehouse['kindergrant']->code;
                $item['Variant'] = $kindergrant_warehouse['kindergrantVariant']->name;
            } else {
                $item['kindergrant_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $kindergrant_warehouse['kindergrant']->code;
            }

            $item['id'] = $kindergrant_warehouse->kindergrant_id;
            $item['name'] = $kindergrant_warehouse['kindergrant']->name;
            $item['barcode'] = $kindergrant_warehouse['kindergrant']->code;
            $item['Type_barcode'] = $kindergrant_warehouse['kindergrant']->Type_barcode;
            $firstimage = explode(',', $kindergrant_warehouse['kindergrant']->image);
            $item['image'] = $firstimage[0];

            if ($kindergrant_warehouse['kindergrant']['unitSale']->operator == '/') {
                $item['qte_sale'] = $kindergrant_warehouse->qte * $kindergrant_warehouse['kindergrant']['unitSale']->operator_value;
                $price = $kindergrant_warehouse['kindergrant']->price / $kindergrant_warehouse['kindergrant']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $kindergrant_warehouse->qte / $kindergrant_warehouse['kindergrant']['unitSale']->operator_value;
                $price = $kindergrant_warehouse['kindergrant']->price * $kindergrant_warehouse['kindergrant']['unitSale']->operator_value;
            }

            if ($kindergrant_warehouse['kindergrant']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($kindergrant_warehouse->qte * $kindergrant_warehouse['kindergrant']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($kindergrant_warehouse->qte / $kindergrant_warehouse['kindergrant']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $kindergrant_warehouse->qte;
            $item['unitSale'] = $kindergrant_warehouse['kindergrant']['unitSale']->ShortName;
            $item['unitPurchase'] = $kindergrant_warehouse['kindergrant']['unitPurchase']->ShortName;

            if ($kindergrant_warehouse['kindergrant']->TaxNet !== 0.0) {
                //Exclusive
                if ($kindergrant_warehouse['kindergrant']->tax_method == '1') {
                    $tax_price = $price * $kindergrant_warehouse['kindergrant']->TaxNet / 100;
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

    //------------ Get kindergrant By ID -----------------\

    public function show($id)
    {

        $Kindergrant_data = Kindergrant::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Kindergrant_data['id'];
        $item['ar_name'] = $Kindergrant_data['ar_name'];
        $item['en_name'] = $Kindergrant_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Kindergrant ---------------\

    public function create(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'create', Kindergrant::class);

 
        return response()->json([
     
      
            'data' => 5,
        ]);

    }

 

    //---------------- Show Form Edit Kindergrant ---------------\

    public function edit(Request $request, $id)
    {
    
        $this->authorizeForUser($request->user('api'), 'update', Kindergrant::class);
        $Kindergrant = Kindergrant::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Kindergrant->id;
        $item['ar_name'] = $Kindergrant->ar_name;
        $item['en_name'] = $Kindergrant->en_name;
 
 
        $item['images'] = [];
        if ($Kindergrant->image != '' && $Kindergrant->image != 'no-image.png') {
            foreach (explode(',', $Kindergrant->image) as $img) {
                $path = public_path() . '/images/kindergrants/' . $img;
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
            'kindergrant' => $data,
        ]);

    }

   
    // import Kindergrants
    public function import_kindergrants(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('kindergrants');
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


                 

                    //-- Create New Kindergrant
                    foreach ($data as $key => $value) {
    
 
                        $Kindergrant = new Kindergrant;
                        $Kindergrant->ar_name = $value['ar_name'] ;
                        $Kindergrant->en_name = $value['en_name'] ;
 
                        $Kindergrant->image = 'no-image.png';
                        $Kindergrant->save();

                
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