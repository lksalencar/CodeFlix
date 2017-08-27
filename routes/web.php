<?php

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

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin\\'
], function (){
    Route::name('login')->get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['isVerified','can:admin']], function (){
        Route::name('logout')->post('logout', 'Auth\LoginController@logout');
        Route::get('dashboard', function (){
            return view('admin.dashboard');
        });
        Route::name('user_settings.edit')->get('users/settings', 'Auth\UserSettingsController@edit');
        Route::name('user_settings.update')->put('users/settings', 'Auth\UserSettingsController@update');
        Route::resource('users', 'UsersController');
        Route::resource('categories','CategoriesController');
        Route::resource('plans','PlansController');
        Route::resource('web_profiles','PayPalWebProfilesController');

        Route::name('series.thumb_asset')
            ->get('series/{serie}/thumb_asset','SeriesController@thumbAsset');
        Route::name('series.thumb_small_asset')
            ->get('series/{serie}/thumb_small_asset','SeriesController@thumbSmallAsset');
        Route::resource('series','SeriesController');
        Route::group(['prefix' => 'videos', 'as' => 'videos.'], function (){
            Route::name('relations.create')->get('{video}/relations','VideoRelationsController@create');
            Route::name('relations.store')->post('{video}/relations','VideoRelationsController@store');
            Route::name('uploads.create')->get('{video}/uploads','VideoUploadsController@create');
            Route::name('uploads.store')->post('{video}/uploads','VideoUploadsController@store');
        });
        Route::name('videos.file_asset')
            ->get('videos/{video}/file_asset','VideosController@fileAsset');
        Route::name('videos.thumb_asset')
            ->get('videos/{video}/thumb_asset','VideosController@thumbAsset');
        Route::name('videos.thumb_small_asset')
            ->get('videos/{video}/thumb_small_asset','VideosController@thumbSmallAsset');
        Route::resource('videos','VideosController');
    });

});
