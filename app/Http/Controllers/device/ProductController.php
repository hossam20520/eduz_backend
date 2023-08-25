<?php

namespace App\Http\Controllers\device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\product_warehouse;
use App\Models\Unit;
use App\Models\Warehouse;
use App\utils\helpers;
use App\Models\Cart;
use App\Models\Cartitem;
use Carbon\Carbon;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use \Gumlet\ImageResize;

use Twilio\Rest\Client as Client_Twilio;
use App\Exports\SalesExport;
use App\Mail\SaleMail;
use App\Models\Client;
use App\Models\PaymentSale;
 
 
 
use App\Models\Quotation;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Setting;
use App\Models\PosSetting; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
 
use Stripe;
use App\Models\PaymentWithCreditCard;
 

class ProductController extends Controller
{
    public function index(request $request)
    {
       
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        // Filter fields With Params to retrieve
        $columns = array(0 => 'name', 1 => 'category_id', 2 => 'brand_id', 3 => 'code');
        $param = array(0 => 'like', 1 => '=', 2 => '=', 3 => 'like');
        $data = array();
        if($request->cat == 0){
            $products = Product::with('unit', 'category', 'brand')
            ->where('deleted_at', '=', null);
        }else{
            $products = Product::with('unit', 'category', 'brand')
            ->where('deleted_at', '=', null)->where('category_id' ,$request->cat); 
        }

   

        //Multiple Filter
        $Filtred = $helpers->filter($products, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('products.name', 'LIKE', "%{$request->search}%")
                        ->orWhere('products.code', 'LIKE', "%{$request->search}%")
                        ->orWhere(function ($query) use ($request) {
                            return $query->whereHas('category', function ($q) use ($request) {
                                $q->where('name', 'LIKE', "%{$request->search}%");
                            });
                        })
                        ->orWhere(function ($query) use ($request) {
                            return $query->whereHas('brand', function ($q) use ($request) {
                                $q->where('name', 'LIKE', "%{$request->search}%");
                            });
                        });
                });
            });
        $totalRows = $Filtred->count();
        $products = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($products as $product) {
            $item['id'] = $product->id;
            $item['code'] = $product->code;
            $item['name'] = $product->name;
            $item['category'] = $product['category']->name;
            $item['brand'] = $product['brand'] ? $product['brand']->name : 'N/D';
            $item['unit'] = $product['unit']->ShortName;
            $item['price'] = $product->price;

            $product_warehouse_data = product_warehouse::where('product_id', $product->id)
                ->where('deleted_at', '=', null)
                ->get();
            $total_qty = 0;
            foreach ($product_warehouse_data as $product_warehouse) {
                $total_qty += $product_warehouse->qte;
                $item['quantity'] = $total_qty;
            }

            $firstimage = explode(',', $product->image);
            $item['image'] = $firstimage[0];

            $data[] = $item;
        }

        $warehouses = Warehouse::where('deleted_at', null)->get(['id', 'name']);
        $categories = Category::where('deleted_at', null)->get(['id', 'name']);
        $brands = Brand::where('deleted_at', null)->get(['id', 'name']);

        return response()->json([
            'warehouses' => $warehouses,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $data,
            'totalRows' => $totalRows,
        ]);
    }





    //--------------  Show Product Details ---------------\\

    public function Get_Products_Details(Request $request )
    {

         $id = $request->id;
         $helpers = new helpers();
        $Product = Product::where('deleted_at', '=', null)->findOrFail($id);
        $firstimage = explode(',', $Product->image);

        $warehouses = Warehouse::where('deleted_at', '=', null)->get();

        $item['id'] = $Product->id;
        $item['code'] = $Product->code;
        $item['Type_barcode'] = $Product->Type_barcode;
        $item['name'] = $Product->name;
        $item['category'] = $Product['category']->name;
        $item['brand'] = $Product['brand'] ? $Product['brand']->name : 'N/D';
        $item['unit'] = $Product['unit']->ShortName;
        $item['price'] = $Product->price;
        $item['cost'] = $Product->cost;
        $item['stock_alert'] = $Product->stock_alert;
        $item['taxe'] = $Product->TaxNet;
        $item['isInFav'] = $helpers->IsInWhishlist($Product->id);
        // $item['isInCart'] = $Product->TaxNet;
        $item['taxe'] = $Product->TaxNet;
        $item['image'] = $firstimage[0];
        $item['tax_method'] = $Product->tax_method == '1' ? 'Exclusive' : 'Inclusive';

        if ($Product->is_variant) {
            $item['is_variant'] = 'yes';
            $productsVariants = ProductVariant::where('product_id', $id)
                ->where('deleted_at', null)
                ->get();
            foreach ($productsVariants as $variant) {
                $item['ProductVariant'][] = $variant->name;

                foreach ($warehouses as $warehouse) {
                    $product_warehouse = DB::table('product_warehouse')
                        ->where('product_id', $id)
                        ->where('deleted_at', '=', null)
                        ->where('warehouse_id', $warehouse->id)
                        ->where('product_variant_id', $variant->id)
                        ->select(DB::raw('SUM(product_warehouse.qte) AS sum'))
                        ->first();

                    $war_var['mag'] = $warehouse->name;
                    $war_var['variant'] = $variant->name;
                    $war_var['qte'] = $product_warehouse->sum;
                    $item['CountQTY_variants'][] = $war_var;
                }

            }
        } else {
            $item['is_variant'] = 'no';
            $item['CountQTY_variants'] = [];
        }

        foreach ($warehouses as $warehouse) {
            $product_warehouse_data = DB::table('product_warehouse')
                ->where('deleted_at', '=', null)
                ->where('product_id', $id)
                ->where('warehouse_id', $warehouse->id)
                ->select(DB::raw('SUM(product_warehouse.qte) AS sum'))
                ->first();

            $war['mag'] = $warehouse->name;
            $war['qte'] = $product_warehouse_data->sum;
            $item['CountQTY'][] = $war;
        }

        if ($Product->image != '') {
            foreach (explode(',', $Product->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }



   public function  AddToCart(Request $request){

    $helpers = new helpers();

    $user = $helpers->getInfo();

    $product_id = $request['product_id']; 
    $qty = $request['qty']; 
    $Product = Product::where('deleted_at', '=', null)->findOrFail($product_id);
      
    $cart = Cart::where('deleted_at', '=', null)->where('user_id' , $user->id )->where('order_id' , '=', null)->first();
    $productPrice = $Product->price;
    $subtotal = floatval(  $productPrice )   *   floatval($qty);
    if($cart){
 
      // check if product in cartitem first 

    $procutItem = Cartitem::where('deleted_at', '=', null)->where('cart_id' ,  $cart->id )->where('product_id' ,  $Product->id )->first();
   if( $procutItem ){
 
    $newPriceItem =  floatval(  $procutItem->subtotal  ) +  floatval(  $subtotal  );
    Cartitem::whereId($procutItem->id)->update([
        'qty' =>    floatval( $procutItem->qty ) +  $qty     ,  
        'subtotal' =>   $newPriceItem

    ]);


        // update cart total
        $newPrice =    floatval(  $subtotal  );
        $TotcalMoney =  floatval(  $cart->total)  + floatval( $newPrice );    
        Cart::whereId($cart->id)->update([
            'total' =>   $TotcalMoney   
 
        ]);

        return response()->json(['status' => "success" ,  'message'=> 'increased product qty'   ], 200);

   }else{


    $item =  new Cartitem;
    $item->product_id = $Product->id;
    $item->cart_id = $cart->id;
    $item->qty =  $qty;
    $item->price =$Product->price;
    $item->subtotal =  $subtotal;
    $item->save();

   }




        
        // update cart total
       $TotcalMoney =  floatval(  $cart->total)  + floatval(  $subtotal );    
        Cart::whereId($cart->id)->update([
            'total' =>   $TotcalMoney   
 
        ]);
       


        return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);

    }else{




    $productPrice = $Product->price;
    $total = floatval(  $productPrice )   *   floatval($qty);
    $cart = new Cart;
    $cart->user_id = $user->id;
    $cart->total  =   $total;
    $cart->save(); 

    

    
    $item =  new Cartitem;
    $item->product_id = $Product->id;
    $item->cart_id = $cart->id;
    $item->qty =  $qty;
    $item->price =$Product->price;
    $item->subtotal =  $subtotal ;
    $item->save();

    return response()->json(['status' => "success" ,  'message'=> 'success'   ], 200);
    }
 
   
    // $cart = new Cart;
    // $cart->product_id = $product_id;
    // $cart->qty  = $qty;
    // $cart->total  =  $total;
    // $cart->user_id  = $user->id;
    // $cart->save();


 

    }






    public function  GetMyCart(Request $request){

         $helpers = new helpers();
    
         $user = $helpers->getInfo();
         $cart = Cart::with('CartItems.product')->where('deleted_at', '=', null)->where('order_id' , '=', null)->where('user_id', $user->id)->first();
 
 
    
         return response()->json(['cart' => $cart  ], 200);
    
        }


        public function getNumberOrder()
        {
    
            $last = DB::table('sales')->latest('id')->first();
    
            if ($last) {
                $item = $last->Ref;
                $nwMsg = explode("_", $item);
                $inMsg = $nwMsg[1] + 1;
                $code = $nwMsg[0] . '_' . $inMsg;
            } else {
                $code = 'SL_1111';
            }
            return $code;
        }



   public function storeSale(Request $request){

 
    //    create client 



 
        // request()->validate([
        //     'client_id' => 'required',
        //     'warehouse_id' => 'required',
        // ]);

       
            $helpers = new helpers();
            $user = $helpers->getInfo();
            $cart = Cart::with('CartItems.product')->where('deleted_at', '=', null)->where('user_id', $user->id)->where('order_id' , '=', null)->first();
 
           



            $order = new Sale;

            $order->is_pos = 0;
            $order->date =  "2023-06-21";
            $order->Ref = $this->getNumberOrder();
            $order->client_id = $user->id;
            $order->GrandTotal =  $cart->total;
            $order->warehouse_id = 1;
            $order->tax_rate = 0;
            $order->TaxNet = 0;
            $order->discount = 0;
            $order->shipping = 0;
            $order->statut =  "ordered";
            $order->payment_statut = 'unpaid';
            $order->notes =  "";
            $order->user_id = $user->id;

            $order->save();
           
            Client::create([
                'name' => $user->firstname ." ". $user->lastname,
                'code' =>   $order->id,
                'adresse' => $request['address'],
                'phone' => $request['phone'],
                'email' =>  $user->email,
                'country' => $request['country'],
                'city' =>  $request['country'] ,
                 ]);
      
            // $data = $request['details'];
             $data =  $cart;

             Cart::whereId($cart->id)->update([
                'order_id' =>    $order->id  
     
                ]);
           

            foreach ( $cart->CartItems  as   $value) {
                $subtotalPrice = floatval( $value->qty )   *   floatval( $value->price);
                $unit = Unit::where('id', 1)
                    ->first();
                $orderDetails[] = [
                    'date' =>  "2023-06-21",
                    'sale_id' => $order->id,
                    'sale_unit_id' => 1,
                    'quantity' => $value->qty,
                    'price' =>  $value->price,
                    'TaxNet' =>0,
                    'tax_method' =>  "Exclusive",
                    'discount' => 0,
                    'discount_method' => 'Fixed',
                    'product_id' => $value->product_id,
                   
                    'total' => $subtotalPrice,
                ];


                if ($order->statut == "completed") {
                    if ($value['product_variant_id'] !== null) {
                        $product_warehouse = product_warehouse::where('deleted_at', '=', null)
                            ->where('warehouse_id', $order->warehouse_id)
                            ->where('product_id', $value['product_id'])
                            ->where('product_variant_id', $value['product_variant_id'])
                            ->first();

                        if ($unit && $product_warehouse) {
                            if ($unit->operator == '/') {
                                $product_warehouse->qte -= $value['quantity'] / $unit->operator_value;
                            } else {
                                $product_warehouse->qte -= $value['quantity'] * $unit->operator_value;
                            }
                            $product_warehouse->save();
                        }

                    } else {
                        $product_warehouse = product_warehouse::where('deleted_at', '=', null)
                            ->where('warehouse_id', $order->warehouse_id)
                            ->where('product_id', $value['product_id'])
                            ->first();

                        if ($unit && $product_warehouse) {
                            if ($unit->operator == '/') {
                                $product_warehouse->qte -= $value['quantity'] / $unit->operator_value;
                            } else {
                                $product_warehouse->qte -= $value['quantity'] * $unit->operator_value;
                            }
                            $product_warehouse->save();
                        }
                    }
                }
            }
            SaleDetail::insert($orderDetails);

            $role = Auth::user()->roles()->first();
            // $view_records = Role::findOrFail($role->id)->inRole('record_view');
            // $statusPament = $request->payment['status'];
            $statusPament = "pending";
            if ($statusPament  != 'pending') {
                $sale = Sale::findOrFail($order->id);
                // Check If User Has Permission view All Records
                if (!$view_records) {
                    // Check If User->id === sale->id
                    $this->authorizeForUser($request->user('api'), 'check_record', $sale);
                }


                try {

                    $total_paid = $sale->paid_amount + $request['amount'];
                    $due = $sale->GrandTotal - $total_paid;
                    if ($due === 0.0 || $due < 0.0) {
                        $payment_statut = 'paid';
                    } else if ($due != $sale->GrandTotal) {
                        $payment_statut = 'partial';
                    } else if ($due == $sale->GrandTotal) {
                        $payment_statut = 'unpaid';
                    }
                    
                    if($request['amount'] > 0){
                        if($request->payment['Reglement'] == 'credit card'){
                            $Client = Client::whereId($request->client_id)->first();
                            Stripe\Stripe::setApiKey(config('app.STRIPE_SECRET'));

                            $PaymentWithCreditCard = PaymentWithCreditCard::where('customer_id' ,$request->client_id)->first();
                            if(!$PaymentWithCreditCard){
                                // Create a Customer
                                $customer = \Stripe\Customer::create([
                                    'source' => $request->token,
                                    'email' => $Client->email, 
                                ]);

                                // Charge the Customer instead of the card:
                                $charge = \Stripe\Charge::create([
                                    'amount' => $request['amount'] * 100,
                                    'currency' => 'usd',
                                    'customer' => $customer->id,
                                ]);
                                $PaymentCard['customer_stripe_id'] =  $customer->id;

                            }else{
                                $customer_id = $PaymentWithCreditCard->customer_stripe_id;
                                $charge = \Stripe\Charge::create([
                                    'amount' => $request['amount'] * 100,
                                    'currency' => 'usd',
                                    'customer' => $customer_id,
                                ]);
                                $PaymentCard['customer_stripe_id'] =  $customer_id;
                            }

                            $PaymentSale = new PaymentSale();
                            $PaymentSale->sale_id = $order->id;
                            $PaymentSale->Ref = app('App\Http\Controllers\PaymentSalesController')->getNumberOrder();
                            $PaymentSale->date = Carbon::now();
                            $PaymentSale->Reglement = $request->payment['Reglement'];
                            $PaymentSale->montant = $request['amount'];
                            $PaymentSale->change = $request['change'];
                            $PaymentSale->user_id = Auth::user()->id;
                            $PaymentSale->save();
        
                            $sale->update([
                                'paid_amount' => $total_paid,
                                'payment_statut' => $payment_statut,
                            ]);

                            $PaymentCard['customer_id'] = $request->client_id;
                            $PaymentCard['payment_id'] = $PaymentSale->id;
                            $PaymentCard['charge_id'] = $charge->id;
                            PaymentWithCreditCard::create($PaymentCard);

                        // Paying Method Cash
                        }else{

                            PaymentSale::create([
                                'sale_id' => $order->id,
                                'Ref' => app('App\Http\Controllers\PaymentSalesController')->getNumberOrder(),
                                'date' => Carbon::now(),
                                'Reglement' => $request->payment['Reglement'],
                                'montant' => $request['amount'],
                                'change' => $request['change'],
                                'user_id' => Auth::user()->id,
                            ]);

                            $sale->update([
                                'paid_amount' => $total_paid,
                                'payment_statut' => $payment_statut,
                            ]);
                        }
                    }
                } catch (Exception $e) {
                    return response()->json(['message' => $e->getMessage()], 500);
                }
                
            }

       
            return response()->json(['status' => "success" ,  'message'=> 'Order Placed'   ], 200);
       
    }

   }








 
