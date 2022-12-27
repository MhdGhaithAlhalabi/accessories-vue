<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        /*   return inertia::render('products/typeIndex',[
               'types' => Type::paginate(5)->through(fn($types)=>[
                   'id' => $types->id,
                   'type_name' => $types->type_name,
                   'created_at'=>$types->created_at
               ])
           ]);*/
        $types = Type::all();
        $categories = Category::with('type')->paginate(5);
        return inertia::render('products/categories/categoryIndex', compact('categories','types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {

        return inertia::render('products/categories/categoryCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'category_name' => ['required', 'string', 'max:255'],
            'type_id' => ['required'],
            'category_image' => ['image','nullable','max:1999'],
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
        if($request->hasFile('category_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('category_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('category_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('category_image')->storeAs('public/categories_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $category = Category::create([
            'category_name' => $request->category_name,
            'type_id' => $request->type_id,
            'category_image' => $fileNameToStore
        ]);

        return redirect()->back()->with('message', 'تمت اضافة الصنف');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        $types = Type::all();
        return view('category.edit_category', compact('category', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'category_name' => ['required', 'string', 'max:255'],
            'type_id' => ['required'],
            'category_image' => ['required', 'url']
        ];

        $customMessages = [
            'required' => 'هذا الحقل مطلوب',
            'url' => 'يجب ان يكون رابط'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect()->route('category.edit', $category)->withErrors($validator);
        }
        if (asset($category)) {
            $category->update($request->all());
            return redirect()->route('category.create')->with('message', 'تم تعديل الصنف');

        } else {
            return redirect()->route('category.create')->with('message', 'لا يمكنك التعديل');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()
            ->with('message', 'تم حذف الصنف');
    }
}
