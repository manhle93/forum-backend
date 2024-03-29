<?php

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('dangky', 'AuthController@dangKy');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::apiResource('/baiviet', 'BaiVietController');
Route::apiResource('/chude', 'ChuDeController');
Route::get('/baivietchude/{id}', 'ChuDeController@getBaiVietChuDe');
Route::get('/cauhoichude/{id}', 'ChuDeController@getCauHoiChuDe');


Route::get('/baiviettrangchu', 'BaiVietController@baiVietTrangChu');
Route::get('/cauhoitrangchu', 'BaiVietController@cauhoiTrangChu');

Route::post('/uploadanh', 'BaiVietController@uploadAnh');

Route::get('/binhluan/{id}', 'BinhLuanController@getBinhLuan');
Route::post('/binhluan', 'BinhLuanController@store');
Route::delete('/binhluan/{id}', 'BinhLuanController@destroy');

Route::post('/like', 'LikeController@like');
Route::post('/unlike', 'LikeController@unLike');

Route::get('thongbao', 'ThongBaoController@getThongBao');
Route::post('docthongbao', 'ThongBaoController@docThongBao');
Route::get('userinfo', 'UserController@trangCaNhan');


Route::post('uploadavatar', 'UserController@uploadAnh');
Route::get('baivietuser', 'UserController@getBaiViet');
Route::get('alluser', 'UserController@getAllUser');
Route::get('allquyen', 'UserController@getAllQuyen');
Route::post('doiquyen/{id}', 'UserController@doiQuyen');

Route::get('gettinnhan/{id}', 'UserController@getTinNhan');
Route::post('guitin', 'UserController@nhanTin');
Route::get('userinfo/{id}', 'UserController@getUserInfor');
Route::get('baivietcanhan/{id}', 'UserController@getBaiVietProfile');
Route::get('sanphamcanhan/{id}', 'UserController@getSanPhamProfile');


Route::post('sanpham', 'SanPhamController@addSanPham');
Route::get('sanpham', 'SanPhamController@getSanPhamCaNhan');
Route::put('sanpham/{id}', 'SanPhamController@editSanPham');
Route::delete('sanpham/{id}', 'SanPhamController@xoaSanPham');
Route::get('sanpham/{id}', 'SanPhamController@getChiTietSanPham');
Route::get('danhsachsanpham', 'SanPhamController@getSanPham');



Route::get('binhluansanpham/{id}', 'BinhLuanSanPhamController@index');
Route::post('binhluansanpham', 'BinhLuanSanPhamController@store');
Route::delete('binhluansanpham/{id}', 'BinhLuanSanPhamController@xoaBinhLuan');

Route::post('dathang', 'DonHangController@datHang');

Route::get('banhangcanhan', 'DonHangController@getDonBanHangCaNhan');
Route::put('huydonhang/{id}', 'DonHangController@huyDonBan');
Route::put('nhandonhang/{id}', 'DonHangController@nhanDonBan');
Route::put('hoanthanhdonhang/{id}', 'DonHangController@hoanThanhDon');

Route::get('donmuahang', 'DonHangController@getDonMuaHangCaNhan');
Route::put('huydonmuahang/{id}', 'DonHangController@huyDonMuaHang');

Route::get('timkiem', 'UserController@timKiem');




