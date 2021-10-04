<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\NewPost;
use App\Post;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // add more validate
        $request->validate([
            'title' => 'unique:posts',
            'image' => 'required'
        ]);

        $slug = Str::slug($request->title, '-');
        $image = $request->image;
        $imageName = $slug . '-' . uniqid() . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();

        if (!Storage::disk('public')->exists('post')) {
            Storage::disk('public')->makeDirectory('post');
        }

        $image->storeAs('post', $imageName, 'public');

        $post = new Post();
        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;

        if (isset($request->status)) {
            $post->status = 1;
        }

        $post->save();

        //notification by mail
        if ($post->status) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new NewPost($post));
            }
        }

        // save tags
        $tags = [];
        $stringTag = array_map('trim', explode(",", $request->tags));
        foreach ($stringTag  as $tag) {
            array_push($tags, ['name' => $tag]);
        }

        $post->tags()->createMany($tags);

        Toastr::success('Post saved!', 'success');

        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();

        return view('admin.post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $slug = Str::slug($request->title, '-');

        if (isset($request->image)) {
            $image = $request->image;
            $imageName = $slug . '-' . uniqid() . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }

            if (!Storage::disk('public')->exists('post/' . $post->image)) {
                Storage::disk('public')->delete('post/' . $post->image);
            }

            $image->storeAs('post', $imageName, 'public');
        } else {
            $imageName = $post->image;
        }

        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;

        if (isset($request->status)) {
            $post->status = 1;
        }

        $post->save();

        $post->tags()->delete();

        // save tags
        $tags = [];
        $stringTag = array_map('trim', explode(",", $request->tags));
        foreach ($stringTag  as $tag) {
            array_push($tags, ['name' => $tag]);
        }

        $post->tags()->createMany($tags);

        Toastr::success('Post updated!', 'success');

        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (!Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }

        $post->delete();

        Toastr::success('Post deleted!', 'success');

        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $post
     * @return \Illuminate\Http\Response
     */
    public function likedUsers($post)
    {
        $post = Post::findOrFail($post);

        return view('admin.post.like-users', compact('post'));
    }
}
