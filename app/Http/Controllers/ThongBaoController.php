<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThongBaoController extends Controller
{
    public function getThongBao()
    {
        if (!auth()->user()) {
            return [
                'daDoc' => [],
                'chuaDoc' => [],
            ];
        }
        return [
            'daDoc' => auth()->user()->readNotifications()->get(),
            'chuaDoc' => auth()->user()->unreadNotifications()->get(),
        ];
    }
    public function docThongBao(Request $request)
    {
        try {
            auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();
            return response(['message' => 'Thành công'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Lỗi', 'data' => $e]);
        }
    }
}
