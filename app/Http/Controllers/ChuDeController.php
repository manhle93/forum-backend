<?php

namespace App\Http\Controllers;

use App\ChuDe;
use Illuminate\Http\Request;

class ChuDeController extends Controller
{
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
        //
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
