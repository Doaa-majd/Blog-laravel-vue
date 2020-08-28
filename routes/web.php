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
    return view('public/index');
});

Auth::routes();
Route::get('/test/{id}','TagController@getPostsByTag');
Route::get('/test','PostController@for_test');

Route::get('/home', 'HomeController@index')->name('home');   // this is for auth redirection
Route::get('/blog', 'BlogController@index')->name('blog');   // this is for auth redirection

//Route::get('/post','PostController@all_Post');

//Route::get('/{anypath}','HomeController@index')->where('anypath', '[\/\w\.-]*');

    Route::post('/add-category','CategoryController@add_category');
    Route::get('category','CategoryController@all_category');

    Route::get('category/{id}','CategoryController@delete_category');
    Route::get('editcategory/{id}','CategoryController@edit_category');
    Route::post('update-category/{id}','CategoryController@update_category');
//Posts
Route::get('/post','PostController@all_Post');
Route::post('/savepost','PostController@save_post');
//Route::post('/savepost','PostController@for_test');
Route::get('/imgpost','PostController@testTags');


Route::get('/delete/{id}','PostController@delete_post');
Route::get('/post/{id}','PostController@edit_post');
Route::post('/update/{id}','PostController@update_post');
//Tags
Route::get('/tags','TagController@allTags');
Route::get('/tagspost','TagController@tagsPost');
Route::post('/savetag','TagController@saveTag');
Route::get('/postsbytag/{id}','TagController@getPostsByTag');
Route::get('/deletetag/{id}','TagController@delete_tag');
Route::post('/updateTag/{id}','TagController@update_tag');
//MediaController
Route::get('/getmedia','MediaController@allMedia');

Route::get('/blogpost','BlogController@get_all_blog_post');
Route::get('/singlepost/{id}','BlogController@getpost_by_id');
Route::get('/categories','BlogController@get_all_category');
Route::get('/categorypost/{id}','BlogController@get_all_post_by_cat_id');
Route::get('/search','BlogController@search_post');
Route::get('/latestpost','BlogController@latest_post');
//for comments
Route::post('/replycomment','CommentController@addComment');
