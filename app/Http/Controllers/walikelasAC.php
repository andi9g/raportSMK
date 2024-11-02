<?php

namespace App\Http\Controllers;

use App\Models\identitasM;
use App\Models\jurusanM;
use App\Models\kelasM;
use App\Models\walikelasM;
use Illuminate\Http\Request;

class walikelasAC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;
        $walikelas = walikelasM::orderBy("idkelas", "asc")
        ->orderBy("idjurusan", "asc")
        ->paginate(15);

        $cek = walikelasM::pluck("ididentitas")->toArray();

        $kelas = kelasM::get();
        $jurusan = jurusanM::get();

        $identitas = identitasM::where("posisi", "!=", "admin")
        ->whereNotIn("ididentitas", $cek)
        ->get();

        $walikelas->appends($request->only(["limit", "keyword"]));

        return view("pages.admin.walikelas", [
            "walikelas" => $walikelas,
            "identitas" => $identitas,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
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

        $request->validate([
            'ididentitas'=>'required',
            'idkelas'=>'required',
            'jurusan'=>'required',
        ]);

        try{
            $walikelas = "walikelas";
            identitasM::where("ididentitas", $request->ididentitas)->first()->update([
                "posisi" => $walikelas,
            ]);

            walikelasM::create([
                "ididentitas" => $request->ididentitas,
                "idkelas" => $request->idkelas,
                "idjurusan" => $request->jurusan,
            ]);

            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\walikelasM  $walikelasM
     * @return \Illuminate\Http\Response
     */
    public function show(walikelasM $walikelasM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\walikelasM  $walikelasM
     * @return \Illuminate\Http\Response
     */
    public function edit(walikelasM $walikelasM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\walikelasM  $walikelasM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, walikelasM $walikelasM, $ididentitas)
    {
        $request->validate([
            'idkelas'=>'required',
            'idjurusan'=>'required',
        ]);

        try{
            $walikelas = "walikelas";
            identitasM::where("ididentitas", $ididentitas)->first()->update([
                "posisi" => $walikelas,
            ]);

            walikelasM::where("ididentitas", $ididentitas)->update([
                "idkelas" => $request->idkelas,
                "idjurusan" => $request->idjurusan,
            ]);

            return redirect()->back()->with('success', 'Update Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\walikelasM  $walikelasM
     * @return \Illuminate\Http\Response
     */
    public function destroy(walikelasM $walikelasM, $idwalikelas)
    {
        try{
            $posisi = "guru";
            $walikelas = walikelasM::where("idwalikelas", $idwalikelas)->first();

            // identitasM::where("")

            $walikelas->identitas()->update([
                "posisi" => $posisi
            ]);

            $walikelas->delete();
            return redirect()->back()->with('success', 'Success');


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
