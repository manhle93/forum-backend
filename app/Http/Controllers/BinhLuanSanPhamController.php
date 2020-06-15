<?php

namespace App\Http\Controllers;

use App\BinhLuanSanPham;
use App\Events\NotifyEvent;
use App\SanPham;
use App\User;
use Illuminate\Http\Request;
use Validator;

class BinhLuanSanPhamController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'noi_dung'  => 'required',
            'san_pham_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => __('Thiếu thông tin'),
                'data' => [
                    $validator->errors()->all(),
                ],
            ], 400);
        }
        $sanPham = SanPham::find($data['san_pham_id']);
        if(!$sanPham){
            return response(['message' => 'Sản phẩm không tồn tại'],500);
        }
        $userSanPham = User::find($sanPham->user_id);
        try {
           $binhLuan =  BinhLuanSanPham::create([
                'noi_dung' => $data['noi_dung'],
                'san_pham_id' => $data['san_pham_id'],
                'user_id' => $user->id,
            ]);
            // $userBaiViet->notify(new BinhLuanNotification($binhLuan));
            // broadcast(new NotifyEvent ($userSanPham->id, 'thong_bao', $user->name));
            return response(['message' => 'Đăng bình luận thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    public function index($id){
        $binhLuan = BinhLuanSanPham::where('san_pham_id', $id)->with('user')->orderBy('created_at', 'DESC')->get();
        return response($binhLuan, 200);
    }

    public function xoaBinhLuan($id){
        $user = auth()->user();
        $binhLuan = BinhLuanSanPham::find($id);
        if (!$binhLuan) {
            return response(['message' => 'Bình luận không tồn tại'], 500);
        }
        if ($user->id !== $binhLuan->user_id && $user->quyen_id != 2) {
            return response(['message' => 'Không thể xóa bình luận này'], 500);
        }
        $binhLuan->delete();
        return response(['message' => 'Xóa thành công'], 200);
    }

}
