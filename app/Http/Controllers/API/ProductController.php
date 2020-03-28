<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use API;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products = Product::latest()->get();
       $parent = array();

       foreach ($products as $product){
           $child = array(
               'id' => $product['id'],
               'name' => $product['name'],
               'price' => $product['price'],
               'images' => $product->getFirstMediaUrl()
           );

           array_push($parent, $child);
       }

        return API::response(200, 'products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required',
            'files' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        if ($request->hasFile('files')) {
            foreach (array_unique($request->file('files')) as $uploadedFile) {
               $product->addMedia($uploadedFile)->toMediaCollection('product_images');
            }
        }

        return response(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
