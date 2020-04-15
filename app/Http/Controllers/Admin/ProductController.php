<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {
        $products = Product::latest()->paginate(5);
        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

   

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        $categories = Category::all();
        return view('products.create')->with(['categories'=>$categories]);
    }

  

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $request->validate([
            'name' => 'required|min:6',
            'price' => 'required|integer',
            'code' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product= Product::create($request->all());
        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/images/' ;
            $file->move($destinationPath,$fileName);
            $product->image = $fileName ;
        }
        $product->save() ;
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

   

    /**

     * Display the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function show(Product $product)

    {
        return view('products.show',compact('product'));
    }

   

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit(Product $product)

    {
        $categories = Category::all();
        return view('products.edit',compact('product'))->with(['categories'=>$categories]);
    }

  

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Product $product)

    {

        $request->validate([
            'name' => 'required|min:6',
            'price' => 'required|integer',
            'code' => 'required|integer',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')

                        ->with('success','Product updated successfully');

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy(Product $product)

    {
        $product->delete();
        return redirect()->route('products.index')

                        ->with('success','Product deleted successfully');
    }
}
