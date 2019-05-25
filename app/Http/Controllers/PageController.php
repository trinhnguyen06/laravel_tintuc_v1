<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class PageController extends Controller
{
    //

    public function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai', $theloai);
        view()->share('slide', $slide);


        // if (Auth::check()) {
        //     view()->share('nguoidung', Auth::user());
        // } khongcan nua dung Auth()->name()
    }

    public function trangchu()
    {
        return view('pages.home');
    }

    public function lienhe()
    {
        $theloai = TheLoai::all();
        return view('pages.lienhe');
    }

    public function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
        return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
    }

    public function tintuc($id)
    {
        // DB::table('tintuc')->where('id', $id)->update(['SoLuotXem' => $tintuc->SoLuotXem+1]); 
        $tintuc = TinTuc::find($id);

        $noibat = TinTuc::where('NoiBat', 1)->take(4)->get();
        $lienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();

        return view('pages.tintuc', ['tintuc' => $tintuc, 'noibat' => $noibat, 'lienquan' => $lienquan]);
    }

    public function getDangNhap()
    {
        if (Auth::check()) {
            return redirect('trangchu')->with('thongbao', 'Ban da dang nhap roi!');
        } else
            return view('pages.dangnhap');
    }

    public function postDangNhap(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Ban chua nhap email',
                'password.required' => 'Ban chua nhap password'
            ]
        );

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('trangchu');
        } else {
            return redirect('dangnhap')->with('thongbao', 'dang nhap khong thanh cong');
        }
    }

    public function dangxuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }

    public function getProfile()
    {
        //   $user = Auth::user();
        if (Auth::check())
            return view('pages.profile');
        else
            return redirect('dangnhap')->with('thongbao', 'ban can dang nhap truoc');
    }

    public function postProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:3'
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
                'nam.min' => 'Ten nguoi dung phai it nhat 3 ky tu'
            ]
        );

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->changePassword == "on") {
            $this->validate(
                $request,
                [
                    'password' => 'required|min:6|max:32',
                    'passwordAgain' => 'required|same:password',
                ],
                [
                    'password.required' => 'Ban chua nhap Password',
                    'password.min' => 'Password phai tu 6 - 32 ky tu',
                    'password.max' => 'Password phai tu 6 - 32 ky tu',
                    'passwordAgain.required' => 'Ba chua nhap lai mat khau',
                    'passwordAgain.same' => 'Password khong trung'
                ]
            );
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect('profile')->with('thongbao', 'ban da sua thanh cong');
    }


    public function getDangKy()
    {
        return view('pages.dangky');
    }

    public function postDangKy(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:32',
                'passwordAgain' => 'required|same:password',
            ],
            [
                'name.required' => 'Ban chua nhap ten nguoi dung',
                'nam.min' => 'Ten nguoi dung phai it nhat 3 ky tu',
                'email.required' => 'Ban chua nhap email',
                'email.email' => 'Ban khong nhap dung dinh dang email',
                'email.unique' => 'Email da ton tai',
                'password.required' => 'Ban chua nhap Password',
                'password.min' => 'Password phai tu 6 - 32 ky tu',
                'password.max' => 'Password phai tu 6 - 32 ky tu',
                'passwordAgain.required' => 'Ba chua nhap lai mat khau',
                'passwordAgain.same' => 'Password khong trung'
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = 0;
        $user->save();

        return redirect('dangnhap')->with('thongbao', 'dang ky thanh cong, ban co the dang nhap');
    }

    public function timKiem(Request $request)
    {
        $keySearch = $request->keySearch;
        $tintuc = TinTuc::where('TieuDe', 'like', "%$keySearch%")
            ->orWhere('TomTat', 'like', "%$keySearch%")
            ->orWhere('NoiDung', 'like', "%$keySearch%")
            ->take(30)->paginate(5);
        return view('pages.timkiem', ['tintuc' => $tintuc, 'keySearch' => $keySearch]);
    }
}
