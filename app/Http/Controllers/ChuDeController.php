<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\ChuDe;
use Illuminate\Http\Request;
use Validator;

class ChuDeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show', 'getBaiVietChuDe', 'getCauHoiChuDe']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage', 6);
        $query = ChuDe::query();
        $chuDe = $query->orderBy('updated_at', 'DESC')->paginate($perPage, ['*'], 'page', $page);
        foreach($chuDe as $it){
            $soBaiViet = BaiViet::where('chu_de_id', $it->id)->count();
            $it['so_bai_viet'] = $soBaiViet;
        }
        return response(['data' => $chuDe], 200);
    }

    public function getBaiVietChuDe(Request $request, $id){
        $page = $request->get('page');
        $perPage = $request->get('perPage', 6);
        $baiViet = BaiViet::with('user')->where('chu_de_id', $id)->where('loai', 'bai_viet')->with('user')->orderBy('updated_at', 'DESC')->paginate($perPage, ['*'], 'page', $page);
        return response(['data' => $baiViet], 200);
    }

    public function getCauHoiChuDe(Request $request, $id){
        $page = $request->get('page');
        $perPage = $request->get('perPage', 6);
        $baiViet = BaiViet::where('chu_de_id', $id)->where('loai', 'hoi_dap')->with('user')->orderBy('updated_at', 'DESC')->paginate($perPage, ['*'], 'page', $page);
        return response(['data' => $baiViet], 200);
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
            'ten' => 'required',

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
            ChuDe::create([
                'ten' => $data['ten'],
                'mo_ta' => $data['mo_ta'],
                'anh_dai_dien' => $data['anh_dai_dien'],
                'user_id' => $user->id,
            ]);
            return response(['message' => 'Thêm chủ đề thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChuDe  $chuDe
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chuDe = ChuDe::with('user')->find($id);
        $soBaiViet = BaiViet::where('chu_de_id', $id)->where('loai', 'bai_viet')->count();
        $soCauHoi = BaiViet::where('chu_de_id', $id)->where('loai', 'hoi_dap')->count();
        $chuDe['so_bai_viet'] = $soBaiViet;
        $chuDe['so_cau_hoi'] = $soCauHoi;
        return $chuDe;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChuDe  $chuDe
     * @return \Illuminate\Http\Response
     */
    public function edit(ChuDe $chuDe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChuDe  $chuDe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'ten' => 'required',

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
            ChuDe::where('id', $id)->first()->update([
                'ten' => $data['ten'],
                'mo_ta' => $data['mo_ta'],
                'anh_dai_dien' => $data['anh_dai_dien'],
                'user_id' => $user->id,
            ]);
            return response(['message' => 'Cập nhật chủ đề thành công'], 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChuDe  $chuDe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            BaiViet::where('chu_de_id', $id)->delete();
            ChuDe::find($id)->delete();
            return response(['message' => 'Thành công'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Không thể xóa', 'data' => $e], 500);
        }
    }
}
