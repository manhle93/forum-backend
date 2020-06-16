<?php

namespace App\Http\Controllers;

use App\DonHang;
use App\SanPham;
use Illuminate\Http\Request;
use Validator;

class DonHangController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getSanPham', 'getChiTietSanPham']]);
    }

    public function datHang(Request $request)
    {

        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
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
        $sanpham = SanPham::find($data['san_pham_id']);
        if ($user->id == $sanpham->user_id) {
            return response(['message' => 'Không thể đặt hàng của chính mình'], 500);
        }
        try {
            DonHang::create([
                'san_pham_id' => $data['san_pham_id'],
                'user_mua_hang_id' => $user->id,
                'so_dien_thoai' => $data['so_dien_thoai'],
                'so_luong' => $data['so_luong'],
                'tong_tien' => $data['tong_tien'],
                'ten_nguoi_mua' => $data['ten_nguoi_mua'],
                'dia_chi' => $data['dia_chi'],
                'trang_thai' => 'moi_tao'
            ]);
            return response(['message' => 'Tạo đơn hàng thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    public function getDonBanHangCaNhan()
    {
        $user = auth()->user();
        $query =  DonHang::with('sanPham.user');
        $query->whereHas('sanPham.user', function ($query) use ($user) {
            $query->where('id', $user->id);
        });
        $data = $query->orderBy('updated_at', 'DESC')->get();
        return response($data, 200);
    }
    public function huyDonBan($id)
    {
        $user = auth()->user();
        $donHang = DonHang::with('sanPham.user')->where('id', $id)->first();
        if ($user->id == $donHang->sanPham->user->id) {
            $donHang->update([
                'trang_thai' => 'huy_bo'
            ]);
            return response(['message' => 'Đã hủy đơn hàng'], 200);
        } else {
            return response(['message' => 'Không thể hủy đơn hàng'], 500);
        }
    }

    public function nhanDonBan($id)
    {
        $user = auth()->user();
        $donHang = DonHang::with('sanPham.user')->where('id', $id)->first();
        if ($user->id == $donHang->sanPham->user->id) {
            $donHang->update([
                'trang_thai' => 'nhan_don'
            ]);
            return response(['message' => 'Đã nhận đơn hàng'], 200);
        } else {
            return response(['message' => 'Không thể nhận đơn hàng'], 500);
        }
    }

    public function hoanThanhDon($id)
    {
        $user = auth()->user();
        $donHang = DonHang::with('sanPham.user')->where('id', $id)->first();
        if ($user->id == $donHang->sanPham->user->id) {
            $donHang->update([
                'trang_thai' => 'hoan_thanh'
            ]);
            return response(['message' => 'Đã hoàn thành đơn hàng'], 200);
        } else {
            return response(['message' => 'Không thể hoàn thành đơn hàng'], 500);
        }
    }


    public function getDonMuaHangCaNhan(){
        $user = auth()->user();
        $donHang = DonHang::with('sanPham')->where('user_mua_hang_id', $user->id)->get();
        return response($donHang, 200);
    }
    public function huyDonMuaHang($id){
        $user = auth()->user();

        $donHang = DonHang::where('id', $id)->first();
        if ($user->id == $donHang->user_mua_hang_id) {
            $donHang->update([
                'trang_thai' => 'khach_huy'
            ]);
            return response(['message' => 'Đã hủy đơn hàng'], 200);
        } else {
            return response(['message' => 'Không thể hủy đơn hàng'], 500);
        }
    }
}
