<?php

namespace App\Http\Controllers;

use App\ThongBao;
use Illuminate\Http\Request;

class ThongBaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => []]);
    }
    public function getThongBao()
    {
        if (!auth()->user()) {
            return [
                'daDoc' => [],
                'chuaDoc' => [],
            ];
        }
       $daDoc = ThongBao::with('userTuongTac')->where('da_doc', true)->where('user_id_nhan_thong_bao', auth()->user()->id)->get();
       $chuaDoc = ThongBao::with('userTuongTac')->where('da_doc', false)->where('user_id_nhan_thong_bao', auth()->user()->id)->get();
        return [
            'daDoc' => $daDoc,
            'chuaDoc' => $chuaDoc
        ];
    }
    public function docThongBao(Request $request)
    {
        $thong_bao_id = $request->get('thong_bao_id');
        $user = auth()->user();
        $thongBao = ThongBao::where('id', $thong_bao_id)->first();
        if($user->id == $thongBao->user_id_nhan_thong_bao){
            $thongBao->update(['da_doc'=>   true]);
            return response(['message' => "Thành công"],200);
        }
        return response(['message' => "Thất bại"],500);
    }
}
