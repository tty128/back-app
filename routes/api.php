<?php

use Illuminate\Http\Request;

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
Route::get('post', 'Front\PostController@index');
Route::get('post/{post}', 'Front\PostController@show');
Route::get('term-taxonomy', 'Front\TermTaxonomyController@index');
Route::get('term-taxonomy/{taxonomy_name}/{term_name}', 'Front\TermTaxonomyController@show');

Route::group(['prefix'=>'manage','middleware' => 'auth:api'],function () {
    Route::apiResource('/post', 'PostController');
    Route::apiResource('/term', 'TermController');
    Route::apiResource('/taxonomy', 'TaxonomyController');
    Route::apiResource('/term-taxonomy', 'TermTaxonomyController');
    Route::post('/post-term', 'PostTermController');
});
