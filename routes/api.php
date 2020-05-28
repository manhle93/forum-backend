<?php
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

Route::get('/baiviettrangchu', 'BaiVietController@baiVietTrangChu');
Route::post('/uploadanh', 'BaiVietController@uploadAnh');

Route::get('/binhluan/{id}', 'BinhLuanController@getBinhLuan');
Route::post('/binhluan', 'BinhLuanController@store');
Route::delete('/binhluan/{id}', 'BinhLuanController@destroy');

Route::post('/like', 'LikeController@like');
Route::post('/unlike', 'LikeController@unLike');
