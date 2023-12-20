<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/profile/pictures', 'HomeController@profile_images')->name('user.profile.pictures');
Route::get('/profile/setting', 'HomeController@setting')->name('user.profile.setting');
Route::get('/profile/remove_profile_picture', 'HomeController@remove_profile_picture')->name('user.profile.remove_profile_picture');
Route::put('/profile/setting', 'HomeController@update')->name('user.profile.update');

Route::get('/profile/reserves', 'HomeController@reservation_history')->name('user.profile.reserve_history');


Route::get('/App/getOrginalPicture/{pictureid}','Api\profile\profileController@getOriginalPicture')->name('getOriginalUserPicture');

Route::get('/event/{event_id}/show','User\eventController@show')->name('user.event.show');
Route::get('/event/{event_id}/confirm','User\eventController@confirm')->name('user.event.confirm');
Route::post('/event/{event_id}/registration','User\eventController@registration')->name('user.event.registration');

//Route::get('/login', 'App\Http\Controllers\User\LoginController@index')->name('user.login');
Route::get('/login',[LoginController::class,'index'])->name('user.login');
Route::post('/login', 'App\Http\Controllers\user\LoginController@send_confirm_sms')->name('user.login.send_sms');
Route::get('/logout', 'App\Http\Controllers\user\LoginController@logout')->name('user.logout');

Route::get('/confirm/{number}', 'App\Http\Controllers\user\LoginController@confirm')->name('user.login.confirm');
Route::post('/confirm', 'App\Http\Controllers\user\LoginController@confirm_pin')->name('user.login.confirm_pin');

Route::get('/first', 'App\Http\Controllers\user\LoginController@first')->name('user.first');
Route::post('/first', 'App\Http\Controllers\user\LoginController@first_update')->name('user.first.update');

Route::get('/reserve', 'App\Http\Controllers\user\ReserveController@index')->name('user.reserve.index');
Route::post('/reserve', 'App\Http\Controllers\user\ReserveController@reserve')->name('user.reserve.reserve');
Route::get('/reserve/confirm','App\Http\Controllers\user\ReserveController@confirm')->name('user.reserve.confirm');
Route::get('/reserve/{reserve_id}/edit','App\Http\Controllers\user\ReserveController@edit')->name('user.reserve.edit');
Route::put('/reserve/{reserve_id}/update','App\Http\Controllers\user\ReserveController@update')->name('user.reserve.update');
Route::get('/reserve/{reserve_id}/cancel','App\Http\Controllers\user\ReserveController@cancel')->name('user.reserve.cancel');

Route::prefix('admin')->group(function () {
    Auth::routes([
        'register' => true, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);

    Route::resource('games','Admin\GamesController',['except' => [ 'show' ]]);
    Route::get('/games/{game}/delete_cover_image', 'Admin\GamesController@remove_cover_image')->name('games.remove_cover_picture');

    Route::resource('game_played','Admin\GamePlayedController');

    Route::resource('event','Admin\EventsController');
    Route::get('events/get/events/json' , 'Admin\EventsController@EventsJson')->name('events.calendarJson');
    Route::resource('registration','Admin\EventRegistrationsController');
    Route::resource('event_label','Admin\EventLabelController');
    Route::get('/event_label/{event_label}/delete_cover_image', 'Admin\EventLabelController@remove_cover_image')->name('event_label.remove_cover_picture');

    Route::resource('reserve','Admin\ReservationController');
    Route::get('reserve/get/reserve/json' , 'Admin\ReservationController@ReserveJson')->name('reserve.calendarJson');
    Route::get('reserve/{reserve}/cancel' , 'Admin\ReservationController@cancel')->name('reserve.cancel');

    Route::resource('time_place','Admin\TimePlaceController');
    Route::get('time_place/{time_place}/show_group','Admin\TimePlaceController@showInGroup')->name('time_place.showInGroup');

    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
});