<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\Quyen;
use App\TinNhan;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Events\TinNhanEvent;
use App\SanPham;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getBinhLuan', 'getUserInfor', 'getBaiVietProfile', 'getSanPhamProfile']]);
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
            broadcast(new TinNhanEvent($data['user_nhan_id'], $user->id))->toOthers();
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
}
