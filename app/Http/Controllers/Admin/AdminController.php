<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function registerAdmin(Request $request)
    {
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
        ];

        $this->validate($request, $rules);


        DB::table('roles')->truncate();

        $role = Role::create([
           'name' => 'Super Admin',
           'slug' => 'super admin',
           'status' => 1,
        ]);

        User::create([
            'name' => $request->name,
            'role_id' => $role->id,
            'is_admin' => 1,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
            'permissions' => 'All',
        ]);

        print_r($role);

        return redirect()->route('admin.login')->with('mesg','Admin Registered Successfully !! ');
    }
}
