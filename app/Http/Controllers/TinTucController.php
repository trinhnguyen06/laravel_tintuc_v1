<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller
{
    public function getDanhSach()
    {
        $tintuc = TinTuc::orderBy('id', 'DESC')->get();
        return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postThem(Request $request)
    {
        $this->validate(
            $request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Ban chua chon loai tin',
                'TieuDe.required' => 'Ban chua nhap tieu de',
                'TieuDe.min' => 'Tieu de lon hon 3 ky tu',
                'TieuDe.unique' => 'Tieu de da ton tai',
                'TomTat.required' => 'Ban chua nhap tom tat',
                'NoiDung.required' => 'Ban chua nhap noi dung.'
            ]
        );

        $tintuc = new TinTuc();
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = str_slug($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;
        $tintuc->NoiBat = $request->NoiBat;
        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');

            // $duoi = $file->getClientOriginalExtension(); //lấy đuôi ảnh
            // if ($duoi != 'jpg' || $duoi != 'png' || $duoi != 'jpeg') {
            //     return redirect('admin/tintuc/them')->with('loi', 'ban chi duoc them anh co duoi la png, jpg, jpeg');
            // }

            $name = $file->getClientOriginalName(); //lấy tên gốc của hình
            $Hinh = str_random(4) . "_" . $name; //tạo tên ảnh random để tránh bị trùng
            while (file_exists("upload/images/tin-tuc" . $Hinh)) { //tạo lặp tránh vấn bị trùng khi random xong 
                $Hinh = str_random(4) . "_" . $name;
            }
            $file->move("upload/images/tin-tuc", $Hinh);
            $tintuc->Hinh = $Hinh;
        } else {
            $tintuc->Hinh = "";
        }

        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao', 'ban da them tin tuc thanh cong');
    }

    public function getSua($id)
    {
        $tintuc = TinTuc::find($id);
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.sua', ['tintuc' => $tintuc, 'theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postSua(Request $request, $id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate(
            $request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Ban chua chon loai tin',
                'TieuDe.required' => 'Ban chua nhap tieu de',
                'TieuDe.min' => 'Tieu de lon hon 3 ky tu',
                'TieuDe.unique' => 'Tieu de da ton tai',
                'TomTat.required' => 'Ban chua nhap tom tat',
                'NoiDung.required' => 'Ban chua nhap noi dung.'
            ]
        );
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = str_slug($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');

            // $duoi = $file->getClientOriginalExtension(); //lấy đuôi ảnh
            // if ($duoi != 'jpg' || $duoi != 'png' || $duoi != 'jpeg') {
            //     return redirect('admin/tintuc/them')->with('loi', 'ban chi duoc them anh co duoi la png, jpg, jpeg');
            // }

            $name = $file->getClientOriginalName(); //lấy tên gốc của hình
            $Hinh = str_random(4) . "_" . $name; //tạo tên ảnh random để tránh bị trùng
            while (file_exists("upload/images/tin-tuc" . $Hinh)) { //tạo lặp tránh vấn bị trùng khi random xong 
                $Hinh = str_random(4) . "_" . $name;
            }
            $file->move("upload/images/tin-tuc", $Hinh);
            unlink("upload/images/tin-tuc/" . $tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }

        $tintuc->save();

        return redirect('admin/tintuc/sua/' . $id)->with('thongbao', 'sua thanh cong');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao', 'xoa thanh cong');
    }
}
