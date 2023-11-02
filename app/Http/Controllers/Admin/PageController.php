<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Page;
use App\GetTemplates;
use Auth;

use Cviebrock\EloquentSluggable\Services\SlugService;


class PageController extends Controller {

    public function index()
    {
        if(auth()->user()->role_id == 1)
        {
            $pages = Page::all();
        }
        else{
            $pages = Page::where('user_id',auth()->user()->id)->get();
        }

        return view('admin.page.index',compact('pages'));
    }

    public function createPage()
    {
        $template = new GetTemplates();
        $templates = $template->getTemplates();
        $image_fields = ['image', 'banner_image'];

        return view('admin.page.create', compact('image_fields', 'templates'));
    }

    public function postCreate(Request $request)
    {
        if(isset($request->content2) && count($request->content2) > 0){
            $content2 = serialize(array_filter($request->content2));
            $request->request->add(['content2' => $content2]);
        }

        if(isset($request->other_imagess) && count(array_filter($request->other_imagess)) > 0){
            $other_images = serialize(array_filter($request->other_imagess));
            $request->request->add(['other_images' => $other_images]);
        }

        $request->request->add(['user_id' => Auth::id()]);
//        $request->request->add(['slug' => SlugService::createSlug(Page::class, 'slug', $request->title)]);


        Page::create($request->all());

        return redirect()->route('page')->with('mesg', 'Page Created Successfully!');
    }

    public function deletePage(Request $request){

        if($request->ids)
        {
            $res =  Page::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json($res);
            }
        }
    }

    public function editPage($id){
        $page = Page::find($id);
        $template = new GetTemplates();
        $templates = $template->getTemplates();
        $image_fields = ['image', 'banner_image'];

        $page_content2 = [];
        if(isset($page->content2) && $page->content2 != ""){
            $page_content2= array_filter(unserialize($page->content2));
        }
        $other_images = [];
        if(isset($page->other_images) && $page->other_images != ""){
            $other_images = array_filter(unserialize($page->other_images));
        }

        return view('admin.page.edit',compact('page','image_fields', 'templates','page_content2','other_images'));
    }

    public function updatePage(Request $request){

        if(isset($request->content2) && count($request->content2) > 0){
            $content2 = serialize(array_filter($request->content2));
            $request->request->add(['content2' => $content2]);
        }

        $request->validate([
            'slug' => 'required|unique:pages,slug,'.$request->id,
        ]);

        if(isset($request->other_imagess) && count(array_filter($request->other_imagess)) > 0){
            $other_images = serialize(array_filter($request->other_imagess));
            $request->request->add(['other_images' => $other_images]);
        }

        Page::find($request->id)->update($request->all());

        return redirect()->route('page')->with('mesg', 'Page Updated Successfully!');
    }

}
