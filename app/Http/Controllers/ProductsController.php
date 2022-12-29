<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        return response(
            [
                'data' => Products::paginate($request->limit)
            ],
            200
        );
    }

    public function index_view(){
        return view("products.index");
    }

    public function index_user()
    {
        $data['products'] = Products::where("user_id", Auth::id())->get();
        return view("products.index_user", $data);
    }

    public function user_products($user_id, Request $request)
    {
        //
        return response(
            [
                'data' => Products::where("user_id", $user_id)->paginate($request->limit)
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

        return view("products.create");
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
        // $product = Products::create($request->all());
        $product = new Products;

        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('storage'), $filename);
            $product->image = url('public/storage/'.$filename);
        }

        $product->save();

        return response([
            'message' => 'New item is stored ',
            'response' => true,
            'data' => $product

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        if (!$this->ifFoundProducts($product)) {
            return response(['message' => 'not found'], 404);
        }

        return response(['data' => Products::find($product)],  200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $data['product'] = Products::findOrFail($product);
        return view("products.edit",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $product)
    {

        $product = Products::findOrFail($product);

        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('storage'), $filename);
            $product->image = url('public/storage/' . $filename);
        }
        $product->save();
        
        return response([
            'message' => 'Place is updated ',
            'response' => true,
            'data' => Products::find($product)

        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        //
        if (!$this->ifFoundProducts($product)) {
            return response(['message' => 'not found'], 404);
        }

        Products::find($product)->delete();
        return response(["message" => "place is removed"], 200);
    }

    public function delete($product)
    {
        //
        if (!$this->ifFoundProducts($product)) {
            return response(['message' => 'not found'], 404);
        }

        Products::find($product)->delete();
        return back();
    }

    public function ifFoundProducts($product)
    {
        if (!Products::find($product)) {
            return false;
        } else {
            return true;
        }
    }

    public function addUserToProduct($user, $product){

        if (!$this->ifFoundProducts($product)) {
            return response(['message' => 'not found'], 404);
        } 

        Products::where("id", $product)->update(["user_id"=> $user]);
        return response(['message' => "product $product is attached to $user"], 200);
    }

    public function addUserToProductPage( $product)
    {

        if (!$this->ifFoundProducts($product)) {
            return response(['message' => 'not found'], 404);
        }
        $data['product_id'] = $product;
        $data['users'] = User::where("role", 1)->get();
        return view("products.addUserToProduct", $data);
    }

    
}
