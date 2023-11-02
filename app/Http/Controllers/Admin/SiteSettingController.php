<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SiteSetting;
class SiteSettingController extends Controller
{
    public function index(Request $request)
    {
        $site = SiteSetting::first();
        return view('admin.sitesettings.index',compact('site'));
    }

    public function updateSiteSettings(Request $request){
//        dd($request->all());

        SiteSetting::find($request->id)->update($request->all());

        return redirect()->route('sitesettings')->with('mesg', 'Site Settings Updated Successfully!');
    }
}
