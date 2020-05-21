<?php

namespace App\Http\Controllers;

use App\BaiViet;
use Illuminate\Http\Request;

class BaiVietController extends Controller
{
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
        //
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
