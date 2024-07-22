<?php
namespace App\Http\Controllers;
namespace App\Http\Middleware;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GroupChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CorsMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware([CorsMiddleware::class])->group(function () {
    Route::post('send-data', [ApiController::class,'receiveData']);
    Route::post('update-user', [ApiController::class,'updateUser']);
    Route::post('user-login', [LoginController::class,'Userlogin']);
    Route::get('resource', [ApiController::class, 'api_data']);
    Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [NewPasswordController::class, 'reset']);
    Route::post('messages', [ChatController::class, 'message']);    
    Route::get('historymessages', [ChatController::class, 'getChatHistory']);
    Route::delete('/api/messages/{id}', [ChatController::class, 'delete']);    
    Route::get('privatechat/{recipientId}', [ChatController::class, 'getPrivateChatHistory']);
    Route::post('privatemessages', [ChatController::class, 'privateMessage']);    
    Route::get('allusers', [ChatController::class, 'allUsers']);
    Route::post('/pusher/auth', [PusherController::class, 'authenticate']);
    Route::post('creategroup', [ChatController::class, 'creategroup']);
    Route::post('addnewusersgroup', [ChatController::class, 'addNewUserInGroup']);
    Route::delete('deletegroup/{id}', [ChatController::class, 'deleteGroup']);
    Route::get('user_groups/{id}', [ChatController::class, 'userGroups']);
    Route::get('groupdetail/{id}', [ChatController::class, 'groupDetail']);
    Route::get('testemail', [MailController::class, 'testEmail']);
    Route::post('groupmessage', [GroupChatController::class, 'groupMessage']);    
    Route::get('groupchathistory/{groupId}', [GroupChatController::class, 'fetchChatHistory']);
    Route::post('uploadimage', [GroupChatController::class, 'groupImage']);
});

// Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
// Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

