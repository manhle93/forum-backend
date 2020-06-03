<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        if (!$user) {
            return;
        }
        try {
            Like::create([
                'user_id' => $user->id,
                'type' => $data['type'],
                'reference_id' => $data['reference_id']
            ]);
            broadcast(new LikeEvent($data['reference_id'], $data['type']))->toOthers();
            return response(['message' => 'Thành công'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Lỗi', 'data' => $e], 500);
        }
    }

    public function unLike(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        if (!$user) {
            return;
        }
        try {
            Like::where('user_id', $user->id)->where('type', $data['type'])->where('reference_id', $data['reference_id'])->delete();
            broadcast(new LikeEvent($data['reference_id'], $data['type']))->toOthers();
            return response(['message' => 'Thành công'], 200);
        } catch (\Exception $e) {
            return response(['message' => 'Lỗi', 'data' => $e], 500);
        }
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
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
