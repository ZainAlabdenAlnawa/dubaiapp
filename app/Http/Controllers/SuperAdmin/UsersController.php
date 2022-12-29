<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin\Users;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //
    public function index(){
        return response(['data'=>Users::all()], 200);
    }
    public function userByRole($role){
        return response(['data'=>Users::where('role', $role)->get()], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'user_admin' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20']
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $id = Users::insertGetId(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'user_admin' => $request->user_admin
            ]
        );
        return response([
            'message' => 'user created under admin ' . $request->user_admin,
            'response' => true,
            'user' => Users::find($id)

        ], 201);
    }

    public function update($id , Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 
            \Illuminate\Validation\Rule::unique('users')->ignore($id)],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        Users::where('id', $id)->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]
        );
        return response([
            'message' => 'user updated ' ,
            'response' => true,
            'user' => Users::find($id)

        ], 201);
    }


    public function delete($id){
        Users::where("id", $id)->delete();
        return
        response(['message'=>'user removed'], 200);
    }
}
