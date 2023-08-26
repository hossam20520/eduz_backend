<?php
namespace App\Http\Controllers;

use App\Models\Recently;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

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

        return response()->json([
            'recentlys' => $recentlys,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Recently -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Recently::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/recentlys/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

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
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Recently = Recently::findOrFail($id);
             $currentImage = $Recently->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/recentlys';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/recentlys/' . $filename));
 
                 $RecentlyImage = $path . '/' . $currentImage;
                 if (file_exists($RecentlyImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($RecentlyImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/recentlys';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/recentlys/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 

             
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

