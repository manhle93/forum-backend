<?php

namespace App\Http\Controllers;

use App\BaiViet;
use Illuminate\Http\Request;
use Validator;

class BaiVietController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['show', 'baiVietTrangChu']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BaiViet::latest()->get();
    }

    public function baiVietTrangChu(){
        $hoiDap = BaiViet::with('user')->where('loai', 'hoi_dap')->orderBy('created_at', "DESC")->take(3)->get();
        $baiViet = BaiViet::with('user')->where('loai', 'bai_viet')->orderBy('created_at', "DESC")->take(7)->get();
        return response(['hoiDap' => $hoiDap, 'baiViet' => $baiViet],200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    public function test(){
        dd(auth()->user());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(444);
        $data = $request->all();
        $user = auth()->user();
        $validator = Validator::make($data, [
            'tieu_de' => 'required',
            'noi_dung'  => 'required',
            'chu_de_id' => 'required'

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
        try{
            BaiViet::created([
                'tieu_de' => $data['tieu_de'],
                'noi_dung' => $data['noi_dung'],
                'chu_de_id' => $data['chu_de_id'],
                'user_id' => $user->id,
                'loai' => $data['loai']
            ]);
            return response(['message'=> 'Thành công'],200);
        }
        catch(\Exception $e){
            return response(['data'=> $e ],200);
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
       $baiViet =  BaiViet::with('user', 'binhLuans', 'chuDe')->find($id);
       return $baiViet;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function edit(BaiViet $baiViet)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaiViet $baiViet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BaiViet  $baiViet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BaiViet::find($id)->delete();
        return response(['message' => "Xóa bài viết thành công"], 200);
    }
}
