<?php

namespace App\Http\Controllers;

use App\CommentReply;
use App\Http\Requests\CommentReplyRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CommentReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentReplyRequest $request, $comment)
    {
        $commentReply = new CommentReply();
        $commentReply->comment_id = $comment;
        $commentReply->user_id = Auth::id();
        $commentReply->message = $request->message;

        $commentReply->save();

        //Success message
        Toastr::success('The reply created successfully!', 'Success');

        return redirect()->back();
    }
}
