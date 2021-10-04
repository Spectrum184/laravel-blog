<?php

namespace App\Http\Controllers\User;

use App\CommentReply;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commentReplies = CommentReply::where('user_id', Auth::id())->latest()->get();

        return view('user.comment-replies.index', compact('commentReplies'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = CommentReply::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();

            Toastr::success('Deleted!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('You can not delete this comment!', 'Error');
            return redirect()->back();
        }
    }
}
