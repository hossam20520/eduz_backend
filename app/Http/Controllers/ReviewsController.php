<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Area;
use App\Models\School;

use App\Models\Kindergarten;
use App\Models\Center;
use App\Models\Educenter;
use App\Models\Specialneed;
use App\Models\Universitie;
use App\Models\Institution;
use App\Models\User;

class ReviewsController extends Controller
{

    //------------ GET ALL Reviews -----------\




    public function GetTheInsts(Request $request){


        $model  = Kindergarten::class;
        
       $type = $request->type;
     

        if($type == "SCHOOLS"){
          $model = School::class;
        }else if($type == "KINDERGARTENS"){
          $model  = Kindergarten::class;
        }else if($type == "CENTERS"){
          $model  = Center::class;
        }else if($type == "SPECIALNEEDS"){
          $model  = Specialneed::class;
        }else if($type == "UNIVERSITIES"){
            $model  = Universitie::class;
          } 

       $data =  $model::where('deleted_at', '=', null)->get(['ar_name' , 'id']);

       return response()->json([

        'insts' =>  $data,
 
      
      ]);
    

   
    }




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

        $reviews = Review::with('user')->where('deleted_at', '=', null)->where(function ($query) use ($request) {
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


           $users =  User::where('deleted_at', '=', null)->get(['email', 'id']);

        return response()->json([
            'reviews' => $reviews,
            'users'=>  $users,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Review -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Review::class);

        // request()->validate([
        //     'ar_name' => 'required',
        // ]);

        \DB::transaction(function () use ($request) {

    

            $Review = new Review;

            $Review->approve = $request['approve'];
            $Review->count = $request['count'];
            $Review->review = $request['review'];
            $Review->user_id = $request['user_id'];
            $Review->inst_id = $request['inst_id'];
            $Review->inst_id = $request['type'];
  
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
                 'count' => $request['count'],
                 'review' => $request['review'],
                 'user_id' => $request['user_id'],
                 'inst_id' => $request['inst_id'],
                 'type' => $request['type'],
 
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

