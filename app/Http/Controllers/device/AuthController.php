<?php

namespace App\Http\Controllers\device;

use Intervention\Image\Gd\Decoder;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\utils\helpers;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use App\Models\role_user;
use App\Models\Calander;
use App\Models\Favourit;
use App\Models\Cart;
use App\Models\Instfav;
use App\Models\Universitie;
use App\Models\School;
use App\Models\Kindergarten;
use App\Models\Center;
use App\Models\Notiform;


use App\Models\Specialneed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Cartitem;
 


class AuthController extends Controller
{
    //


    public function uploadImage(){
        $helpers = new helpers();
        $user =  $helpers->getInfo();


        

    }

    public function GetUsers(Request $request){

        $array = $request->input('arrayData');
  
      
        $data = User::whereIn('id',  $array)->get();
       

        return response()->json(['users' => $data   ], 200);

    }

    public function User(Request $request){
        $helpers = new helpers();
        $user =  $helpers->getInfo();

        $userr = User::where('id' , $user->id)->first();
      
 

        return response()->json(['user' => $userr    ], 200);
      
    }


  public function GetUserByToken( Request $requesta ,  $token){
    $request = Request::create('/api/user', 'GET');
    $request->headers->set('Authorization', 'Bearer ' . $token);

    $response = app()->handle($request);

    $content = $response->getContent();
    $json = json_decode($content, true);
   
    
  
    return response()->json(['user' => $json   , "test"=> $requesta->user_id   ], 200);

  }
     
    public function AddToFavourit(Request $request){
 
        // $helpers = new helpers();
        $user = Auth::user();
        $type = $request->type;


        // Favourit::where('deleted_at', '=', null )->where('user_id', $user->id )->where('user_id', $user->id )
   

        if($type == "PRODUCTS"){
            $fav = Favourit::where('deleted_at', '=', null )->where('user_id', $user->id )->where('product_id', $request['id'])->first();
  
            if(!$fav){
                Favourit::create([
                    'user_id' =>  $user->id,
                    'product_id' => $request['id'],
                ]);
            }
            
        
        }else{
            $fav = Instfav::where('deleted_at', '=', null )->where('user_id', $user->id )->where('inst_id', $request['id'])->first();
            if(!$fav){
                Instfav::create([

                    'user_id' =>  $user->id,
                    'inst_id' => $request['id'],
                    'type' => $type,
                ]); 
            }
         
        }
     
    

        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
    }



    public function DeleteFav(Request $request){

        $id =  $request->id;
        $type = $request->type;
        $product_id = $request->product_id;
        $item = $request->item;

        $user = Auth::user();


       if($type == "PRODUCTS"){
         Favourit::where( 'product_id' ,  $id)->where('user_id' , $user->id)->update([
               'deleted_at' => Carbon::now(),
           ]);

           return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);

        }else{
            Instfav::where( 'inst_id' ,  $id)->where('user_id' , $user->id)->update([
                'deleted_at' => Carbon::now(),
            ]);
            return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
        }




