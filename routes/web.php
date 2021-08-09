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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::group(['prefix' =>'', 'middleware' => ['auth']],function () {
    Route::get('{any?}', function() {
        $post = app()->make('App\Http\Controllers\PostController')->
                index(
                    app()->make('\Illuminate\Http\Request'),
                    app()->make('App\Post')
                );
        $term = app()->make('App\Http\Controllers\TermController')->
                index(
                    app()->make('App\Term')
                );
        return view('manage', compact('post', 'term'));
    })->where('any', '.*');
});

// Route::get(
//     '{uri}',
//     '\\' . Pallares\LaravelNuxt\Controllers\NuxtController::class
// )->where('uri', '.*');
