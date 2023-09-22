<?php
namespace App\utils;

use App\Models\Currency;
use App\Models\Role;
use App\Models\Setting;

use App\Models\Cart;
use App\Models\Cartitem;
use App\Models\Favourit;
use App\Models\Instfav;
use Illuminate\Support\Facades\Auth;
use \Gumlet\ImageResize;
use Intervention\Image\ImageManagerStatic as Image;
class helpers
{



    public function IsInWhishlistInst($inst_id , $type  ){
        $user  =  Auth::user();
        if(!$user){
            return false;
        }
        $products = Instfav::where('deleted_at', '=', null)->where('inst_id' , $inst_id )->where('type' , $type)->where('user_id' , $user->id)->first();

        if($products){
            return true;

        }else{
            return false;
        }
  

    }




    public function IsInWhishlist($product_id  ){
        $user  =  Auth::user();
        $products = Favourit::where('deleted_at', '=', null)->where('product_id' , $product_id )->where('user_id' , $user->id )->first();

        if($products){
            return true;

        }else{
            return false;
        }
  

    }




    public function IsInCart($product_id , $user_id){
        $cart = Cart::where('deleted_at', '=', null)->where('user_id' ,  $user_id)->where('order_id' ,  '='  , null )->first();
 

        $cartItem =  Cartitem::where('deleted_at', '=', null)->where('product_id' , $product_id )->where('cart_id' ,  $cart->id )->first();


  


        if( $cartItem){

            return true;

        }else{
            return false;
        }
      
 


    }



    public function store($field , $request){

        $field->en_info = $request['en_info'];
        $field->ar_info = $request['ar_info'];
        $field->facilities_ar = $request['facilities_ar'];
        $field->facilities_en = $request['facilities_en'];
        $field->activities_ar = $request['activities_ar'];
        $field->activities_en = $request['activities_en'];
        $field->url = $request['url'];
        $field->phone = $request['phone'];
        $field->share = $request['share'];
        $field->en_name = $request['en_name'];
        $field->ar_name = $request['ar_name'];
        $field->lat = $request['lat'];
        $field->long_a = $request['long'];
        $field->area_id = $request['area_id'];
        $field->activites_fiels = $request['activites_fiels'];
        
        $field->actives = $request['actives'];
        // $field->second_lang = $request['second_lang'];
        // $field->first_lang = $request['first_lang'];
        // $field->other_lang = $request['other_lang'];
        // $field->years_accepted = $request['years_accepted'];
        // $field->weekend = $request['weekend'];
        // $field->expense_from = $request['expFrom'];
        // $field->expense_to = $request['expTo'];
        // $field->children_numbers = $request['children_numbers'];
        // $field->is_accept = $request['is_accept'];


        $field->exp_from = $request['exp_from'];
        $field->exp_to = $request['exp_to'];
        $field->paid_en_info = $request['paid_en_info'];
        $field->paid_ar_info = $request['paid_ar_info'];
        $field->paid_facilities_en = $request['paid_facilities_en'];
        $field->paid_facilities_ar = $request['paid_facilities_ar'];
        $field->free = $request['free'];
        $field->ar_address = $request['ar_address'];
        $field->en_address = $request['en_address'];
        $field->selected_ids = $request['selected_ids'];

        // $School->activities_image = $request['activities_image'];
        $field->institution_id = $request['institution_id'];
        // $School->review_id = $request['review_id'];
   return $field;

       


    }



    public function editImageV($model , $imagename, $singleImage){
        $firstimage = explode(',', $model);
        $item[$singleImage] = $firstimage[0];
        $item[$imagename] = [];
        if ($model != '' && $model != 'no-image.png') {
            foreach (explode(',',$model) as $img) {
                $path = public_path() . '/images/educations/' . $img;
                if (file_exists($path)) {
                    $itemImg['name'] = $img;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $item[$imagename][] = $itemImg;
                }
            }
        } else {
            $item[$imagename] = [];
        }

       return  $item;

    }


    public function StoreImagesV($request , $imagename){
        if ($request[$imagename]) {
            $files = $request[$imagename];
            foreach ($files as $file) {
                $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                // $fileData->resize(200, 200);
                $name = rand(11111111, 99999999) . $file['name'];
                $path = public_path() . '/images/educations/';
                $success = file_put_contents($path . $name, $fileData);

                $images[] = $name;
            }
            $filename = implode(",", $images);
        } else {
            $filename = 'no-image.png';
        }

        return $filename;
    }


