<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
   public function index(){
    $product =auth()->user()->products;

    return response()->json([
        'success'=>true,
        'data'=>$product
    ]);
   }

   public function show($id)
   {
       $product = auth()->user()->products()->find($id);

       if(!$product) {
           return response()->json([
                'success' => false,
                'message' => 'Product with this id '.$id.'not found'],400);

       }
       return response()->json([
        'success'=>true,
        'data'=>$product
       ],400);

    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'price'=>'required|integer'
        ]);

    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;

    if(auth()->user()->products()->save($product))
        return  response()->json([
            'success'=>true,
            'data'=>$product->toArray()
        ]);

        else {
            return  response()->json([
                'success'=>true,
                'data'=>'Product not added'
            ],500);
        }
    }
  public function destroy($id){

    $product = auth()->user()->products()->find($id);
    if(!$product){
        return response()->json([
            'success' => false,
            'message' => 'Product with id'.$id.'not found'
        ],400);
    }

    if($product->delete()){
        return response()->json([
            'success'=>true
        ]);
    }else{
        return response()->json([
            'success'=>false,
            'message'=>'Product could not be deleted'
        ],500);
    }
  }

}
