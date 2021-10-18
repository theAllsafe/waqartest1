<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\ForgotPasswordController;
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
Route::get('App/school', [AuthController::class, 'school_name']);
Route::post('App/signup', [AuthController::class, 'signup']);
Route::post('App/signin', [AuthController::class, 'signin']);
#-------------------------------------------------------------------------------
Route::get('App/profile/{id}', [ProfileController::class, 'profiledata']);
Route::get('App/editprofile/{id}', [ProfileController::class, 'editprofile']);
Route::post('App/updateprofile', [ProfileController::class, 'updateprofile']);
#-------------------------------------------------------------------------------
Route::get('App/profiledata/{id}', [AuthController::class, 'profiledata']);
Route::get('App/studentlist', [AuthController::class, 'studentlist']);
Route::get('App/schoollist', [AuthController::class, 'schoollist']);
Route::get('App/favorite', [AuthController::class, 'favorite']);
#-------------------------------------------------------------------------------
Route::get('App/student/list/{id}', [HomePageController::class, 'list']);
Route::post('App/student/filter', [HomePageController::class, 'filter']);
Route::post('App/forget', [ForgotPasswordController::class, 'forgot']);
Route::get('App/reset', [ForgotPasswordController::class, 'sendReset'])->name('password.reset');



Route::post('App/school/like', [AuthController::class, 'school_like']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// <-----------------------------------------------Chat------------------------------------------------->
Route::namespace ('Api')->group(function () {
    Route::post('socket/join', [SocketController::class, 'join']);
    Route::post('store-message', [Chat\ChatController::class, 'StoreMessage']);
    Route::post('store-socket-id', [Chat\ChatController::class, 'storeSocketId']);
    Route::get('delete-message/{id}', [Chat\ChatController::class, 'DeleteMessage']);
    Route::get('chat-detail/{id}', [Chat\ChatController::class, 'ChatDetail']);
    Route::get('delete-chat-list-message/{id}', [Chat\ChatController::class, 'DeleteChatListMessage']);
    Route::post('change-status-seen',  [Chat\ChatController::class, 'changeStatusSeen']);
    Route::post('change-selected-status-seen',  [Chat\ChatController::class, 'changeSelectedStatusSeen']);
    Route::get('chat-list', [Chat\ChatController::class, 'ChatList']);
    Route::post('change-status-deliver',  [Chat\ChatController::class, 'changeStatusDeliver']);
    Route::post('exit_chat_screen', [Chat\ChatController::class, 'exitChatScreen']);
    Route::post('on-chat-screen', [Chat\ChatController::class, 'onChatScreen']);
    Route::post('typing-status', [Chat\ChatController::class, 'Typing']);
    Route::get('unread-total-count', [Chat\ChatController::class, 'TotalUnreadCount']);
    Route::post('audio-typing-status', [Chat\ChatController::class, 'AudioRecord']);
});
// <----------------------------------------------------------------------------------------------------->