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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
//{provider}の部分は、利用する他サービスの名前を入れることを想定
//Route::prefix('login')->name('login.')->group(function () {
//    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
//    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
//});
//Route::prefix('register')->name('register.')->group(function () {
//    Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
//    Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');
//});
Route::get('/','ArticleController@index')->name('articles.index');
Route::resource('articles','ArticleController')->except(['index','show'])->middleware('auth');
Route::resource('articles','ArticleController')->only(['show']);
Route::prefix('articles')->name('articles.')->group(function(){
    Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
    Route::delete('/{article}/like','ArticleController@unlike')->name('unlike')->middleware('auth');
});
//第一引数に{name}とするとTagControllerのアクションメソッドで、引数$nameを受け取ることができる
Route::get('/tags/{name}','TagController@show')->name('tags.show');
Route::prefix('users')->name('users.')->group( function () {
    Route::get('/{name}','UserController@show')->name('show');
    Route::get('/{name}/likes', 'UserController@likes')->name('likes');
    Route::get('/{name}/followings', 'UserController@followings')->name('followings');
    Route::get('/{name}/followers', 'UserController@followers')->name('followers');
    Route::middleware('auth')->group(function () {
        Route::put('/{name}/follow','UserController@follow')->name('follow');
        Route::delete('/{name}/follow','UserController@unfollow')->name('unfollow');
    });
});

