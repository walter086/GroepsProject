<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product; 
use App\Category; 
class ProductsController extends Controller
{

    public function __construct()
    {
        // add exceptions to auth
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::All();
        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->prepend('Choose a category', '');;
        // dd($categories);
        return view('products.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image_name' => 'image|nullable|max:1999'
        ]);

        // handle file upload

        if($request->hasFile('image_name')) {
            // get file with extension
            $fileNameWithExt = $request->file('image_name')->getClientOriginalName();
            // get just the file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just the extension
            $extension = $request->file('image_name')->getClientOriginalExtension();
            // fileName to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // upload the image
            $path = $request->file('image_name')->storeAs('public/product_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.png';
        }


        if(!isset($request->category)) {
            $category = 1;
        }


        // create the product

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image_name = $fileNameToStore;
        $product->stock = $request->stock;
        $product->category_id = $request->category;
        $product->save();
        return redirect('product')->with('success', 'Product created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::pluck('name', 'id');

        $data = [
            'product' => $product,
            'categories' => $categories
        ];
        return view('products.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image_name' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('image_name')) {
            // get file with extension
            $fileNameWithExt = $request->file('image_name')->getClientOriginalName();
            // get just the file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just the extension
            $extension = $request->file('image_name')->getClientOriginalExtension();
            // fileName to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // upload the image
            $path = $request->file('image_name')->storeAs('public/product_images', $fileNameToStore);
        }

        // create product
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->hasFile('image_name')) {
            $product->image_name = $fileNameToStore;
        }
        $product->stock = $request->stock;
        $product->category_id = $request->category;
        $product->save();

        return redirect('product')->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product->image_name != 'noImage.png') {
            Storage::delete('public/product_images/'.$product->image_name);
        }
        $product->delete();
        return redirect('product')->with('success', 'Product deleted');

    }
}
