<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\News;
use Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id','DESC')->get();
        return view('admin.news.index',compact('news'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function postCreate(Request $request)
    {


        $request->validate([
            'title' => 'required',
            'description'=>'required',
            'short_description'=>'required',
            'image' => 'required',
        ]);
//        dd(json_encode($request->permissions));
//        dd($request->all());

        $request->request->add(['user_id' => Auth::id()]);

        $request->merge([
            'publish_date' => date('Y-m-d', strtotime($request->publish_date)),
        ]);
//        dd($request->all());
        News::create($request->all());


        return redirect()->route('news')->with('mesg', 'News Created Successfully!');
    }

    public function deleteNews(Request $request){

        if($request->ids)
        {
            $res =  News::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json(['status'=>true,'mesg'=>'Deleted Successfully']);
            }
        }
    }

    public function editNews($id){
        $news = News::find($id);
        
        return view('admin.news.edit',compact('news'));
    }

    public function updateNews(Request $request){
//        dd($request->all());

        $request->validate([
            'title' => 'required',
            'description'=>'required',
            'short_description'=>'required',
            'image' => 'required',
            'slug' => 'required|unique:news,slug,'.$request->id,
        ]);

        $request->merge([
            'publish_date' => date('Y-m-d', strtotime($request->publish_date)),
        ]);
//        dd($request->all());

        News::find($request->id)->update($request->all());

        return redirect()->route('news')->with('mesg', 'News Updated Successfully!');
    }
}
