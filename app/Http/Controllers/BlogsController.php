<?php
namespace App\Http\Controllers;
use App\Exports\BlogsExport;
use App\Models\Blog;
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


class BlogsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Blog::class);
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

        $blogs = Blog::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($blogs, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('blogs.ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('blogs.en_name', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $blogs = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($blogs as $blog) {
            $item['id'] = $blog->id;
            $item['ar_name'] = $blog->ar_name;
            $item['en_name'] = $blog->en_name;
            $firstimage = explode(',', $blog->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }

 

        return response()->json([
 
            'blogs' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Blog  ---------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Blog::class);

        try {
            $this->validate($request, [
                'ar_name' => 'required',
                'en_name' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

                //-- Create New Blog
                $Blog = new Blog;

                //-- Field Required
                $Blog->ar_name = $request['ar_name'];
                $Blog->en_name = $request['en_name'];
                $Blog->ar_blog = $request['ar_blog'];
                $Blog->en_blog = $request['en_blog'];
                $Blog->date = $request['date'];

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/blogs/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Blog->image = $filename;
                $Blog->save();

  

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

    //-------------- Update Blog  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', Blog::class);
        try {
            $this->validate($request, [
  
                'ar_name' => 'required',
                'en_name' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Blog = Blog::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();

                //-- Update Blog
                $Blog->ar_name = $request['ar_name'];
                $Blog->en_name = $request['en_name'];
 
                $Blog->ar_blog = $request['ar_blog'];
                $Blog->en_blog = $request['en_blog'];
                $Blog->date = $request['date'];

         
    


 

                if ($request['images'] === null) {

                    if ($Blog->image !== null) {
                        foreach (explode(',', $Blog->image) as $img) {
                            $pathIMG = public_path() . '/images/blogs/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Blog->image !== null) {
                        foreach (explode(',', $Blog->image) as $img) {
                            $pathIMG = public_path() . '/images/blogs/' . $img;
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
                        $path = public_path() . '/images/blogs/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Blog->image = $filename;
                $Blog->save();

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

    //-------------- Remove Blog  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Blog::class);

        \DB::transaction(function () use ($id) {

            $Blog = Blog::findOrFail($id);
            $Blog->deleted_at = Carbon::now();
            $Blog->save();

            foreach (explode(',', $Blog->image) as $img) {
                $pathIMG = public_path() . '/images/blogs/' . $img;
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
        // $this->authorizeForUser($request->user('api'), 'delete', Blog::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $blog_id) {

                $Blog = Blog::findOrFail($blog_id);
                $Blog->deleted_at = Carbon::now();
                $Blog->save();

                foreach (explode(',', $Blog->image) as $img) {
                    $pathIMG = public_path() . '/images/blogs/' . $img;
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

    //-------------- Export All Blog to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Blog::class);

        return Excel::download(new BlogsExport, 'List_Blogs.xlsx');
    }




    //--------------  Show Blog Details ---------------\
    public function Get_Blogs_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Blog::class);

        $Blog = Blog::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Blog->id;
        $item['ar_name'] = $Blog->ar_name;
        $item['en_name'] = $Blog->en_name;
        $item['ar_blog'] = $Blog->ar_blog;
        $item['en_blog'] = $Blog->en_blog;
        $item['date'] = $Blog->date;

 

   
        if ($Blog->image != '') {
            foreach (explode(',', $Blog->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Blogs By Warehouse -----------------\

    public function Blogs_by_Warehouse(request $request, $id)
    {
        $data = [];
        $blog_warehouse_data = blog_warehouse::with('warehouse', 'Blog', 'blogVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($blog_warehouse_data as $blog_warehouse) {

            if ($blog_warehouse->blog_variant_id) {
                $item['blog_variant_id'] = $blog_warehouse->blog_variant_id;
                $item['code'] = $blog_warehouse['blogVariant']->name . '-' . $blog_warehouse['blog']->code;
                $item['Variant'] = $blog_warehouse['blogVariant']->name;
            } else {
                $item['blog_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $blog_warehouse['blog']->code;
            }

            $item['id'] = $blog_warehouse->blog_id;
            $item['name'] = $blog_warehouse['blog']->name;
            $item['barcode'] = $blog_warehouse['blog']->code;
            $item['Type_barcode'] = $blog_warehouse['blog']->Type_barcode;
            $firstimage = explode(',', $blog_warehouse['blog']->image);
            $item['image'] = $firstimage[0];

            if ($blog_warehouse['blog']['unitSale']->operator == '/') {
                $item['qte_sale'] = $blog_warehouse->qte * $blog_warehouse['blog']['unitSale']->operator_value;
                $price = $blog_warehouse['blog']->price / $blog_warehouse['blog']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $blog_warehouse->qte / $blog_warehouse['blog']['unitSale']->operator_value;
                $price = $blog_warehouse['blog']->price * $blog_warehouse['blog']['unitSale']->operator_value;
            }

            if ($blog_warehouse['blog']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($blog_warehouse->qte * $blog_warehouse['blog']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($blog_warehouse->qte / $blog_warehouse['blog']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $blog_warehouse->qte;
            $item['unitSale'] = $blog_warehouse['blog']['unitSale']->ShortName;
            $item['unitPurchase'] = $blog_warehouse['blog']['unitPurchase']->ShortName;

            if ($blog_warehouse['blog']->TaxNet !== 0.0) {
                //Exclusive
                if ($blog_warehouse['blog']->tax_method == '1') {
                    $tax_price = $price * $blog_warehouse['blog']->TaxNet / 100;
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

    //------------ Get blog By ID -----------------\

    public function show($id)
    {

        $Blog_data = Blog::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Blog_data['id'];
        $item['ar_name'] = $Blog_data['ar_name'];
        $item['en_name'] = $Blog_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Blog ---------------\

    public function create(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'create', Blog::class);

 
        return response()->json([
     
      
            'data' => 5,
        ]);

    }

 

    //---------------- Show Form Edit Blog ---------------\

    public function edit(Request $request, $id)
    {
    
        // $this->authorizeForUser($request->user('api'), 'update', Blog::class);
        $Blog = Blog::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Blog->id;
        $item['ar_name'] = $Blog->ar_name;
        $item['en_name'] = $Blog->en_name;
        $item['ar_blog'] = $Blog->ar_blog;
        $item['en_blog'] = $Blog->en_blog;
        $item['date'] = $Blog->date;
 
        $item['images'] = [];
        if ($Blog->image != '' && $Blog->image != 'no-image.png') {
            foreach (explode(',', $Blog->image) as $img) {
                $path = public_path() . '/images/blogs/' . $img;
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
            'blog' => $data,
        ]);

    }

   
    // import Blogs
    public function import_blogs(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('blogs');
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


                 

                    //-- Create New Blog
                    foreach ($data as $key => $value) {
    
 
                        $Blog = new Blog;
                        $Blog->ar_name = $value['ar_name'] ;
                        $Blog->en_name = $value['en_name'] ;
 
                        $Blog->image = 'no-image.png';
                        $Blog->save();

                
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