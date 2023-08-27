<?php
namespace App\Http\Controllers;

use App\Models\Recently;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Education;
use App\Models\Area;
use App\Models\School;
use App\Models\Blog;
use App\Models\Kindergarten;
use App\Models\Center;
use App\Models\Educenter;
use App\Models\Specialneed;
use App\Models\Universitie;
use App\Models\Institution;
use App\Models\Review;
use App\Models\Teacher;


class RecentlysController extends Controller
{

    //------------ GET ALL Recentlys -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Recently::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $recentlys = Recently::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $recentlys->count();
        $recentlys = $recentlys->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


            $data = array();

            foreach ($recentlys as  $recen) {

             $type =  $recen->type;

             $model = School::class;
             if($type == "SCHOOLS"){
               $model = School::class;
             }else if($type == "KINDERGARTENS"){
               $model  = Kindergarten::class;
             }else if($type == "CENTERS"){
               $model  = Center::class;
             }else if($type == "EDUCENTERS"){
               $model  = Educenter::class;
             }else if($type == "SPECIALNEEDS"){
               $model  = Specialneed::class;
             }else if($type == "UNIVERSITIES"){
               $model  = Universitie::class;
             } 
             
             $modV  = $model::where('id' ,$recen->child_id )->first();
                $item['id'] =  $recen->id;
                $item['ar_name'] =  $modV->ar_name;
                $item['en_name'] =  $modV->en_name;
                $item['type'] =  $recen->type;
                $item['child_id'] =  $recen->child_id;
                $data[] = $item;
                # code...
            }

        return response()->json([
            'recentlys' =>  $data,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Recently -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Recently::class);

        // request()->validate([
        //     'ar_name' => 'required',
        // ]);

        \DB::transaction(function () use ($request) {

     

            $Recently = new Recently;

            $Recently->type = $request['type'];
            $Recently->child_id = $request['child_id'];
            // $Recently->image = $filename;
            $Recently->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Recently -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Recently::class);
 
        //  request()->validate([
        //      'ar_name' => 'required',
        //  ]);
         \DB::transaction(function () use ($request, $id) {
             $Recently = Recently::findOrFail($id);
             $currentImage = $Recently->image;
 
    
             
            // $Recently->type = $request['type'];
            // $Recently->child_id = $request['child_id'];
             Recently::whereId($id)->update([
                 'type' => $request['type'],
                 'child_id' => $request['child_id'] 
            
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Recently -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Recently::class);

        Recently::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Recently::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $recently_id) {
            Recently::whereId($recently_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

