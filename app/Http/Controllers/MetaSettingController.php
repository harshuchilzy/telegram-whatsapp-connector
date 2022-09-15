<?php

namespace App\Http\Controllers;

use App\Models\MetaSetting;
use Illuminate\Http\Request;

class MetaSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia()->render('Settings/Settings');
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
     * @param  \App\Models\MetaSetting  $metaSetting
     * @return \Illuminate\Http\Response
     */
    public function show(MetaSetting $metaSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MetaSetting  $metaSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(MetaSetting $metaSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MetaSetting  $metaSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MetaSetting $metaSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MetaSetting  $metaSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(MetaSetting $metaSetting)
    {
        //
    }
}