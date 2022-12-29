<?php

namespace App\Http\Controllers;

use App\Models\UserAccessRoles;
use Illuminate\Http\Request;

class UserAccessRolesController extends Controller
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

        foreach($request->roles as $role){
            foreach($role["access"] as $access){
            $userAccess  = 
            [
                'user_id'=>$request->user_id,
                'module'=>$role["module"],
                'action'=>$access
            ];

            UserAccessRoles::insert($userAccess);

                      }
        }

        return response([
            'message' => 'New item is stored ',
            'response' => true,
            'data' => UserAccessRoles::where("user_id", $request->user_id)->get()

        ], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAccessRoles  $userAccessRoles
     * @return \Illuminate\Http\Response
     */
    public function show(UserAccessRoles $userAccessRoles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAccessRoles  $userAccessRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAccessRoles $userAccessRoles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAccessRoles  $userAccessRoles
     * @return \Illuminate\Http\Response
     */
    public function update($user_id, Request $request)
    {
        // print_r($user_id);
        UserAccessRoles::where("user_id", $user_id)->delete();
        foreach($request->modules as $module){
            echo "$module <br>";
            
            if($request->has($module))
           foreach( $request->get($module) as $action){
            $userAccess  = 
            [
                'user_id'=>$user_id,
                'module'=>$module,
                'action'=>$action
            ];

            UserAccessRoles::insert($userAccess);

                      }
        }

        return response([
            'message' => 'New item is stored ',
            'response' => true,
            'data' => UserAccessRoles::where("user_id", $user_id)->get()

        ], 201);
    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAccessRoles  $userAccessRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAccessRoles $userAccessRoles)
    {
        //
    }
}
