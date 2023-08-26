<?php
namespace App\Http\Controllers;

use App\Models\Deal;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class DealsController extends Controller
{

    //------------ GET ALL Deals -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Deal::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $deals = Deal::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $deals->count();
        $deals = $deals->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'deals' => $deals,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Deal -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Deal::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/deals/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Deal = new Deal;
            $Deal->en_name = $request['en_name'];
            $Deal->ar_name = $request['ar_name'];
            $Deal->ar_desc = $request['ar_desc'];
            $Deal->en_desc = $request['en_desc'];
            $Deal->type = $request['type'];
            $Deal->child_id = $request['child_id'];
            $Deal->image = $filename;
            $Deal->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Deal -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Deal::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Deal = Deal::findOrFail($id);
             $currentImage = $Deal->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/deals';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/deals/' . $filename));
 
                 $DealImage = $path . '/' . $currentImage;
                 if (file_exists($DealImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($DealImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/deals';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                //  $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/deals/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Deal::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
                 'ar_desc' => $request['ar_desc'],
                 'en_desc' => $request['en_desc'],
                 'type' => $request['type'],
                 'child_id' => $request['child_id'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Deal -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Deal::class);

        Deal::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Deal::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $deal_id) {
            Deal::whereId($deal_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

