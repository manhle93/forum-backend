<?php

namespace App\Http\Controllers;

use App\BinhLuan;
use App\Http\Resources\BinhLuanCollection;
use App\Http\Resources\BinhLuanResource;
use Illuminate\Http\Request;
use Validator;

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
    public function getBinhLuan($id){
        $binhLuan = BinhLuan::where('bai_viet_id', $id)->with('user')->orderBy('created_at', 'DESC')->get();
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
            'bai_viet_id'=> 'required',
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
            BinhLuan::create([
                'noi_dung' => $data['noi_dung'],
                'bai_viet_id' => $data['bai_viet_id'],
                'user_id' => $user->id,
            ]);
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
        if(!$binhLuan){
            return response(['message' => 'Bình luận không tồn tại'],500);
        }
        if($user->id !== $binhLuan->user_id){
            return response(['message' => 'Không thể xóa bình luận này'],500);
        }
        $binhLuan->delete();
        return response(['message' => 'Xóa thành công'],200);
    }
}
