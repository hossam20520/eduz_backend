<?php
namespace App\Http\Controllers;
use App\Exports\TeachersExport;
use App\Models\Teacher;
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


class TeachersController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Teacher::class);
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

        $teachers = Teacher::where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($teachers, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('teachers.ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('teachers.en_name', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $teachers = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($teachers as $teacher) {
            $item['id'] = $teacher->id;
            $item['ar_name'] = $teacher->ar_name;
            $item['en_name'] = $teacher->en_name;
            $item['inst_id'] = $teacher->inst_id;
            $item['ar_country'] = $teacher->ar_country;
            $item['en_country'] = $teacher->en_country;
            $item['en_subject'] = $teacher->en_subject;
            $item['ar_subject'] = $teacher->ar_subject;
            $item['age_from'] = $teacher->age_from;
            $item['age_to'] = $teacher->age_to;
            $item['ar_about'] = $teacher->ar_about;
            $item['en_about'] = $teacher->en_about;
            $item['share'] = $teacher->share;

            $firstimage = explode(',', $teacher->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }

 

        return response()->json([
 
            'teachers' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Teacher  ---------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Teacher::class);

        try {
            $this->validate($request, [
                'ar_name' => 'required',
                'en_name' => 'required',
       
            ]);

            \DB::transaction(function () use ($request) {

                //-- Create New Teacher
                $Teacher = new Teacher;

                //-- Field Required
                $Teacher->ar_name = $request['ar_name'];
                $Teacher->en_name = $request['en_name'];
                $Teacher->inst_id = $request['inst_id'];
                $Teacher->ar_country = $request['ar_country'];
                $Teacher->en_country = $request['en_country'];
                $Teacher->en_subject = $request['en_subject'];
                $Teacher->ar_subject = $request['ar_subject'];
                $Teacher->age_from = $request['age_from'];
                $Teacher->age_to = $request['age_to'];
                $Teacher->ar_about = $request['ar_about'];
                $Teacher->en_about = $request['en_about'];
                $Teacher->share = $request['share'];
                $Teacher->lat = $request['lat'];
                $Teacher->long_a = $request['long'];
      

                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                    
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/teachers/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Teacher->image = $filename;
                $Teacher->save();

  

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

    //-------------- Update Teacher  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', Teacher::class);
        try {
            $this->validate($request, [
  
                'ar_name' => 'required',
                'en_name' => 'required',
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Teacher = Teacher::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();

                //-- Update Teacher
                $Teacher->ar_name = $request['ar_name'];
                $Teacher->en_name = $request['en_name'];
                $Teacher->inst_id = $request['inst_id'];
                $Teacher->ar_country = $request['ar_country'];
                $Teacher->en_country = $request['en_country'];
                $Teacher->en_subject = $request['en_subject'];
                $Teacher->ar_subject = $request['ar_subject'];
                $Teacher->age_from = $request['age_from'];
                $Teacher->age_to = $request['age_to'];
                $Teacher->ar_about = $request['ar_about'];
                $Teacher->en_about = $request['en_about'];
                $Teacher->share = $request['share'];
                $Teacher->lat = $request['lat'];
                $Teacher->long_a = $request['long'];
 

                if ($request['images'] === null) {

                    if ($Teacher->image !== null) {
                        foreach (explode(',', $Teacher->image) as $img) {
                            $pathIMG = public_path() . '/images/teachers/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Teacher->image !== null) {
                        foreach (explode(',', $Teacher->image) as $img) {
                            $pathIMG = public_path() . '/images/teachers/' . $img;
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
                      
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/teachers/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);
                }

                $Teacher->image = $filename;
                $Teacher->save();

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

    //-------------- Remove Teacher  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Teacher::class);

        \DB::transaction(function () use ($id) {

            $Teacher = Teacher::findOrFail($id);
            $Teacher->deleted_at = Carbon::now();
            $Teacher->save();

            foreach (explode(',', $Teacher->image) as $img) {
                $pathIMG = public_path() . '/images/teachers/' . $img;
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
        // $this->authorizeForUser($request->user('api'), 'delete', Teacher::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $teacher_id) {

                $Teacher = Teacher::findOrFail($teacher_id);
                $Teacher->deleted_at = Carbon::now();
                $Teacher->save();

                foreach (explode(',', $Teacher->image) as $img) {
                    $pathIMG = public_path() . '/images/teachers/' . $img;
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

    //-------------- Export All Teacher to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Teacher::class);

        return Excel::download(new TeachersExport, 'List_Teachers.xlsx');
    }




    //--------------  Show Teacher Details ---------------\
    public function Get_Teachers_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Teacher::class);

        $Teacher = Teacher::where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Teacher->id;
        $item['ar_name'] = $Teacher->ar_name;
        $item['en_name'] = $Teacher->en_name;

        $item['inst_id'] = $Teacher->inst_id;
        $item['ar_country'] = $Teacher->ar_country;
        $item['en_country'] = $Teacher->en_country;
        $item['en_subject'] = $Teacher->en_subject;
        $item['ar_subject'] = $Teacher->ar_subject;
        $item['age_from'] = $Teacher->age_from;
        $item['age_to'] = $Teacher->age_to;
        $item['ar_about'] = $Teacher->ar_about;
        $item['en_about'] = $Teacher->en_about;
        $item['share'] = $Teacher->share;
 
   
        if ($Teacher->image != '') {
            foreach (explode(',', $Teacher->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }
 
    //------------ Get teacher By ID -----------------\

    public function show($id)
    {

        $Teacher_data = Teacher::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Teacher_data['id'];
        $item['ar_name'] = $Teacher_data['ar_name'];
        $item['en_name'] = $Teacher_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Teacher ---------------\

    public function create(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'create', Teacher::class);

        $Education_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
        return response()->json([
            'educations' =>  $Education_data ,
        ]);
 
     
    }

 

    //---------------- Show Form Edit Teacher ---------------\

    public function edit(Request $request, $id)
    {
    
        // $this->authorizeForUser($request->user('api'), 'update', Teacher::class);
        $Teacher = Teacher::where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Teacher->id;
        $item['ar_name'] = $Teacher->ar_name;
        $item['en_name'] = $Teacher->en_name;
        $item['inst_id'] = $Teacher->inst_id;
        $item['ar_country'] = $Teacher->ar_country;
        $item['en_country'] = $Teacher->en_country;
        $item['en_subject'] = $Teacher->en_subject;
        $item['ar_subject'] = $Teacher->ar_subject;
        $item['age_from'] = $Teacher->age_from;
        $item['age_to'] = $Teacher->age_to;
        $item['ar_about'] = $Teacher->ar_about;
        $item['en_about'] = $Teacher->en_about;
        $item['share'] = $Teacher->share;



 
 
        $item['images'] = [];
        if ($Teacher->image != '' && $Teacher->image != 'no-image.png') {
            foreach (explode(',', $Teacher->image) as $img) {
                $path = public_path() . '/images/teachers/' . $img;
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


        $Education_data = Institution::where('deleted_at', '=', null)->get(['id', 'ar_name']);
 

        return response()->json([
            'teacher' => $data,
            'educations' =>  $Education_data ,
        ]);

    }

   
    // import Teachers
    public function import_teachers(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('teachers');
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


                 

                    //-- Create New Teacher
                    foreach ($data as $key => $value) {
    
 
                        $Teacher = new Teacher;
                        $Teacher->ar_name = $value['ar_name'] ;
                        $Teacher->en_name = $value['en_name'] ;
 
                        $Teacher->image = 'no-image.png';
                        $Teacher->save();

                
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