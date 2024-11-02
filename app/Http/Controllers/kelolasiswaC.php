<?php

namespace App\Http\Controllers;

use App\Models\identitasM;
use App\Models\siswaM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kelolasiswaC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;
        $iduser = Auth::user()->iduser;
        $identitas = identitasM::where("iduser", $iduser)->first();
        $idkelas = $identitas->walikelas->idkelas;
        $idjurusan = $identitas->walikelas->idjurusan;

        $siswa = siswaM::where("idkelas", $idkelas)->where("idjurusan", $idjurusan)
        ->orderBy("nama", "asc")
        ->where("idjurusan", $idjurusan)
        ->where("idkelas", $idkelas)
        ->where("nama", "like", "%$keyword%")->paginate(15);

        $siswa->appends($request->all());

        return view("pages.kelolasiswa.kelolasiswa", [
            "keyword" => $keyword,
            "siswa" => $siswa,
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
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function show(siswaM $siswaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function edit(siswaM $siswaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswaM $siswaM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswaM $siswaM)
    {
        //
    }
}