    public function edit($model){



        $item['id'] = $model->id;
        $item['en_info'] = $model->en_info;
        $item['ar_info'] = $model->ar_info;

        $item['facilities_ar'] = $model->facilities_ar;
        $item['facilities_en'] = $model->facilities_en;


        $item['activities_ar'] = $model->activities_ar;
        $item['activities_en'] = $model->activities_en;
        $item['area_id'] = $model->area_id;
        $item['url'] = $model->url;
        $item['phone'] = $model->phone;


        $item['share'] = $model->share;
        $item['institution_id'] = $model->institution_id;


        $item['en_name'] =  $model->en_name;
        $item['ar_name'] =  $model->ar_name;


        $item['lat'] =  $model->lat;
        $item['long'] =  $model->long_a;
        $item['actives'] =  $model->actives;
      

        // $item['second_lang'] =  $model->second_lang;
        // $item['first_lang'] =  $model->first_lang;
        // $item['other_lang'] =  $model->other_lang;
        // $item['years_accepted'] =  $model->years_accepted;
        // $item['weekend'] =  $model->weekend;
        // $item['expFrom'] =  $model->expense_from;
        // $item['expTo'] =  $model->expense_to;
        // $item['children_numbers'] =  $model->children_numbers;
        // $item['is_accept'] =  $model->is_accept;
        $item['selected_ids'] =  $model->selected_ids;
        // $item['logo'] =  $model->logo;
        // $item['banner'] =  $model->banner;
        $item['exp_from'] =  $model->exp_from;
        $item['exp_to'] =  $model->exp_to;
        $item['paid_en_info'] =  $model->paid_en_info;
        $item['paid_ar_info'] =  $model->paid_ar_info;
        $item['paid_facilities_en'] =  $model->paid_facilities_en;
        $item['paid_facilities_ar'] =  $model->paid_facilities_ar;
        $item['free'] =  $model->free;
        $item['ar_address'] =  $model->ar_address;
        $item['en_address'] =  $model->en_address;
        $item['activites_fiels'] =  $model->activites_fiels;
        
    
        return $item;

    }


    public function getInfo(){
        return  $this->GetUserInfo()['user'];
     }
 
    //  public function IsCustomer(){
    //      //    change the 1 to 3 for customer 
    //        if($this->GetUserInfo()['role']   == 1){
    //           return  true;
    //        }else{
    //           return false;
    //        }
    //  }
 
 
    //  public function IsVendor(){
    //      //    change the 1 to 3 for customer 
    //        if($this->GetUserInfo()['role']   == 2){
    //           return  true;
    //        }else{
    //           return false;
    //        }
    //  }
 
 
     public function GetRole(){
         return  $this->GetUserInfo()['role'];
      }
 
     public function GetUserInfo(){
         $user =  Auth::User();
      
         $role = Auth::user()->roles()->first();
        //  $role->pivot->role_id,
             return [
                 "role"=> 3,
                 "user"=> $user,
      
             ];
     
       
       
      
 
     }


    //  Helper Multiple Filter
    public function filter($model, $columns, $param, $request)
    {
        // Loop through the fields checking if they've been input, if they have add
        //  them to the query.
        $fields = [];
        for ($key = 0; $key < count($columns); $key++) {
            $fields[$key]['param'] = $param[$key];
            $fields[$key]['value'] = $columns[$key];
        }

        foreach ($fields as $field) {
            $model->where(function ($query) use ($request, $field, $model) {
                return $model->when($request->filled($field['value']),
                    function ($query) use ($request, $model, $field) {
                        $field['param'] = 'like' ?
                        $model->where($field['value'], 'like', "{$request[$field['value']]}")
                        : $model->where($field['value'], $request[$field['value']]);
                    });
            });
        }

        // Finally return the model
        return $model;
    }

    //  Check If Hass Permission Show All records
    public function Show_Records($model)
    {
        $Role = Auth::user()->roles()->first();
        $ShowRecord = Role::findOrFail($Role->id)->inRole('record_view');

        if (!$ShowRecord) {
            return $model->where('user_id', '=', Auth::user()->id);
        }
        return $model;
    }

    // Get Currency
    public function Get_Currency()
    {
        $settings = Setting::with('Currency')->where('deleted_at', '=', null)->first();

        if ($settings && $settings->currency_id) {
            if (Currency::where('id', $settings->currency_id)
                ->where('deleted_at', '=', null)
                ->first()) {
                $symbol = $settings['Currency']->symbol;
            } else {
                $symbol = '';
            }
        } else {
            $symbol = '';
        }
        return $symbol;
    }

    // Get Currency COde
    public function Get_Currency_Code()
    {
        $settings = Setting::with('Currency')->where('deleted_at', '=', null)->first();

        if ($settings && $settings->currency_id) {
            if (Currency::where('id', $settings->currency_id)
                ->where('deleted_at', '=', null)
                ->first()) {
                $code = $settings['Currency']->code;
            } else {
                $code = 'usd';
            }
        } else {
            $code = 'usd';
        }
        return $code;
    }

}
