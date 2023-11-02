<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin',1)->get()->except(1);
        return view('admin.user.index',compact('users'));
    }

    public function createUser()
    {
        $routes = Route::getRoutes();
        $groupadminRoutes = [];
        foreach ($routes as $route)
        {
            if(strpos($route->getPrefix(), 'admin') !== false)
            {

                $prefix = explode('/admin/',$route->getPrefix());
                $groupadminRoutes[$prefix[1]][] = $route->getName();
            }
        }
//        dd($adminRoutes);

        $roles =  Role::all()->except(1);
        return view('admin.user.create',compact('groupadminRoutes','roles'));
    }

    public function postCreate(Request $request)
    {


        $request->validate([
           'name' => 'required',
           'email'=>'required|unique:users',
           'role_id' => 'required',
           'password' => 'required',
        ]);
//        dd(json_encode($request->permissions));
//        dd($request->all());

        User::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'is_admin' => 1,
            'permissions' => json_encode($request->permissions),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('users')->with('mesg', 'User Created Successfully!');
    }

    public function deleteUser(Request $request){

        if($request->ids)
        {
            $res =  User::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json(['status'=>true,'mesg'=>'Deleted Successfully']);
            }
        }
    }

    public function editUser($id){
        $user = User::find($id);

        $routes = Route::getRoutes();
        $groupadminRoutes = [];
        foreach ($routes as $route)
        {
            if(strpos($route->getPrefix(), 'admin') !== false)
            {

                $prefix = explode('/admin/',$route->getPrefix());
                $groupadminRoutes[$prefix[1]][] = $route->getName();
            }
        }
//        dd($adminRoutes);

        $roles =  Role::all()->except(1);
        return view('admin.user.edit',compact('user','groupadminRoutes','roles'));
    }

    public function updateUser(Request $request){
//        dd($request->all());

        $request->validate([
            'name' => 'required',
            'email'=>'required',
            'role_id' => 'required',
        ]);


        User::find($request->id)->update([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'permissions' => json_encode($request->permissions),
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('users')->with('mesg', 'User Updated Successfully!');
    }

}
