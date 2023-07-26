<?php
namespace App\Http\Controllers;

use App\Models\Section;

use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class SectionsController extends Controller
{

    //------------ GET ALL Sections -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Section::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $sections = Section::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $sections->count();
        $sections = $sections->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'sections' => $sections,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Section -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Section::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

 
            $Section = new Section;
            $Section->en_name = $request['en_name'];
            $Section->ar_name = $request['ar_name'];
            $Section->type = $request['type'];
            $Section->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Section -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Section::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Section = Section::findOrFail($id);
            //  $currentImage = $Section->image;
 
             // dd($request->image);
 
             Section::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
                 'type' => $request['type'],
         
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Section -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Section::class);

        Section::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Section::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $section_id) {
            Section::whereId($section_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

