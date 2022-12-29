<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response(
            [
                'data' => Categories::all()
            ],
            200
        );
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

        // $validator = Validator::make($request->all(), [
           
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors()], 400);
        // }
        
        
        $category = Categories::create($request->all());

        return response([
            'message' => 'New item is stored ',
            'response' => true,
            'data' => $category

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function show( $category)
    {
        if(!$this->ifFoundCategories($category)){
            return response(['message'=>'not found'], 404);
        }

        return response(['data'=>Categories::find($category)],  200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $category)
    {
        //
        // if(!$this->ifFoundCategories($category)){
        //     return response(['message'=>'not found'], 404);
        // }
        // $validator = Validator::make($request->all(), [
          
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors()], 400);
        // }
        
        
        Categories::where('id', $category)->update($request->all());

        return response([
            'message' => 'Place is updated ',
            'response' => true,
            'data' => Categories::find($category)

        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( $category)
    {
        //
        if(!$this->ifFoundCategories($category)){
            return response(['message'=>'not found'], 404);
        }

        Categories::find($category)->delete();
        return response(["message"=>"place is removed"], 200);
    }

    public function ifFoundCategories($category){
        if(!Categories::find($category)){
            return false;
        }else{
            return true;
        }
    }



}
