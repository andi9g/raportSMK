<?php

namespace App\Http\Controllers;

use App\Models\raportM;
use App\Models\siswaM;
use App\Models\identitasM;
use Illuminate\Http\Request;

class homeC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = identitasM::where("posisi", "guru")->count();
        $walikelas = identitasM::where("posisi", "walikelas")->count();
        $siswa = siswaM::count();
        $raport = raportM::where("ket", 0)->count();

        return view("home", [
            "guru" => $guru,
            "walikelas" => $walikelas,
            "siswa" => $siswa,
            "raport" => $raport,
        ]);
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
     * @param  \App\Models\raportM  $raportM
     * @return \Illuminate\Http\Response
     */
    public function show(raportM $raportM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\raportM  $raportM
     * @return \Illuminate\Http\Response
     */
    public function edit(raportM $raportM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\raportM  $raportM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, raportM $raportM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\raportM  $raportM
     * @return \Illuminate\Http\Response
     */
    public function destroy(raportM $raportM)
    {
        //
    }
}
