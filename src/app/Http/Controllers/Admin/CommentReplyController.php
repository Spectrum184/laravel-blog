<?php

namespace App\Http\Controllers\Admin;

use App\CommentReply;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commentReplies = CommentReply::all();

        return view('admin.comment-replies.index', compact('commentReplies'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commentReply = CommentReply::findOrFail($id);
        $commentReply->delete();

        Toastr::success('Deleted!', 'Success');
        return redirect()->back();
    }
}
