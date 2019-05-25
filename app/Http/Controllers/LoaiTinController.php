<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    //
    public function getDanhSach()
    {
        $loaitin = LoaiTin::all();
        
        return view('admin.loaitin.danhsach', ['loaitin' => $loaitin]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        return view('admin.loaitin.them', ['theloai' => $theloai]);
    }

    public function postThem(Request $request)
    {
        $this->validate(
            $request,
            [
                'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100',
                'TheLoai' => 'required'
            ],
            [
                'Ten.required' => 'Ban chua nhap ten loai tin',
                'Ten.unique' => 'Ten loai tin da trung',
                'Ten.min' => 'Ten loai tin tu 3 den 100 ky tu',
                'Ten.max' => 'Ten loai tin tu 3 den 100 ky tu',
                'TheLoai.required' => "Ban chua chon The Loai"
            ]
        );
        $loaitin = new LoaiTin();
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = str_slug($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao', 'Ban da them thanh cong');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua', ['loaitin' => $loaitin, 'theloai' => $theloai]);
    }

    public function postSua(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'Ten' => 'required|min:3|max:100',

            ],
            [
                'Ten.required' => 'Ban chua nhap ten loai tin',
                'Ten.unique' => 'Ten loai tin da trung',
                'Ten.min' => 'Ten loai tin tu 3 den 100 ky tu',
                'Ten.max' => 'Ten loai tin tu 3 den 100 ky tu'
            ]
        );
        $loaitin = LoaiTin::find($id);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = str_slug($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/' . $id)->with('thongbao', 'ban da sua thanh cong');
    }

    public function getXoa($id)
    {
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao', 'xoa thanh cong');
    }
}
