<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;
use App\Http\Controllers\TheLoaiController;

Route::get('/', function () {
    return view('welcome');
});

//admin
Route::get('admin/dangnhap', 'UserController@getDangNhapAdmin');
Route::post('admin/dangnhap', 'UserController@postDangNhapAdmin');
Route::get('admin/dangxuat', 'UserController@adminDangXuat');

Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function () {
    //theloai
    Route::group(['prefix' => 'theloai'], function () {
        Route::get('danhsach', 'TheLoaiController@getDanhSach');

        Route::get('them', 'TheLoaiController@getThem');
        Route::post('them', 'TheLoaiController@postThem');

        Route::get('sua/{id}', 'TheLoaiController@getSua');
        Route::post('sua/{id}', 'TheLoaiController@postSua');

        Route::get('xoa/{id}', 'TheLoaiController@getXoa');
    });

    //loaitin
    Route::group(['prefix' => 'loaitin'], function () {
        Route::get('danhsach', 'LoaiTinController@getDanhSach');

        Route::get('them', 'LoaiTinController@getThem');
        Route::post('them', 'LoaiTinController@postThem');

        Route::get('sua/{id}', 'LoaiTinController@getSua');
        Route::post('sua/{id}', 'LoaiTinController@postSua');

        Route::get('xoa/{id}', 'TheLoaiController@getXoa');
    });
    Route::group(['prefix' => 'tintuc'], function () {
        Route::get('danhsach', 'tintucController@getDanhSach');

        Route::get('sua/{id}', 'tintucController@getSua');
        Route::post('sua/{id}', 'tintucController@postSua');

        Route::get('them', 'tintucController@getThem');
        Route::post('them', 'tintucController@postThem');

        Route::get('xoa/{id}', 'tintucController@getXoa');
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::get('xoa/{id}/{idTinTuc}', 'CommentController@getXoa');
    });

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
    });

    Route::group(['prefix' => 'slide'], function () {
        Route::get('danhsach', 'SlideController@getDanhSach');

        Route::get('sua/{id}', 'SlideController@getSua');
        Route::post('sua/{id}', 'SlideController@postSua');

        Route::get('them', 'SlideController@getThem');
        Route::post('them', 'SlideController@postThem');

        Route::get('xoa/{id}', 'SlideController@getXoa');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('danhsach', 'UserController@getDanhSach');

        Route::get('sua/{id}', 'UserController@getSua');
        Route::post('sua/{id}', 'UserController@postSua');

        Route::get('them', 'UserController@getThem');
        Route::post('them', 'UserController@postThem');

        Route::get('xoa/{id}', 'UserController@getXoa');
    });
});

//front
Route::get('trangchu', 'PageController@trangchu');
Route::get('lienhe', 'PageController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html', 'PageController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html', 'PageController@tintuc');
Route::get('dangnhap', 'PageController@getDangNhap');
Route::post('dangnhap', 'PageController@postDangNhap');
Route::get('dangky', 'PageController@getDangKy');
Route::post('dangky', 'PageController@postDangKy');
Route::get('dangxuat', 'PageController@dangxuat');
Route::post('comment/{id}', 'CommentController@postComment');
Route::get('profile', 'PageController@getProfile');
Route::post('profile', 'PageController@postProfile');

Route::get('timkiem', function () {
    return back();
});
Route::post('timkiem', 'PageController@timKiem');
