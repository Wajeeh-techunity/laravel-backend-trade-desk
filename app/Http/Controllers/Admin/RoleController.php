<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all()->except(1);
        return view('admin.role.index',compact('roles'));
    }

    public function createRole()
    {
        return view('admin.role.create');
    }

    public function postCreate(Request $request)
    {

//        dd($request->all());
        Role::create($request->all());

        return redirect()->route('role')->with('mesg', 'Role Created Successfully!');
    }

    public function deleteRole(Request $request){

        if($request->ids)
        {
            $res =  Role::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json(['status'=>true,'mesg'=>'Deleted Successfully']);
            }
        }
    }

    public function editRole($id){
        $role = Role::find($id);

        return view('admin.role.edit',compact('role'));
    }

    public function updateRole(Request $request){
//        dd($request->all());

        Role::find($request->id)->update($request->all());

        return redirect()->route('role')->with('mesg', 'Role Updated Successfully!');
    }

}
