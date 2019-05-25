<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends Controller
{
    //
    public function getDanhSach()
    {
        $slide = Slide::all();
        return view('admin.slide.danhsach', ['slide' => $slide]);
    }

    public function getThem()
    {
        return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate(
            $request,
            [
                'Ten' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'Ten.required' => 'Ban chua nhap Ten Slide',
                'NoiDung.required' => 'Ban chua nhap Noi Dung Slide'
            ]
        );

        $slide = new Slide();
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if ($request->has('link'))
            $slide->link = $request->link;

        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');

            // $duoi = $file->getClientOriginalExtension(); //lấy đuôi ảnh
            // if ($duoi != 'jpg' || $duoi != 'png' || $duoi != 'jpeg') {
            //     return redirect('admin/slide/them')->with('loi', 'ban chi duoc them anh co duoi la png, jpg, jpeg');
            // }

            $name = $file->getClientOriginalName(); //lấy tên gốc của hình
            $Hinh = str_random(4) . "_" . $name; //tạo tên ảnh random để tránh bị trùng
            while (file_exists("upload/images/slide" . $Hinh)) { //tạo lặp tránh vấn bị trùng khi random xong 
                $Hinh = str_random(4) . "_" . $name;
            }
            $file->move("upload/images/slide", $Hinh);
            $slide->Hinh = $Hinh;
        } else {
            $slide->Hinh = "";
        }

        $slide->save();
        return redirect('admin/slide/them')->with('thongbao', 'them slide thanh cong');
    }

    public function getSua($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.sua', ['slide' => $slide]);
    }

    public function postSua(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'Ten' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'Ten.required' => 'Ban chua nhap Ten Slide',
                'NoiDung.required' => 'Ban chua nhap Noi Dung Slide'
            ]
        );

        $slide = Slide::find($id);
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if ($request->has('link'))
            $slide->link = $request->link;

        if ($request->hasFile('Hinh')) {
            $file = $request->file('Hinh');

            // $duoi = $file->getClientOriginalExtension(); //lấy đuôi ảnh
            // if ($duoi != 'jpg' || $duoi != 'png' || $duoi != 'jpeg') {
            //     return redirect('admin/slide/them')->with('loi', 'ban chi duoc them anh co duoi la png, jpg, jpeg');
            // }

            $name = $file->getClientOriginalName(); //lấy tên gốc của hình
            $Hinh = str_random(4) . "_" . $name; //tạo tên ảnh random để tránh bị trùng
            while (file_exists("upload/images/slide" . $Hinh)) { //tạo lặp tránh vấn bị trùng khi random xong 
                $Hinh = str_random(4) . "_" . $name;
            }
            unlink("upload/images/slide/" . $slide->Hinh);
            $file->move("upload/images/slide", $Hinh);
            $slide->Hinh = $Hinh;
        }

        $slide->save();
        return redirect('admin/slide/sua/' . $id)->with('thongbao', 'sua slide thanh cong');
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao', 'xoa slide thanh cong');
    }
}
