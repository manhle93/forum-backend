<?php

namespace App\Http\Controllers;

use App\BaiViet;
use Illuminate\Http\Request;
use App\Http\Resources\BaiVietResource;
use App\Like;
use Validator;

class BaiVietController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['show', 'baiVietTrangChu', 'cauhoiTrangChu']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BaiViet::latest()->get();
    }

    public function baiVietTrangChu(Request $request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage', 7);
        $baiViet = BaiViet::with('user')->where('loai', 'bai_viet')->orderBy('created_at', "DESC")->paginate($perPage, ['*'], 'page', $page);
        return response([ 'data' => $baiViet], 200);
    }

    public function cauhoiTrangChu(Request $request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage', 3);

        $hoiDap = BaiViet::with('user')->where('loai', 'hoi_dap')->orderBy('created_at', "DESC")->paginate($perPage, ['*'], 'page', $page);
        return response(['data' => $hoiDap], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'tieu_de' => 'required',
            'noi_dung'  => 'required',
            'chu_de_id' => 'required',
            'loai' => 'required'

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
            BaiViet::create([
                'tieu_de' => $data['tieu_de'],
                'noi_dung' => $data['noi_dung'],
                'chu_de_id' => $data['chu_de_id'],
                'user_id' => $user->id,
                'anh_dai_dien' => $data['anh_dai_dien'],
                'loai' => $data['loai']
            ]);
            return response(['message' => 'Đăng bài thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $liked = false;
        if($user){
            $liked = !! Like::where('reference_id', $id)->where('type', 'bai_viet')->where('user_id', $user->id)->count();
        }
        $likeCount = Like::where('reference_id', $id)->where('type', 'bai_viet')->count();
        $baiViet =  BaiViet::with('user', 'chuDe')->find($id);
        $baiViet['liked'] = $liked;
        $baiViet['like_count'] = $likeCount;
        return $baiViet;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'tieu_de' => 'required',
            'noi_dung'  => 'required',
            'chu_de_id' => 'required',
            'loai' => 'required'

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
            BaiViet::where('id', $id)->first()->update([
                'tieu_de' => $data['tieu_de'],
                'noi_dung' => $data['noi_dung'],
                'chu_de_id' => $data['chu_de_id'],
                'anh_dai_dien' => $data['anh_dai_dien'],
                'user_id' => $user->id,
                'loai' => $data['loai']
            ]);
            return response(['message' => 'Cập nhật thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user && (($user->id == BaiViet::find($id)->user_id) || $user->quyen_id == 2)) {
            BaiViet::find($id)->delete();
            return response(['message' => "Xóa bài viết thành công"], 200);
        } else return response(['message' => "Không thể xóa bài viết"], 400);
    }

    public function uploadAnh(Request $request)
    {
        if ($request->file) {
            $image = $request->file;
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/images/avatar/', $name);
            // $user = User::find(auth()->user()->id);
            // $user->update(['avatar_url' => 'storage/images/avatar/' . $name]);
            return 'storage/images/avatar/' . $name;
        }
    }
}
