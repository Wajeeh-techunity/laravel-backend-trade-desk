<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    if(Auth::check())
    {
        return redirect()->route('admin.dashboard');
    }
    if(App\User::orderBy('id','DESC')->first())
    {
        return redirect()->route('admin.login');
    }
    else{
        return redirect()->route('admin.register');
    }

});

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');

    Route::prefix('admin/page')->group(function () {
        Route::get('/', 'Admin\PageController@index')->name('page');
        Route::get('create', 'Admin\PageController@createPage')->name('create.page');
        Route::post('insert', 'Admin\PageController@postCreate')->name('insert.page');
        Route::get('edit/{id}', 'Admin\PageController@editPage')->name('edit.page');
        Route::post('update', 'Admin\PageController@updatePage')->name('update.page');
        Route::post('delete', 'Admin\PageController@deletePage')->name('delete.page');

    });

    Route::prefix('admin/role')->group(function () {
        Route::get('/', 'Admin\RoleController@index')->name('role');
        Route::get('create', 'Admin\RoleController@createRole')->name('create.role');
        Route::post('insert', 'Admin\RoleController@postCreate')->name('insert.role');
        Route::get('edit/{id}', 'Admin\RoleController@editRole')->name('edit.role');
        Route::post('update', 'Admin\RoleController@updateRole')->name('update.role');
        Route::post('delete', 'Admin\RoleController@deleteRole')->name('delete.role');
    });

    Route::prefix('admin/users')->group(function () {
        Route::get('/', 'Admin\UserController@index')->name('users');
        Route::get('create', 'Admin\UserController@createUser')->name('create.user');
        Route::post('insert', 'Admin\UserController@postCreate')->name('insert.user');
        Route::get('edit/{id}', 'Admin\UserController@editUser')->name('edit.user');
        Route::post('update', 'Admin\UserController@updateUser')->name('update.user');
        Route::post('delete', 'Admin\UserController@deleteUser')->name('delete.user');
    });

    Route::prefix('admin/news')->group(function () {
        Route::get('/', 'Admin\NewsController@index')->name('news');
        Route::get('create', 'Admin\NewsController@createNews')->name('create.news');
        Route::post('insert', 'Admin\NewsController@postCreate')->name('insert.news');
        Route::get('edit/{id}', 'Admin\NewsController@editNews')->name('edit.news');
        Route::post('update', 'Admin\NewsController@updateNews')->name('update.news');
        Route::post('delete', 'Admin\NewsController@deleteNews')->name('delete.news');
    });

    Route::prefix('admin/menus')->group(function () {
        Route::get('/', 'Admin\MenuController@index')->name('menus');
        Route::post('insert', 'Admin\MenuController@postCreate')->name('insert.menu');
        Route::post('update', 'Admin\MenuController@updateMenu')->name('update.menu');
        Route::post('update-position', 'Admin\MenuController@updateMenuPosition')->name('update.menu.position');
        Route::post('delete', 'Admin\MenuController@deleteMenu')->name('delete.menu');
    });

    Route::prefix('admin/contactus')->group(function () {
        Route::get('/', 'Admin\ContactUsController@index')->name('contact.queries');
        Route::post('delete', 'Admin\ContactUsController@deleteQueries')->name('delete.contact.queries');
    });

    Route::prefix('admin/sitesettings')->group(function () {
        Route::get('/', 'Admin\SiteSettingController@index')->name('sitesettings');
        Route::post('update', 'Admin\SiteSettingController@updateSiteSettings')->name('update.sitesettings');
    });

    Route::prefix('admin/message')->group(function () {
        Route::get('/','Admin\MessageController@index')->name('message');

    });
    Route::get('/get-conversation-list','Admin\MessageController@getConversationList')->name('get-conversation-list');
    Route::get('/get-conversation','Admin\MessageController@getConversation')->name('get-conversation');
    Route::post('/post-message','Admin\MessageController@postMessage')->name('post-message');

    Route::get('/conversation-block','Admin\MessageController@conversationBlock')->name('conversation-block');

    Route::get('/get-message-notification','Admin\MessageController@getMessageNotification')->name('get-message-notification');

});

Route::get('/admin/login', function (){
    if(App\User::orderBy('id','DESC')->first())
    {
        if(Auth::check())
        {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }
    else{
        return redirect()->route('admin.register');
    }

})->name('admin.login');

Route::get('/admin/register', function (){
    if(!App\User::orderBy('id','DESC')->first())
    {
        return view('admin.register-user');
    }
    else{
        return redirect()->route('admin.login');
    }


})->name('admin.register');

Route::post('register-admin','Admin\AdminController@registerAdmin')->name('register.admin');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//chat
Route::get('/get-chat','Website\chatController@getConversationChat')->name('get-chat');
Route::post('/post-chat','Website\chatController@postConversationChat')->name('post-chat');




Route::post('contact-us','Admin\ContactUsController@submitQuery')->name('submit-query');
Route::post('signup','Website\SignupController@signup')->name('signup');
Route::get('{name?}', 'Website\MainController@showFrontEndView');
