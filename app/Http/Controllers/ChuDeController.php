<?php

namespace App\Http\Controllers;

use App\ChuDe;
use Illuminate\Http\Request;
use Validator;

class ChuDeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
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
        $chuDe = $query->paginate($perPage, ['*'], 'page', $page);
        return response(['data' => $chuDe], 200);
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
        return ChuDe::find($id);
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
    public function update(Request $request, ChuDe $chuDe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChuDe  $chuDe
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChuDe $chuDe)
    {
        //
    }
}
