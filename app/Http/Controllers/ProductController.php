<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Feedback;
use App\Models\Image;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(): \Inertia\Response
    {

        $types = Type::all();
        $products = Product::with('type', 'category', 'color','color.image')->get();
        return inertia::render('products/productIndex', compact( 'types', 'products'));
    }

    /*    public function dashboardIndex()
        {
            $carts = Cart::where('status', '=', 'waiting')->get();
            $carts2 = Cart::where('status', '=', 'done')->get();
            return view('cart.cart')->with('carts', $carts)->with('carts2', $carts2);
        }

        public function getMessage()
        {
            $feedback = Feedback::where('status', '=', '0')->get();
            $message = $feedback->count();
            return $message;
        }

        public function getCart()
        {

            $carts = Cart::where('status', '=', 'waiting')->get();
            $cart = $carts->count();
            return $cart;

        }*/


    /*   public function index2()
       {
           $products = Product::with('type','category')->get();
           return view('product.show_product2')->with('products',$products);

       }*/


    public function create(): \Inertia\Response
    {
        $types = Type::all();
        return inertia::render('products/productCreate', compact('types'));
        //  return view('product.create_product',compact('types','categories'));
    }

    public function findTypeByName($type)
    {
        $categories = Category::select('category_name', 'id')->where('type_id', $type)->take(100)->get();
        return response()->json($categories);
    }
    public function findColorImages($color)
    {
        $image = Image::where('color_id', $color)->get();
        return response()->json($image);
    }



    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'details' => ['required'],
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'category_id' => ['required'],
            'type_id' => ['required'],
            'has_name' => ['required'],
            'has_measure' => ['required'],
        ];

        $customMessages = [
            'required' => 'هذا الحقل مطلوب',
            'unique' => 'الاسم موجود سابقاَ'
        ];
        // 'rate' => 5,
        $validator = Validator::make(
            $request->all(),
            $rules,
            $customMessages,
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $product = Product::create([
            'type_id' => $request->type_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'priceSale' => $request->priceSale,
            'status' => $request->status,
            'has_name' => $request->has_name,
            'has_measure' => $request->has_measure,
            'rate' => 5,
        ]);

        //$colors = Color::where('product_id',$product->id)->paginate(5);
        //return inertia::render('products/productColors' ,compact('product','colors'));
        return redirect('products/colors/' . $product->id);

    }


    public function edit(Product $product)
    {
        $types = Type::all();
        $categories = Category::all();
        return view('product.edit_product', compact('product', 'categories', 'types'));
    }


    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product->id],
            'details' => ['required'],
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'category_id' => ['required'],
            'type_id' => ['required'],
            'has_name' => ['required'],
            'has_measure' => ['required'],

        ];

        $customMessages = [
            'required' => 'هذا الحقل مطلوب',
            'unique' => 'الاسم موجود سابقاَ'

        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            return redirect()->route('product.edit', $product)->withErrors($validator);
        }
        if (asset($product)) {
            $product->update($request->all());
            return redirect()->route('product.edit', $product)->with('message', 'success');

        } else {
            return redirect()->route('product.edit', $product)->with('message', 'you cant do that');
        }

    }

    public function createColor(Product $product): \Inertia\Response
    {
        $colors = Color::where('product_id', $product->id)->paginate(5);
        return inertia::render('products/colors/productColors', compact('product', 'colors'));
    }
    public function createImage(Color $color): \Inertia\Response
    {
        $images = Image::where('color_id', $color->id)->paginate(5);
        return inertia::render('products/images/colorImages', compact('color', 'images'));
    }
    public function colorStore(Request $request)
    {
        $rules = [
            'color' => ['required', 'string', 'max:255'],
            'product_id' => 'required',
            'color_hex' => 'required'
        ];

        $customMessages = [
            'required' => 'هذا الحقل مطلوب',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $color = Color::create([
            'color' => $request->color,
            'product_id' => $request->product_id,
            'color_hex' => $request->color_hex
        ]);

        return redirect('products/images/' . $color->id);

    }

    public function imageStore(Request $request): \Illuminate\Http\RedirectResponse
    {
        $rules = [
            'color_id' => ['required'],
            'url' => ['required','image','nullable','max:1999'],
        ];
        $customMessages = [
            'required' => 'هذا الحقل مطلوب',
            'unique' => 'هذا الاسم موجود سابقاً',
            'url' => 'يجب ان يكون رابط',
            'image'=> 'يجب ان تكون صورة',
            'max:1999'=>'يجب ان يكون حجم الصورة اقل من 2 ميغا بايت'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        // Handle File Upload
        if($request->hasFile('url')){
            // Get filename with the extension
            $filenameWithExt = $request->file('url')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('url')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('url')->storeAs('public/color_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $color = Image::create([
            'color_id' => $request->color_id,
            'url' => $fileNameToStore,
        ]);

        return redirect()->back()->with('message', 'تمت اضافة الصورة');

    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()
            ->with('message', 'تم حذف المنتج');
    }
}
