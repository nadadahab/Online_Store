<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    use ControllerHelperTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        if(! $products->isEmpty()){
            $data = array();
            foreach($products as $iteration => $product){
                $data[$iteration] = ['name' => $product->name,'price'=>$product->price,'image'=>$product->image];
            }
            return $this->apiResponse($data,null,200,"Listing successfully");
        }else{
            return $this->apiResponse(null,null,200,"No found products");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function featuredProducts()
    {
        $products = Product::paginate(10)->where('featured',1);
        if(! $products->isEmpty()){
            $data = array();
            foreach($products as $iteration => $product){
                $data[$iteration] = ['name' => $product->name,'price'=>$product->price,'image'=>$product->image];
            }
            return $this->apiResponse($data,null,200,"Listing successfully");
        }else{
            return $this->apiResponse(null,null,200,"No found products");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);
        if($product){
            return $this->apiResponse($product,null,200,"Found product");
        }
        return $this->apiResponse(null,null,404,'Product not found');
    }

}
