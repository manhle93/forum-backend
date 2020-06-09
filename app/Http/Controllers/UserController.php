<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getBinhLuan']]);
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
}
