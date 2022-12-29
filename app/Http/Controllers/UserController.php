<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $tokenId = explode("|", $token)[0] ?? -1;



        $tokenUserId =
            DB::table("personal_access_tokens")
            ->where("id", $tokenId);
        if (!$tokenUserId->exists()) {
            return response(["error" => "wrong token"], 400);
        }
        $tokenUserId = $tokenUserId->first()->tokenable_id;


        DB::table("personal_access_tokens")
            ->where("id", $tokenId)->delete();

        return response(['message' => "Loggedout"], 200);
    }

    public function removeToken(Request $request)
    {
        $token = $request->user_id;
        $tokenId = explode("|", $token)[0] ?? -1;



        $tokenUserId =
            DB::table("personal_access_tokens")
            ->where("id", $tokenId);
        if (!$tokenUserId->exists()) {
            return response(["error" => "wrong token"], 400);
        }
        $tokenUserId = $tokenUserId->first()->tokenable_id;



        DB::table("personal_access_tokens")
            ->where("id", $tokenId)->delete();

        return response(['message' => "Loggedout"], 200);
    }



    function registerUser(Request $request)
    {
        if (!User::where('email', $request->email)->exists()) {
            $input = [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => $request->type,
            ];
            $validator = Validator::make($request->all(), [
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'max:20'],
            ]);
            if ($validator->fails()) {
                return response(['error' => $validator->errors()]);
            }

            if ($request->password !== $request->confirm_password) {
                return response([
                    'message' => ['Password is not correct']
                ], 403);
            }
            $user = User::create([
                'fname' => $input['fname'],
                'lname' => $input['lname'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'password' => $input['password'],
                'role' => $input['type'],
            ]);
            $token = $user->createToken('my-app-token')->plainTextToken;

            User::where('email', $request->email)
                ->update(['device_token' => $request->device_token]);
           

            $response = [
                'user' => $user,
                'token' => $token,
            ];

            return response($response, 201);
        } else {
            return response([
                'message' => ['This email is already registered.']
            ], 403);
        }
    }



    public function get_user_profile_info($user_id)
    {
        if (!User::find($user_id)) {
            return response(['message' => "Not Found"], 404);
        }
        $user_profile_info = User::where('id', $user_id)
            ->select('fname', 'lname', 'email', 'phone', 'role')->first();
        $data['user_info'] = $user_profile_info;

        return json_encode($data);
    }

    public function update_user_profile_info($user_id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
        ]);
        if ($validate->fails()) {
            foreach ($validate->errors() as $error) {
                var_dump($error);
            }
            return response(['error' => $validate->errors()], 419);
        }
        User::where('id', $user_id)->update(
            [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
            ]
        );
        return response([
            'message' => 'Profile is successfully updated for user ' . $user_id,
            'user' => User::find($user_id)
        ], 200);
    }


    public function reset_password_api($u_id, Request $request)
    {

        $validator  = Validator::make($request->all(), [
            'old_password' => 'required',
        ]);

        if ($validator->fails()) {

            return response(['error' => $validator->errors()->all()], 422);
        }

        if (Hash::check($request->old_password, User::where('id', $u_id)->value('password'))) {

            if (true) {

                $validator  = Validator::make($request->all(), [
                    'new_password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'required',
                ]);

                if ($validator->fails()) {

                    return response(['error' => $validator->errors()->all()], 400);
                }

                User::where('id', $u_id)->update(['password' => bcrypt($request->new_password)]);


                return response(['message' => 'password updated', 'responseFlag' => 1], 201);
            } else {
                return response()->json(["New password doesn't match with confirm password", 'responseFlag' => -1], 422);
            }
        } else {
            return response(['error' => "Old Password not correct"], 422);
        }
    }



    public function profile_page(){
        return view('auth.profile');
    }

}
