<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\Events\NotifyEvent;
use App\Quyen;
use App\TinNhan;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Events\TinNhanEvent;
use App\SanPham;
use App\ThongBao;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getBinhLuan', 'getUserInfor', 'getBaiVietProfile', 'getSanPhamProfile', 'timKiem']]);
    }

    public function trangCaNhan()
    {
        $user = auth()->user();
        $info = User::with('quyen')->where('id', $user->id)->first();
        $soBaiViet = BaiViet::where('user_id', $user->id)->count();
        $info['so_bai_viet'] = $soBaiViet;
        return response($info, 200);
    }

    public function uploadAnh(Request $request)
    {
        if ($request->file) {
            $image = $request->file;
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/images/avatar/', $name);
            $user = User::find(auth()->user()->id);
            $user->update(['anh_dai_dien' => 'storage/images/avatar/' . $name]);
            return 'storage/images/avatar/' . $name;
        }
    }

    public function getBaiViet()
    {
        $user = auth()->user();
        $baiViet = BaiViet::where('user_id', $user->id)->get();
        return response($baiViet, 200);
    }

    public function getAllUser()
    {

        $user = User::with('quyen')->where('id', '<>', auth()->user()->id)->get();
        return response($user, 200);
    }
    public function getAllQuyen()
    {
        $quyen = Quyen::get();
        return response($quyen, 200);
    }
    public function doiQuyen($id, Request $request)
    {
        $user = auth()->user();


        if ($user->quyen_id == 1) {
            return response(['message' => "Bạn không phải admin"], 500);
        }
        User::where('id', $id)->update([
            'quyen_id' => $request->quyen_id
        ]);
        return response(['message' => 'Thanh cong'], 200);
    }

    public function nhanTin(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'noi_dung'  => 'required',
            'user_nhan_id' => 'required',
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
        try {
            TinNhan::create([
                'user_gui_id' => $user->id,
                'user_nhan_id' => $data['user_nhan_id'],
                'noi_dung' => $data['noi_dung']
            ]);
            ThongBao::create([
                'type' => 'tin_nhan',
                'reference_id' => $user->id,
                'user_id_nhan_thong_bao' => $data['user_nhan_id'],
                'noi_dung' => 'Đã nhắn tin cho bạn',
                'user_id_tuong_tac' => $user->id
            ]);
            broadcast(new TinNhanEvent($data['user_nhan_id'], $user->id))->toOthers();
            broadcast(new NotifyEvent($data['user_nhan_id'], 'thong_bao', $user->name));

        } catch (\Exception $e) {
            return response(['message' => 'Lỗi'], 500);
        }
    }
    public function getTinNhan($id)
    {
        $user = auth()->user();
        $tinNhan = TinNhan::whereIn('user_nhan_id', [$user->id, $id])->whereIn('user_gui_id', [$user->id, $id])->get();
        return response($tinNhan, 200);
    }

    public function getUserInfor($id)
    {
        $user = User::with('quyen')->where('id', $id)->first();
        $soBaiViet = BaiViet::where('user_id', $id)->count();
        $user['so_bai_viet'] = $soBaiViet;
        return response($user, 200);
    }

    public function getBaiVietProfile($id)
    {
        $baiViet = BaiViet::where('user_id', $id)->get();
        return response($baiViet, 200);
    }
    public function getSanPhamProfile($id)
    {
        $sanPham = SanPham::where('user_id', $id)->get();
        return response($sanPham, 200);
    }

    public function timKiem(Request $request)
    {
        $search = $request->get('search');
        $sanPham = SanPham::where('ten_san_pham', 'ilike', "%{$search}%")->orWhere('mo_ta', 'ilike', "%{$search}%")->get();
        $baiViet = BaiViet::with('user')->where('tieu_de', 'ilike', "%{$search}%")->orWhere('noi_dung', 'ilike', "%{$search}%")->get();
        $user = User::with('quyen')->where('name', 'ilike', "%{$search}%")->orWhere('email', 'ilike', "%{$search}%")->get();
        return response(['san_pham' => $sanPham, 'bai_viet' => $baiViet, 'user' => $user], 200);
    }
}
