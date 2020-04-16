<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    use ControllerHelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        if(! $categories->isEmpty()){
            $data = array();
            foreach($categories as $iteration => $category){
                $data[$iteration] = ['name' => $category->name,'details'=>$category->details,'image'=>$category->image];
            }
            return $this->apiResponse($data,null,200,"Listing successfully");
        }else{
            return $this->apiResponse(null,null,200,"No found categories");
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
        $category=Category::find($id);
        if($category){
            return $this->apiResponse($category,null,200,"Category Found");
        }
        return $this->apiResponse(null,null,404,'Category not found');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productsCategory($id)
    {
        $products = Category::with('products')->where('id',$id)->get();
        if(! $products->isEmpty()){
            if( ! $products[0]['products']->isEmpty()){
                $data = array();
                foreach($products[0]['products'] as $iteration => $product){
                    $data[$iteration] = ['name' => $product->name,'price'=>$product->price,'image'=>$product->image];
                }
                return $this->apiResponse($data,null,200,"Listing successfully");
            }
        }
        return $this->apiResponse(null,null,404,'No found products');
    }
}