     if( $type == "CART"){
        Favourit::where( 'product_id' ,  $id)->update([
            'deleted_at' => Carbon::now(),
        ]);

        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);


     }else if( $type == "PRODUCTS"){


        $ia = Cart::where('id',  $id )->first();
 
        // $cart =  Cart::where('id',  $ia->id )->delete();
        
        $cartItemc = Cartitem::where('id' ,  $item )->first();

        $total =  $cartItemc->subtotal;
 
        Cart::whereId( $id )->update([
            'total' => floatval( $ia->total ) -  floatval(  $cartItemc->subtotal )  ,
        ]);

        $cartItem = Cartitem::where('cart_id' ,  $ia->id )->where('product_id' , $product_id)->delete();

        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
     }
   
    


       

    }


    public function GetFavouritData(Request $request){
        $helpers = new helpers();
        $user =  $helpers->getInfo();
        $type = $request->type;
        if($type == "PRODUCTS"){
            $products = Favourit::with('product')->where('deleted_at', '=', null )->where('user_id', $user->id )->orderBy( 'id',  'desc')->get();  
            return response()->json([ 'products'=> $products      ], 200);
          }else{

              $inst = Instfav::where('deleted_at', '=', null )->where('user_id', $user->id )->orderBy( 'id',  'desc')->get(); 
           
        
      

        $data = array();
        $model  = Kindergarten::class;
      foreach ($inst as $eduItem) {
            $typeEd = $eduItem->type;


        if($typeEd  == "SCHOOLS"){
            $model = School::class;
          }else if($typeEd  == "KINDERGARTENS"){
            $model  = Kindergarten::class;
          }else if($typeEd  == "CENTERS"){
            $model  = Center::class;
          }else if($typeEd  == "SPECIALNEEDS"){
            $model  = Specialneed::class;
          }else if($typeEd  == "UNIVERSITIES"){
              $model  = Universitie::class;
            } 


        $inst_data  =  $model::where('deleted_at', '=', null )->where('id' , $eduItem->inst_id)->first();

        $item['id'] =  $inst_data->id;
        $item['en_name'] = $inst_data->en_name;
        $item['ar_name'] = $inst_data->ar_name;
        $firstimage = explode(',', $inst_data->image);
        $item['image'] = $firstimage[0];
        $data[] = $item;
    }

            

            
            return response()->json([ 'inst'=> $data , 'products'=> []    ], 200);
        }

    }




    public function GetFavourit(Request $request){
 
        $helpers = new helpers();
        $user =  $helpers->getInfo();
        $type = $request->type;

        if($type == "TEACHERS"){
            // // $fav = Favourit::with('teachers')->where('deleted_at', '=', null )->where('type', $type )->where('user_id', $user->id )->get();  
         
            // $fav = Favourit::with(['teachers' => function ($query) {
            //     $query->select('id',  'lat', 'long_a'  ,  'ar_name', 'en_name', 'ar_country', 'en_country', 'en_subject', 'ar_subject',    'share', 'image');
            // }])
            // ->select('id',   'title', 'teacher_id', 'product_id',   'type', 'created_at' )
            // ->where('deleted_at', null)
            // ->where('type', $type)
            // ->where('user_id', $user->id)
            // ->get(['id', 'user_id', 'title', 'teacher_id', 'product_id', 'inst_id', 'type']);
 
            // return response()->json(['teachers' => $fav ,  'products'=> []  , 'inst'=>  []  ], 200);
      
      
        }else if($type == "PRODUCTS"){
            // $products = Favourit::with('product')->where('deleted_at', '=', null )->where('type',  $type )->where('user_id', $user->id )->get();  
            // return response()->json([   'products'=> $products  , 'inst'=>  []  ], 200);
        }else if($type == "INST"){
            // $inst = Favourit::with('inst')->where('deleted_at', '=', null )->where('type',  $type )->where('user_id', $user->id )->get();  
          
        //     $inst = Favourit::with(['inst' => function ($query) {
        //         $query->select('id', 'type', 'en_name',   'lat', 'long_a'  ,'ar_name',   'url', 'phone', 'share', 'image');
        //     }])
        //     ->select('id', 'user_id', 'title', 'teacher_id', 'product_id', 'inst_id', 'type', )
        //     ->where('deleted_at', null)
        //     ->where('type', $type)
        //     ->where('user_id', $user->id)
        //     ->get(['id', 'user_id', 'title', 'teacher_id', 'product_id', 'inst_id', 'type',  ]);
        //     return response()->json([  'products'=>  []  , 'inst'=> $inst   ], 200);
        }

   
     
    }



    public function GetClanader(Request $request){
 
        $helpers = new helpers();
        $user =  $helpers->getInfo();

        $calander = Calander::where('deleted_at', '=', null )->where('user_id', $user->id )->get();


        return response()->json(['calanders' => $calander    ], 200);
    }


    
    public function AddToCalander(Request $request){
 
        $helpers = new helpers();
        $user =  $helpers->getInfo();

        Calander::create([
            'place' => $request['place'],
            'user_id' =>  $user->id,
            'time' =>  $request['time'],
            'date' => $request['date'],
            'with_one' => $request['with_one'],
            'with_tow' => $request['with_tow'],
        ]);


        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
    }




    public function updateProfile(Request $request){
 
        $helpers = new helpers();
        $user =  $helpers->getInfo();
        User::whereId($user->id)->update([
            'firstname' => $request['firstname'],
            'lastname' =>  $request['lastname'],
            'email' =>  $request['email'],
            'phone' => $request['phone'],
        ]);


        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
    }


    public function getInfoAbout(){


        return response()->json([
            'ar_about'=> "hellollll",
            'en_about'=> 'success',
            'en_term'=> "hellollll",
            'ar_term'=> 'success',
            
        ] , 200); 

    }


    public function loginWithSocial(Request $request){

       
        $social = $request->social;
        $social_id = $request->social_id;
        $email = $request->email;
        $type = $request->type;
        $phone = $request->phone;
        // $existingUser = User::where('email', $email)->first();

        $existingUser = User::where(function ($query) use ($email, $phone) {
            $query->where('email', $email)
                  ->orWhere('phone', $phone);
        })->first();

 
        // 'social_id' ,  $social_id  )->where('type', $type
 

        if ($existingUser) {
            // User exists, authenticate the user
           
        //    $user =  Auth::login($existingUser, true);
           $accessToken = $existingUser->createToken('AuthToken')->accessToken;
       
        //    return $accessToken;
        } else {

                    
         $username = explode("@" , $request['email']);

         $role = 3;
        //  if($type == "teacher"){
        //       $role = 3;
    
        //  }else{
        //     $role = 2;
        //  }

        $filename = 'no_avatar.png';
        $User = new User;
        $User->firstname = $request['firstname'];
        $User->lastname  = $request['lastname'];
        $User->username  = $username[0];
        $User->email     = $request['email'];
        $User->phone     = $request['phone'];
        $User->password  = Hash::make($request['password']);
        $User->avatar    = $filename;
        $User->role_id   = $role;
        $User->save();

        $existingUser  = User::create([
                'firstname' => $request['firstname'],
                'lastname' =>  $request['lastname'],
                'username' => $username[0],
                'email' =>  $request['email'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
                'avatar' => $filename,
                'role_id' => $role,

            ]);

            $role_user = new role_user;
            $role_user->user_id =   $existingUser->id;
            $role_user->role_id = $role;
            $role_user->save();

            // $user = Auth::login($newUser, true);

 
            $accessToken = $existingUser->createToken('AuthToken')->accessToken;
        }



 
        
 
        
    if($type == "provider"){
        $service =  [
            'isProvider' => true,
            'flight' => true,
            'car' => true,
            'hotel' => true
        ];
    }else{
        $service =  [
            'isProvider' => false,
            'flight' => false,
            'car' => false,
            'hotel' => false
        ];
       
    }


       
        $user = array( 'user'=>    $existingUser   ,   'token' => $accessToken , 'service_provider' => $service );
 
        return response()->json(['status' => "success" ,  'message'=> 'success' 
          , 'data'=> $user 
         
        
        ], 200);


    }

    public function register(Request $request){

 
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
        ], [
            'email.unique' => 'This Email is already taken.',
            'phone.unique' => 'This Phone is already taken.',
        ]);

        if ($validator->fails()) {
           

            return response()->json([
                'status'=> 200,
                'message'=>  $validator->errors(),
                
            ] , 422); 
    
        }



         $username = explode("@" , $request['email']);
         if($request['type'] == "parent"){
        $role = 3;
    
         }else{

            $role = 2;
         }
         
        $filename = 'no_avatar.png';
        $User = new User;
        $User->firstname = $request['firstname'];
        $User->lastname  = $request['lastname'];
        $User->username  = $request['phone'];
        $User->email     = $request['email'];
        $User->phone     = $request['phone'];
        $User->password  = Hash::make($request['password']);
        $User->avatar    = $filename;
        $User->role_id   = $role;
        $User->save();

        $role_user = new role_user;
        $role_user->user_id = $User->id;
        $role_user->role_id = $role;
        $role_user->save();
 
    
 
     
        return response()->json([
            'status'=> 200,
            'message'=> 'success',
            
        ] , 200); 


    }

    public function test(){
        return response()->json([
  
            'd' => 66,
        ]);
    }

    public function resetPassword(Request $request){

        $phone = $request->phone;
        $passowrd = $request->passowrd;
        $user = User::where('phone',  $phone )->first();
        $pass = Hash::make($request->new_password);
        User::whereId($user->id)->update([
            'password' => $pass,
        ]);


 
        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
 
    }


    public function updateUserNotiForm(Request $request)
    {
         $user  =  Auth::user();

         $noti =  new Notiform;
         $noti->user_id = $user->id;
         $noti->phone = $user->phone;

         $noti->save();

        //  Notiform::where('deleted_at', '=', null)->where('read' ,  "unread"  )->update([
        //    'read' => "read"
        //  ]);
         return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
    }



    public function changeImage(Request $request){
 
           $helpers = new helpers();
           $user =  $helpers->getInfo();
            $currentAvatar = $user->avatar;
 

            $image = $request->file('avatar');
            $path = public_path() . '/images/avatar';
            $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            // $image_resize->resize(128, 128);
            $image_resize->save(public_path('/images/avatar/' . $filename));

            $userPhoto = $path . '/' . $currentAvatar;
            if (file_exists($userPhoto)) {
                if ($user->avatar != 'no_avatar.png') {
                    @unlink($userPhoto);
                }
            }
 
            // $filename = $currentAvatar;
      

           // return $filename;
 

    User::whereId($user->id)->update([
 
        'avatar' => $filename,
      
    ]);


 

    return response()->json(['status' => "success" ,  'message'=> $filename   ], 200);



    }



    public function login(Request $request)
    {

   

   

          $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();


            $helpers = new helpers();
           
            
            // $role = $user->roles()->first();
            // return $role->name;
            $id = $user->id;
            $accessToken = $user->createToken('AuthToken')->accessToken;

            
        // if($isProvider){
        //     $service =  [
        //         'isProvider' => true,
        //         'flight' => true,
        //         'car' => true,
        //         'hotel' => true
        //     ];
        // }else{
        //     $service =  [
        //         'isProvider' => false,
        //         'flight' => false,
        //         'car' => false,
        //         'hotel' => false
        //     ];
           
        // }

            $user = array( 'user'=>   $user   ,   'token' => $accessToken   );
            // $info = User::find($user->id);
            // 'access_token' => $accessToken , 'data'=>$user
            return response()->json(['status' => "success" ,  'message'=> 'success' 
              , 'data'=> $user 
             
            
            ], 200);




        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }


    }



    public function changePassword(Request $request)
    {


   
          $credentials = [
            'phone' => $request->phone,
            'password' => $request->old_password,
        ];
        
        //   $credentials =  $cre;
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $accessToken = $user->createToken('AuthToken')->accessToken;
            $pass = Hash::make($request->new_password);


            User::whereId($user->id)->update([
     
    
                'password' => $pass,
         
            ]);

    
            return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
        } else {

            return response()->json(['error' => 'Invalid credentials'], 401);
        }


    }




    public function loginBySocail(Request $request)
    {

        $credentials = $request->only('phone', 'password');
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('AuthToken')->accessToken;
            return response()->json(['access_token' => $accessToken , 'data'=>$user], 200);

        } else {

            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }





}
