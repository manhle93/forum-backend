<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\BinhLuan;
use App\Http\Resources\BinhLuanCollection;
use App\Http\Resources\BinhLuanResource;
use App\Like;
use App\Notifications\BinhLuanNotification;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Events\LikeEvent;
use App\Events\NotifyEvent;
use App\ThongBao;

class BinhLuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getBinhLuan']]);
    }

    public function index()
    {
        //
    }
    public function getBinhLuan($id)
    {
        $user = auth()->user();
        $liked = false;
        $binhLuan = BinhLuan::where('bai_viet_id', $id)->with('user')->orderBy('created_at', 'DESC')->get();
        foreach ($binhLuan as $bl) {
            $likeCount = Like::where('reference_id', $bl->id)->where('type', 'binh_luan')->count();
            $bl['like_count'] = $likeCount;
            if ($user) {
                $liked = !!Like::where('reference_id', $bl->id)->where('type', 'binh_luan')->where('user_id', $user->id)->count();
                $bl['liked'] = $liked;
            } else {
                $bl['liked'] = false;
            }
        }
        return response($binhLuan, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'noi_dung'  => 'required',
            'bai_viet_id' => 'required',
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
        $baiViet = BaiViet::find($data['bai_viet_id']);
        if (!$baiViet) {
            return response(['message' => 'Bài viết không tồn tại'], 500);
        }
        $userBaiViet = User::find($baiViet->user_id);
        try {
            $binhLuan =  BinhLuan::create([
                'noi_dung' => $data['noi_dung'],
                'bai_viet_id' => $data['bai_viet_id'],
                'user_id' => $user->id,
            ]);
            if ($user->id != $baiViet->user_id) {
                ThongBao::create([
                    'type' => 'bai_viet',
                    'reference_id' => $data['bai_viet_id'],
                    'user_id_nhan_thong_bao' => $baiViet->user_id,
                    'noi_dung' => 'Đã bình luận về bài viết của bạn',
                    'user_id_tuong_tac' => $user->id
                ]);
                broadcast(new NotifyEvent($userBaiViet->id, 'thong_bao', $user->name)); // thông báo bình luận realtime
            }
            broadcast(new LikeEvent($binhLuan->id, 'binh_luan'))->toOthers(); //hiển thị bình luận realtime
            return response(['message' => 'Đăng bình luận thành công'], 200);
        } catch (\Exception $e) {
            return response($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BinhLuan  $binhLuan
     * @return \Illuminate\Http\Response
     */
    public function show(BinhLuan $binhLuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BinhLuan  $binhLuan
     * @return \Illuminate\Http\Response
     */
    public function edit(BinhLuan $binhLuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BinhLuan  $binhLuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BinhLuan $binhLuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BinhLuan  $binhLuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $binhLuan = BinhLuan::find($id);
        if (!$binhLuan) {
            return response(['message' => 'Bình luận không tồn tại'], 500);
        }
        if ($user->id !== $binhLuan->user_id && $user->quyen_id != 2) {
            return response(['message' => 'Không thể xóa bình luận này'], 500);
        }
        broadcast(new LikeEvent($id, 'binh_luan'))->toOthers();
        $binhLuan->delete();
        return response(['message' => 'Xóa thành công'], 200);
    }
}
