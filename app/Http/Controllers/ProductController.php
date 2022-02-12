<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('name', $request->name)->first();
        if($product)
            return response()->json(['code' => 0, 'message' => 'Nombre de producto ya existe']);
        $product = new Product();
        $product->name = $request->name;
        $product->price = round($request->price, 2);
        $product->iva = $request->iva;
        $product->user_id = auth()->user()->id;
        $product->save();
        return response()->json(['code' => 200, 'product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product)
            return response()->json(['code' => 404, 'message' => 'Producto no existe']);
        return response()->json(['code' => 200, 'product' => $product]);
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
        $product = Product::find($id);
        if(!$product)
            return response()->json(['code' => 404, 'message' => 'Producto no existe']);
        $product->name = $request->name;
        $product->price = round($request->price, 2);
        $product->iva = $request->iva;
        $product->save();
        return response()->json(['code' => 200, 'product' => $product]);
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
        if(!$product)
            return response()->json(['code' => 404, 'message' => 'Producto no existe']);
        $product->delete();
        return response()->json(['code' => 200]);
    }
}
