<?php
namespace App\Http\Controllers;

use App\Models\Gov;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class GovsController extends Controller
{

    //------------ GET ALL Govs -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Gov::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $govs = Gov::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $govs->count();
        $govs = $govs->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'govs' => $govs,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Gov -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Gov::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

   

            $Gov = new Gov;

            $Gov->en_name = $request['en_name'];
            $Gov->ar_name = $request['ar_name'];
       
            $Gov->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Gov -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Gov::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Gov = Gov::findOrFail($id);
           
 
  
             Gov::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
               
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Gov -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Gov::class);

        Gov::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Gov::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $gov_id) {
            Gov::whereId($gov_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

