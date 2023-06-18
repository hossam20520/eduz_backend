<?php
namespace App\Http\Controllers;
use App\Exports\FormsExport;
use App\Models\Form;
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


class FormsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Form::class);
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

        $forms = Form::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($forms, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('forms.ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('forms.en_name', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $forms = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($forms as $form) {
            $item['id'] = $form->id;
            $item['ar_name'] = $form->ar_name;
            $item['en_name'] = $form->en_name;
            $firstimage = explode(',', $form->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }

 

        return response()->json([
 
            'forms' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Form  ---------------\

    public function store(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'create', Form::class);

        try {
            $this->validate($request, [
                'ar_name' => 'required',
                'en_name' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

                //-- Create New Form
                $Form = new Form;

                //-- Field Required
                $Form->ar_name = $request['ar_name'];
                $Form->en_name = $request['en_name'];

 

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/forms/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Form->image = $filename;
                $Form->save();

  

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

    //-------------- Update Form  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        $this->authorizeForUser($request->user('api'), 'update', Form::class);
        try {
            $this->validate($request, [
  
                'ar_name' => 'required',
                'en_name' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Form = Form::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();

                //-- Update Form
                $Form->ar_name = $request['ar_name'];
                $Form->en_name = $request['en_name'];
                 

         
    


 

                if ($request['images'] === null) {

                    if ($Form->image !== null) {
                        foreach (explode(',', $Form->image) as $img) {
                            $pathIMG = public_path() . '/images/forms/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Form->image !== null) {
                        foreach (explode(',', $Form->image) as $img) {
                            $pathIMG = public_path() . '/images/forms/' . $img;
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
                        $path = public_path() . '/images/forms/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Form->image = $filename;
                $Form->save();

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

    //-------------- Remove Form  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        $this->authorizeForUser($request->user('api'), 'delete', Form::class);

        \DB::transaction(function () use ($id) {

            $Form = Form::findOrFail($id);
            $Form->deleted_at = Carbon::now();
            $Form->save();

            foreach (explode(',', $Form->image) as $img) {
                $pathIMG = public_path() . '/images/forms/' . $img;
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
        $this->authorizeForUser($request->user('api'), 'delete', Form::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $form_id) {

                $Form = Form::findOrFail($form_id);
                $Form->deleted_at = Carbon::now();
                $Form->save();

                foreach (explode(',', $Form->image) as $img) {
                    $pathIMG = public_path() . '/images/forms/' . $img;
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

    //-------------- Export All Form to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'view', Form::class);

        return Excel::download(new FormsExport, 'List_Forms.xlsx');
    }




    //--------------  Show Form Details ---------------\
    public function Get_Forms_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Form::class);

        $Form = Form::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Form->id;
        $item['ar_name'] = $Form->ar_name;
        $item['en_name'] = $Form->en_name;
 

   
        if ($Form->image != '') {
            foreach (explode(',', $Form->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Forms By Warehouse -----------------\

    public function Forms_by_Warehouse(request $request, $id)
    {
        $data = [];
        $form_warehouse_data = form_warehouse::with('warehouse', 'Form', 'formVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($form_warehouse_data as $form_warehouse) {

            if ($form_warehouse->form_variant_id) {
                $item['form_variant_id'] = $form_warehouse->form_variant_id;
                $item['code'] = $form_warehouse['formVariant']->name . '-' . $form_warehouse['form']->code;
                $item['Variant'] = $form_warehouse['formVariant']->name;
            } else {
                $item['form_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $form_warehouse['form']->code;
            }

            $item['id'] = $form_warehouse->form_id;
            $item['name'] = $form_warehouse['form']->name;
            $item['barcode'] = $form_warehouse['form']->code;
            $item['Type_barcode'] = $form_warehouse['form']->Type_barcode;
            $firstimage = explode(',', $form_warehouse['form']->image);
            $item['image'] = $firstimage[0];

            if ($form_warehouse['form']['unitSale']->operator == '/') {
                $item['qte_sale'] = $form_warehouse->qte * $form_warehouse['form']['unitSale']->operator_value;
                $price = $form_warehouse['form']->price / $form_warehouse['form']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $form_warehouse->qte / $form_warehouse['form']['unitSale']->operator_value;
                $price = $form_warehouse['form']->price * $form_warehouse['form']['unitSale']->operator_value;
            }

            if ($form_warehouse['form']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($form_warehouse->qte * $form_warehouse['form']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($form_warehouse->qte / $form_warehouse['form']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $form_warehouse->qte;
            $item['unitSale'] = $form_warehouse['form']['unitSale']->ShortName;
            $item['unitPurchase'] = $form_warehouse['form']['unitPurchase']->ShortName;

            if ($form_warehouse['form']->TaxNet !== 0.0) {
                //Exclusive
                if ($form_warehouse['form']->tax_method == '1') {
                    $tax_price = $price * $form_warehouse['form']->TaxNet / 100;
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

    //------------ Get form By ID -----------------\

    public function show($id)
    {

        $Form_data = Form::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Form_data['id'];
        $item['ar_name'] = $Form_data['ar_name'];
        $item['en_name'] = $Form_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Form ---------------\

    public function create(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'create', Form::class);

 
        return response()->json([
     
      
            'data' => 5,
        ]);

    }

 

    //---------------- Show Form Edit Form ---------------\

    public function edit(Request $request, $id)
    {
    
        $this->authorizeForUser($request->user('api'), 'update', Form::class);
        $Form = Form::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Form->id;
        $item['ar_name'] = $Form->ar_name;
        $item['en_name'] = $Form->en_name;
 
 
        $item['images'] = [];
        if ($Form->image != '' && $Form->image != 'no-image.png') {
            foreach (explode(',', $Form->image) as $img) {
                $path = public_path() . '/images/forms/' . $img;
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
            'form' => $data,
        ]);

    }

   
    // import Forms
    public function import_forms(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('forms');
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


                 

                    //-- Create New Form
                    foreach ($data as $key => $value) {
    
 
                        $Form = new Form;
                        $Form->ar_name = $value['ar_name'] ;
                        $Form->en_name = $value['en_name'] ;
 
                        $Form->image = 'no-image.png';
                        $Form->save();

                
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