<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\ArticleResource;
use App\Product;
use App\Helpers;
use vendor\vlucas\phpdotenv\src\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        $response = Helpers\APIHelpers::createAPIResponse(false, 200, '', $products);
        $response = Product::paginate(50);
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $validatedData = $request->validate([
            'description' => 'required|max:1000',
            'name' => 'required|max:200',
        ]);

         if ($validatedData) {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->external_id = $request->external_id;
            $product_create = $product->save();

            if ($product_create) {
                $response = Helpers\APIHelpers::createAPIResponse(false, 200, 'Product added successfully', $product->id);
                return response()->json($response, 200);
            } else {
                $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Product added failed', null);
                return response()->json($response, 400);
            }
        } else {
            $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Validation error', null);
            return response()->json($response, 400);
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
        $product = Product::find($id);
        $response = Helpers\APIHelpers::createAPIResponse(false, 200, '', $product);
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $product = Product::find($id);
        $product_delete = $product->delete();

        if ($product_delete) {
            $response = Helpers\APIHelpers::createAPIResponse(false, 200, 'Product delete successfully', null);
            return response()->json($response, 200);
        } else {
            $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Product delete failed', null);
            return response()->json($response, 400);
        }
    }
}
