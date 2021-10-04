<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $post)
    {
        $comment = new Comment();
        $comment->post_id = $post;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;

        $comment->save();

        //Success message
        Toastr::success('The comment created successfully!', 'Success');

        return redirect()->back();
    }
}
