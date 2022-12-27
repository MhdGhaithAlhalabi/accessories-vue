<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Type;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//use Carbon\Carbon;
class CustomerController extends Controller
{

    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('auth:customer-api');
    }

    public function searchByName($name)
    {

        $menu_product_id = Menu::all()->pluck('product_id')->values();
        $product = Product::with('type:id,type_name', 'category:id,category_name,type_id,category_image', 'color:id,color,product_id,color_hex', 'color.image:id,url,color_id')
            ->where('name', 'like', "%{$name}%")
            ->whereIn('id', $menu_product_id)->get();
        return $this->returnData('product', $product);
    }

    public function rateStore(Request $request)
    {
        try {

            DB::transaction(function () use ($request) {
                $rates = $request->rateList;
                $customerId = auth()->user()->id;
                $rate = json_decode($rates, true);
                $collection = collect($rate);
                $validator = Validator::make([
                        'rateList' => $rates,
                        'customer_id' => $customerId,
                    ]
                    ,
                    [
                        'rateList' => ['required'],
                        'customer_id' => ['required'],
                    ]);

                if ($validator->fails()) {

                    return $this->returnValidationError($validator->getMessageBag());
                }
                for ($i = 0; $i < $collection->count(); $i++) {
                    $validator = Validator::make([
                            'product_id' => $collection[$i]['id'],
                            'rate' => $collection[$i]['rate'],
                        ]
                        ,
                        [
                            'product_id' => ['required'],
                            'rate' => ['required'],
                        ]);

                    if ($validator->fails()) {

                        return $this->returnValidationError($validator->getMessageBag());
                    }
                }
                for ($i = 0; $i < $collection->count(); $i++) {
                    $p = $collection[$i]['id'];
                    $r = $collection[$i]['rate'];
                    $r1 = Rate::where('customer_id', '=', $customerId)
                        ->where('product_id', '=', $p)
                        ->first();
                    if ($r1 == NULL) {
                        Rate::create(
                            [
                                'product_id' => $p,
                                'customer_id' => $customerId,
                                'rate' => $r,
                            ]
                        );
                    } else {
                        $this_rate = Rate::find($r1->id);
                        $this_rate->rate = $r;
                        $this_rate->save();
                    }
                    $the_rate = Rate::all()->where('product_id', '=', $p)
                        ->average('rate');
                    $product = Product::find($p);

                    $rate = $the_rate;
                    $product->rate = $rate;
                    $product->save();

                }

            });
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }

        return $this->returnSuccessMessage('rate stored');
    }

    public function orderCustomerView()
    {
        $carts = Cart::with('order:cart_id,qty,product_id,color,has_name,has_measure',
            'order.product',
            'order.product.type:id,type_name',
            'order.product.category:id,type_id,category_name,category_image',
            'order.product.color:id,color,product_id,color_hex',
            'order.product.color.image:id,url,color_id')
            ->where('customer_id', '=', auth()->user()->id)
            ->latest()->get();
        return $this->returnData('carts', $carts);
    }

    public function orderStore(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $orderList = $request->orderList;
                $order = json_decode($orderList, true);
                $collection = collect($order);
                $c_price = 0;
                //  $temp = 0;
                $validator = Validator::make([
                        'orderList' => $orderList,
                    ]
                    ,
                    [
                        'orderList' => ['required'],

                    ]);

                if ($validator->fails()) {

                    return $this->returnValidationError($validator->getMessageBag());
                }
                for ($i = 0; $i < $collection->count(); $i++) {
                    $validator = Validator::make([
                            'product_id' => $collection[$i]['id'],
                            'qty' => $collection[$i]['qty'],
                        ]
                        ,
                        [
                            'product_id' => ['required'],
                            'qty' => ['required'],

                        ]);

                    if ($validator->fails()) {

                        return $this->returnValidationError($validator->getMessageBag());
                    }
                }
                for ($i = 0; $i < $collection->count(); $i++) {
                    $product_id = $collection[$i]['id'];
                    $price = Product::find($product_id)->price;
                    $priceSale = Product::find($product_id)->priceSale;
                    $qty = $collection[$i]['qty'];
                    if ($priceSale == NULL) {
                        $c_price = $c_price + $price * $qty;
                    } else {
                        $c_price = $c_price + $priceSale * $qty;
                    }

                }
                $customer_id = auth()->user()->id;
                $amount = $c_price;
                $address = $request->address;
                $validator = Validator::make([
                        'customer_id' => $customer_id,
                        'amount' => $amount,
                        'address' => $address,
                    ]
                    ,
                    [
                        'customer_id' => ['required'],
                        'amount' => ['required'],
                        'address' => ['required'],
                    ]);

                if ($validator->fails()) {

                    return $this->returnValidationError($validator->getMessageBag());
                }
                Cart::create([
                    'customer_id' => $customer_id,
                    'amount' => $amount,
                    'address' => $address,
                    'status' => 'waiting',
                ]);
                //  $myTime = Carbon::now();
                //  $date = $myTime->toDateTimeString();
                //  $tt = 'new order';
                //   $text = $tt . $date;
                // event(new orderStore($text));
                $cart_id = DB::table('carts')
                    ->select('id')
                    ->where('customer_id', '=', $customer_id)
                    ->orderBy('id', 'desc')
                    ->first()->id;
                for ($i = 0; $i < $collection->count(); $i++) {
                    $validator = Validator::make([
                            'id' => $collection[$i]['id'],
                            'qty' => $collection[$i]['qty'],
                            'color' => $collection[$i]['color'],

                        ]
                        ,
                        [
                            'id' => ['required'],
                            'qty' => ['required'],
                            'color' => ['required'],
                        ]);

                    if ($validator->fails()) {

                        return $this->returnValidationError($validator->getMessageBag());
                    }
                }
                for ($i = 0; $i < $collection->count(); $i++) {
                    $p = $collection[$i]['id'];
                    $q = $collection[$i]['qty'];
                    $c = $collection[$i]['color'];
                    $h = $collection[$i]['has_name'];
                    $m = $collection[$i]['has_measure'];

                    Order::create(
                        [
                            'product_id' => $p,
                            'cart_id' => $cart_id,
                            'qty' => $q,
                            'color' => $c,
                            'has_name' => $h,
                            'has_measure' => $m
                        ]
                    );
                }

            });
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
        return $this->returnSuccessMessage('cart submitted');

    }

    public function feedbackStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required'],

        ]);

        if ($validator->fails()) {

            return $this->returnValidationError($validator->getMessageBag());
        }

        Feedback::create([
            'message' => $request->message,
            'customer_id' => auth()->user()->id,
            'status' => 0
        ]);

        return $this->returnSuccessMessage('feedback stored successfully');

    }

    /*
        public function home()
        {
            $menu_product_id = Menu::all()->pluck('product_id')->values();


            $menu = Type::with(['category:id,category_name,type_id,category_image', 'category.product' => function ($q) use ($menu_product_id) {
                $q->whereIn('id', $menu_product_id);
            }, 'category.product.color:id,color,color_hex,product_id', 'category.product.color.image:id,url,color_id'])
                ->select('id','type_name')
                ->get();

            $offer = Product::with('type:id,type_name','category:id,category_name,type_id,category_image','color:id,color,color_hex,product_id', 'color.image:id,url,color_id')            ->where('status', '=', '1')
                ->whereIn('id', $menu_product_id)
                ->get();
            $recently = Product::with('type:id,type_name','category:id,category_name,type_id,category_image','color:id,color,color_hex,product_id', 'color.image:id,url,color_id')
                ->whereMonth('created_at', date('m'))
                ->whereIn('id', $menu_product_id)
                ->get();


            $cart = Cart::Join('orders', 'orders.cart_id', '=', 'carts.id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('types', 'types.id', '=', 'products.type_id')
                ->select('types.id')
                ->where('carts.customer_id', '=', auth()->user()->id)
                ->get();
            $Collection1 = collect($cart)->countBy('id')->sortDesc();
            $Collection2 = $Collection1->keys()->first();
            $c = $Collection2;
            $recommend =Product::with('type:id,type_name','category:id,category_name,type_id,category_image','color:id,color,color_hex,product_id', 'color.image:id,url,color_id')
                ->where('type_id', '=', $c)
                ->whereIn('id', $menu_product_id)
                ->inRandomOrder()->limit(5)->get();

            return $this->returnData('home', ['menu' => $menu, 'offer' => $offer, 'recently_month' => $recently, 'recommend' => $recommend]);
        }
        */
    public function typeView()
    {
        $types = Type::select('id', 'type_name')
            ->get();
        return $this->returnData('types', $types);
    }
    public function home($type_id)
    {
        $category = Category::select('id', 'category_name', 'type_id', 'category_image')
            ->where('type_id', '=', $type_id)
            ->get();

        $menu_product_id = Menu::all()->pluck('product_id')->values();
        $offer = Product::with('type:id,type_name', 'category:id,category_name,type_id,category_image', 'color:id,color,product_id,color_hex', 'color.image:id,url,color_id')
            ->where('status', '=', '1')
            ->where('type_id', '=', $type_id)
            ->whereIn('id', $menu_product_id)->get();

        $recently = Product::with('type:id,type_name','category:id,category_name,type_id,category_image','color:id,color,color_hex,product_id', 'color.image:id,url,color_id')
            ->whereMonth('created_at', date('m'))
            ->where('type_id', '=', $type_id)
            ->whereIn('id', $menu_product_id)
            ->get();


        $cart = Cart::Join('orders', 'orders.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('types', 'types.id', '=', 'products.type_id')
            ->select('types.id')
            ->where('carts.customer_id', '=', auth()->user()->id)
            ->get();
        $Collection1 = collect($cart)->countBy('id')->sortDesc();
        $Collection2 = $Collection1->keys()->first();
        $c = $Collection2;
        $recommend =Product::with('type:id,type_name','category:id,category_name,type_id,category_image','color:id,color,color_hex,product_id', 'color.image:id,url,color_id')
            ->where('type_id', '=', $c)
            ->whereIn('id', $menu_product_id)
            ->inRandomOrder()->limit(5)->get();

        return $this->returnData('home', ['category' => $category, 'offer' => $offer, 'recently_month' => $recently, 'recommend' => $recommend]);


    }



   /* public function categoryView($id)
    {
        $category = Category::select('id', 'category_name', 'type_id', 'category_image')
        ->where('type_id', '=', $id)
        ->get();
        return $this->returnData('category', $category);
    }*/

    public function productView($category_id)
    {
        $menu_product_id = Menu::all()->pluck('product_id')->values();
        $product = Product::
            where('category_id', '=', $category_id)
            ->whereIn('id', $menu_product_id)
        ->get();
        return $this->returnData('product', $product);
    }

    /*public function offerView($type_id)
    {
        $menu_product_id = Menu::all()->pluck('product_id')->values();
        $product = Product::with('type:id,type_name', 'category:id,category_name,type_id,category_image', 'color:id,color,product_id,color_hex', 'color.image:id,url,color_id')
            ->where('status', '=', '1')
            ->where('type_id', '=', $type_id)
            ->whereIn('id', $menu_product_id)->get();
        return $this->returnData('product', $product);
    }*/
}
