<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function getXoa($id, $idTinTuc)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('admin/tintuc/sua/' . $idTinTuc)->with('thongbao', 'xoa comment thanh cong');
    }

    public function postComment($id, Request $request)
    {
        $idTinTuc = $id;
        $comment = new Comment();
        $comment->idTinTuc = $idTinTuc;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();
        return back()->with('thongbao', 'binh luan thanh cong');
    }
}
