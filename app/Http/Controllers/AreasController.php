<?php
namespace App\Http\Controllers;

use App\Models\Area;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AreasController extends Controller
{

    //------------ GET ALL Areas -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Area::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $areas = Area::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $areas->count();
        $areas = $areas->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'areas' => $areas,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Area -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Area::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

      

            $Area = new Area;

            $Area->en_name = $request['en_name'];
            $Area->ar_name = $request['ar_name'];
       
            $Area->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Area -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Area::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Area = Area::findOrFail($id);
 
 
             Area::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
              
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Area -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Area::class);

        Area::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Area::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $area_id) {
            Area::whereId($area_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

