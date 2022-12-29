<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function index($user_id)
    {
        return response(['data' => Users::where('role', 1)->get()], 200);
    }
    public function index_users()
    {
        return view("users.index");
    }
    public function userByRole($user_id, $role)
    {
        return response(['data' => Users::where('user_admin', $user_id)->where('role', $role)->get()], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:10', ],
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
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'user_admin' => $request->user_admin
            ]
        );
        return response([
            'message' => 'user created under admin ' . $request->user_amdin,
            'response' => true,
            'user' => Users::find($id)

        ], 201);
    }

    public function update($id, Request $request)
    {
        if (Users::find($id)) {
            if (Users::find($id)->user_admin != $request->user_admin) {
                return response(['message' => "Un authorized for this user account"], 403);
            }
        } else {
            return response(['message' => "Not found"], 404);
        }


        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:10', ],
            'role' => ['required', 'string'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($id)
            ],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        Users::where('id', $id)->update(
            [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                'role' => $request->role,
            ]
        );
        return response([
            'message' => 'user updated ',
            'response' => true,
            'user' => Users::find($id)

        ], 201);
    }


    public function delete($id, Request $request)
    {
        if (Users::find($id)) {
            if (Users::find($id)->user_admin != $request->user_admin) {
                return response(['message' => "Un authorized for this user account"], 403);
            }
        } else {
            return response(['message' => "Not found"], 404);
        }

        Users::where("id", $id)->delete();
        return
            response(['message' => 'user removed'], 200);
    }


    public function users()
    {
        return view("users.index");
    }
    public function create()
    {
        return view("users.create");
    }
}
