<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use App\CaseStudies;
use App\News;
use App\Widgets;
use App\Slider;
use Illuminate\Support\Facades\Artisan;
class MainController extends Controller
{

    public function showFrontEndView($name=null,$end=null){
        $pageContent = Page::where('slug', $name)->first();

        $name = isset($pageContent->template) && !empty($pageContent->template) ? $pageContent->template : '404';

        return view('templates/'.$name, compact('pageContent'));
    }
}
