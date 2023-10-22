<?php
namespace App\Http\Controllers;

use App\Models\Drop;
use App\Models\Gov;

use App\Models\Section;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class DropsController extends Controller
{


    


    public function listITemsDev(Request $request){
        $type = $request->type;
        $SECTION = Section::with('drop')->where('deleted_at', '=', null)->where('type',  $type )->get();
        $goves = Gov::where('deleted_at', '=', null)->get(['ar_name' , 'id']);
        return response()->json([
         'SECIONS' => $SECTION,
         'govs' => $goves,
        
     ]);
     }





    public function listITems(Request $request){


        $type = $request->type;
        
        $SECTION = Section::with('drop')->where('deleted_at', '=', null)->where('type',  $type )->get();

       return response()->json([
        'SECIONS' => $SECTION,
       
    ]);
    }

    //------------ GET ALL Drops -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Drop::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $drops = Drop::with('section')->where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $drops->count();
        $drops = $drops->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'drops' => $drops,
            'totalRows' => $totalRows,
        ]);

    }



    public function getTypes(Request $request){

         $type = $request->type;
          
         $secion = Section::where('type',  $type)->where('deleted_at', '=', null)->get(['id', 'ar_name' ,'en_name' ]);

         return response()->json(['types' => $secion]);


        
    }

    //---------------- STORE NEW Drop -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Drop::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

        

            $Drop = new Drop;

            $Drop->en_name = $request['en_name'];
            $Drop->ar_name = $request['ar_name'];
            $Drop->type = $request['type'];
            $Drop->section_type = $request['section_type'];
            
          
            $Drop->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Drop -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Drop::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Drop = Drop::findOrFail($id);
      
  
             Drop::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
                 'type' => $request['type'],
                 'section_type' => $request['section_type'],
  
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Drop -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Drop::class);

        Drop::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Drop::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $drop_id) {
            Drop::whereId($drop_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

