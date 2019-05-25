<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; //thu vien dang nhap
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function getDanhSach()
    {
        $user = User::all();
        return view('admin.user.danhsach', ['user' => $user]);
    }

    public function getThem()
    {
        return view('admin.user.them');
    }

    public function postThem(Request $request)
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
        $user->level = $request->level;
        $user->save();

        return redirect('admin/user/them')->with('thongbao', 'them user thanh cong');
    }

    public function getSua($id)
    {
        $user = User::find($id);
        return view('admin.user.sua', ['user' => $user]);
    }

    public function postSua(Request $request, $id)
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

        $user = User::find($id);
        $user->name = $request->name;
        $user->level = $request->level;

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
        return redirect('admin/user/sua/' . $id)->with('thongbao', 'ban da sua user thanh cong');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Ban da xoa user thanh cong');
    }

    //login admin
    public function getDangNhapAdmin()
    {
        if (Auth::check()) {
            return back()->with('thongbao', 'Ban da dang nhap roi!');
        }
        return view('admin.login');
    }

    public function postDangNhapAdmin(Request $request)
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
            return redirect('admin/theloai/danhsach');
        } else {
            return redirect('admin/dangnhap')->with('thongbao', 'dang nhap khong thanh cong');
        }
    }

    public function adminDangXuat()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
