<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\SearchRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::latest()->take(6)->get();

        return view('index', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->published()->first();
        $posts = Post::latest()->take(3)->published()->get();

        //increase view count
        $postKey = 'post_' . $post->id;
        if (!Session::has($postKey)) {
            $post->increment('view_count');
            Session::put($postKey, 1);
        }

        return view('post', compact('post',  'posts'));
    }

    /**
     * Show all the post.
     *
     * @return view
     */
    public function showAllPosts()
    {
        $posts = Post::latest()->published()->paginate(10);


        return view('posts', compact('posts'));
    }

    /**
     * Show all the post.
     *
     * @return view
     */
    public function getCategories()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    /**
     * Show all the post.
     *
     * @param $slug
     * @return view
     */
    public function getCategoryPost($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->published()->paginate(10);

        return view('category-post', compact('posts'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPost(SearchRequest $request)
    {
        $search = $request->search;
        $posts = Post::where('title', 'like', "%$search%")->paginate(10);
        $posts->appends(['search' => $search]);

        return view('search', compact('posts', 'search'));
    }

    /**
     * Show all the post by tag.
     *
     * @param $slug
     * @return view
     */
    public function getTagPosts($name)
    {
        $query = $name;
        $tags = Tag::where('name', 'like', "%$name%")->paginate(10);
        $tags->appends(['search' => $name]);

        return view('tag-post', compact('tags', 'query'));
    }

    /**
     * Show all the post by tag.
     *
     * @param $post
     * @return view
     */
    public function likePost($post)
    {
        $user = Auth::user();
        $likePost = $user->likedPosts()->where('post_id', $post)->count();

        if ($likePost == 0) {
            $user->likedPosts()->attach($post);
        } else {
            $user->likedPosts()->detach($post);
        }

        return redirect()->back();
    }
}
