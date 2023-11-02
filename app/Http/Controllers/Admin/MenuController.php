<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Menu;
use App\Page;
use Auth;
use phpDocumentor\Reflection\Types\Null_;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menu_type = 'header';
        if($request->menu_type)
        {
            $menu_type = $request->menu_type;
        }
        $pages = Page::all();
        $menus = Menu::where('parent_id',null)->where('menu_location',$menu_type)->orderBy('position','ASC')->get();
        return view('admin.menu.index',compact('menus','pages','menu_type'));
    }


    public function postCreate(Request $request)
    {


        $request->validate([
            'name' => 'required',
//            'page_id'=>'required',
            'menu_location' => 'required',
            'status' => 'required',
        ]);
//        dd($request->all());

        $request->request->add(['user_id' => Auth::id()]);

        if($request->parent_id != null)
        {
            $last_position = Menu::where('parent_id',$request->parent_id)->get()->count();
        }
        else{
            $last_position = Menu::where('parent_id',null)->get()->count();
        }

        $request->request->add(['position' => $last_position+1]);

        if($request->page_id == null && $request->other_url == null)
        {
            $request->merge([
                'other_url' => '#',
            ]);
        }
//        dd($request->all());
        Menu::create($request->all());


        return redirect()->route('menus')->with('mesg', 'Menu Created Successfully!');
    }

    public function deleteMenu(Request $request){

        if($request->ids)
        {
            $res =  Menu::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json(['status'=>true,'mesg'=>'Deleted Successfully']);
            }
        }
    }



    public function updateMenu(Request $request){
//        dd($request->all());

        $request->validate([
            'name' => 'required',
            'menu_location' => 'required',
            'status' => 'required',
        ]);

//        dd($request->all());
        if($request->page_id == null && $request->other_url == null)
        {
            $request->merge([
                'other_url' => '#',
            ]);
        }
        Menu::find($request->id)->update($request->all());

        return redirect()->route('menus')->with('mesg', 'Menu Updated Successfully!');
    }

    public function updateMenuPosition(Request $request){
//        dd($request->positions);
        if(!empty($request->positions))
        {
           foreach ($request->positions as $key => $position)
           {
               $up = Menu::find($position['id']);
               $up->position = $key+1;
               $up->parent_id = null;
               $up->update();
               if(isset($position['children']))
               {
                   foreach ($position['children'] as $key1 => $position1)
                   {
                       $up1 = Menu::find($position1['id']);
                       $up1->position = $key1+1;
                       $up1->parent_id = $up->id;
                       $up1->update();
                       if(isset($position1['children']))
                       {
                           foreach ($position1['children'] as $key2 => $position2)
                           {
                               $up2 = Menu::find($position2['id']);
                               $up2->position = $key2+1;
                               $up2->parent_id = $up1->id;
                               $up2->update();
                           }
                       }
                   }
               }
           }
        }
        return response()->json(['status'=>true,'mesg'=>'Updated Successfully']);
    }
    
    
}
