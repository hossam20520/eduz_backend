<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ReviewsController extends Controller
{

    //------------ GET ALL Reviews -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Review::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $reviews = Review::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $reviews->count();
        $reviews = $reviews->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'reviews' => $reviews,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Review -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Review::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/reviews/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Review = new Review;

            $Review->en_name = $request['en_name'];
            $Review->ar_name = $request['ar_name'];
            $Review->image = $filename;
            $Review->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Review -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Review::class);
 
        //  request()->validate([
        //      'ar_name' => 'required',
        //  ]);
         \DB::transaction(function () use ($request, $id) {
             $Review = Review::findOrFail($id);
           
 
       
 
             Review::whereId($id)->update([
                 'approve' => $request['approve'],
              
               
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Review -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Review::class);

        Review::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Review::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $review_id) {
            Review::whereId($review_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

