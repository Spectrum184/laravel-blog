<?php

use App\Category;
use App\Mail\NewPost;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

// Route::get('/', function () {
//     return view('index');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/posts', 'HomeController@showAllPosts')->name('posts');
Route::get('/posts/{slug}', 'HomeController@showPost')->name('post');
Route::get('/categories', 'HomeController@getCategories')->name('categories');
Route::get('/search', 'HomeController@searchPost')->name('search');
Route::get('/category/{slug}', 'HomeController@getCategoryPost')->name('category.post');
Route::get('/tag/{name}', 'HomeController@getTagPosts')->name('tag.posts');
Route::post('/comment/{post}', 'CommentController@store')->name('comment.store')->middleware('auth');
Route::post('/comment-reply/{comment}', 'CommentReplyController@store')->name('reply.store')->middleware('auth');
Route::post('/like-post/{post}', 'HomeController@likePost')->name('post.like')->middleware('auth');

/*------------------SOCIAL LOGIN------------------*/
Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback')->name('login.google.callback');

/*------------------ADMIN ROUTER------------------*/

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('profile', 'DashboardController@showProfile')->name('profile');
    Route::put('profile', 'DashboardController@updateProfile')->name('profile.update');
    Route::put('profile/password', 'DashboardController@changePassword')->name('profile.password');
    Route::resource('user', 'UserController')->except(['show', 'create', 'edit', 'store']);
    Route::resource('category', 'CategoryController')->except(['show', 'create', 'edit']);
    Route::resource('post', 'PostController');
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comment/{id}', 'CommentController@destroy')->name('comment.destroy');
    Route::get('comment-replies', 'CommentReplyController@index')->name('comment-reply.index');
    Route::delete('comment-reply/{id}', 'CommentReplyController@destroy')->name('comment-reply.destroy');
    Route::get('post-liked-users/{post}', 'PostController@likedUsers')->name('post.like.users');
});

/*------------------USER ROUTER------------------*/
Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function () {
    Route::get('profile', 'DashboardController@showProfile')->name('profile');
    Route::put('profile', 'DashboardController@updateProfile')->name('profile.update');
    Route::put('profile/password', 'DashboardController@changePassword')->name('profile.password');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comment/{id}', 'CommentController@destroy')->name('comment.destroy');
    Route::get('comment-replies', 'CommentReplyController@index')->name('comment-reply.index');
    Route::delete('comment-reply/{id}', 'CommentReplyController@destroy')->name('comment-reply.destroy');
    Route::get('user-liked-posts', 'DashboardController@likedUsers')->name('like.post');
});

/*------------------VIEW COMPOSER------------------*/
View::composer('layouts.frontend.components.sidebar', function ($view) {
    $categories = Category::all()->take(10);
    $recentTags = Tag::all();
    $recentPosts = Post::latest()->take(3)->get();

    return $view->with('categories', $categories)->with('recentPosts', $recentPosts)->with('recentTags', $recentTags);
});

/*------------------SEND MAIL------------------*/
Route::get('/send-mail', function () {
    $post = Post::findOrFail(7);

    Mail::to('superkit184@gmail.com')->queue(new NewPost($post));

    return (new App\Mail\NewPost($post))->render();
});
