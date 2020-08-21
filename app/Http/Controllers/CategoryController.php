<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\ArticleResource;
use App\Product;
use App\Category;
use App\Helpers;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        $response = Helpers\APIHelpers::createAPIResponse(false, 200, '', $categories);
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
            $category = new Category();
            $category->name = $request->name;
            $category->parent_category = $request->parent_category;
            $category->external_id = $request->external_id;
            $category->external_id = $request->external_id;
            $category_create = $category->save();

            if ($category_create) {
                $response = Helpers\APIHelpers::createAPIResponse(false, 200, 'Category added successfully', null);
                return response()->json($response, 200);
            } else {
                $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Category added failed', null);
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
        $category = Category::where('products.category_id', '=', $id)->join('products', 'products.category_id', '=', 'categories.id')->get();
        $response = Helpers\APIHelpers::createAPIResponse(false, 200, '', $category);
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
        $category = Category::find($id);

        $category_update = $category->update($request->all());

        if ($category_update) {
            $response = Helpers\APIHelpers::createAPIResponse(false, 200, 'Product update successfully', null);
            return response()->json($response, 200);
        } else {
            $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Product update failed', null);
            return response()->json($response, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category_delete = $category->delete();

        if ($category_delete) {
            $response = Helpers\APIHelpers::createAPIResponse(false, 200, 'Category delete successfully', null);
            return response()->json($response, 200);
        } else {
            $response = Helpers\APIHelpers::createAPIResponse(true, 400, 'Category delete failed', null);
            return response()->json($response, 400);
        }
    }
}
