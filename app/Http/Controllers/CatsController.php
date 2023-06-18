<?php
namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Institution;

use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class CatsController extends Controller
{

    //------------ GET ALL Cats -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Cat::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        $Institution = Institution::where('deleted_at', '=', null)->get(['ar_name', 'id', 'en_name']);
        $cats = Cat::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $cats->count();
        $cats = $cats->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'cats' => $cats,
            'institution'=>   $Institution,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Cat -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Cat::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/cats/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Cat = new Cat;
 
            $Cat->institution_id = $request['institution_id'];
            $Cat->en_name = $request['en_name'];
            $Cat->ar_name = $request['ar_name'];
            $Cat->image = $filename;
            $Cat->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Cat -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Cat::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Cat = Cat::findOrFail($id);
             $currentImage = $Cat->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/cats';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/cats/' . $filename));
 
                 $CatImage = $path . '/' . $currentImage;
                 if (file_exists($CatImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($CatImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/cats';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/cats/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Cat::whereId($id)->update([
                'institution_id'=> $request['institution_id'],
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Cat -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Cat::class);

        Cat::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Cat::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $cat_id) {
            Cat::whereId($cat_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

