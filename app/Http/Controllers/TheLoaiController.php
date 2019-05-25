<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach()
    {
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach', ['theloai' => $theloai]);
    }

    public function getThem()
    {
        return view('admin.theloai.them');
    }

    public function postThem(Request $request)
    {
        $this->validate(
            $request,
            [
                'Ten' => 'required|min:3|max:100',
                'Ten' => 'unique:theloai,Ten'
            ],
            [
                'Ten.required' => 'Ban chua nhap ten the loai!',
                'Ten.min' => 'Ten the loai phai hon 3 ky tu.',
                'Ten.max' => 'Ten the loai khong vuot qua 100 ky tu.',
                'Ten.unique' => 'Ten danh muc da ton tai.'
            ]
        );

        $theloai = new TheLoai();
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = str_slug($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao', 'them thanh cong');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua', ['theloai' => $theloai]);
    }

    public function postSua(Request $request, $id)
    {
        $theloai = TheLoai::find($id);
        $this->validate(
            $request,
            [
                'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên thể loại',
                'Ten.uinique' => 'Tên thể loại đã trùng',
                'Ten.min' => 'Ten the loai phai hon 3 ky tu.',
                'Ten.max' => 'Ten the loai khong vuot qua 100 ky tu.'
            ]
        );
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = str_slug($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/' . $id)->with('thongbao', 'sua thanh cong');
    }

    public function getXoa($id)
    {
        $theloai = TheLoai::find($id);
        $theloai->delete();
        return back()->with('thongbao', 'xoa thanh cong');
    }
}
