<?php

namespace App\Http\Controllers;

use App\Models\raportM;
use App\Models\identitasM;
use App\Models\User;
use App\Models\kelasM;
use App\Models\mapelM;
use App\Models\jurusanM;
use App\Models\nilairaportM;
use App\Models\detailraportM;
use Illuminate\Http\Request;
use Auth;

class raportC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iduser = Auth::user()->iduser;
        $posisi = identitasM::where("iduser", $iduser)->first()->posisi;
        $keyword = empty($request->keyword)?"":$request->keyword;
        $raport = raportM::where("namaraport", "like", "%$keyword%")
        ->orWhere("semester", "like", "$keyword%")
        ->orderBy("idraport", "desc")
        ->paginate(15);

        
        $raport->appends($request->all());

        $kelas = kelasM::get();
        $mapel = mapelM::get();
        $jurusan = jurusanM::get();

        $user = User::where("iduser", $iduser)->first();

        return view('pages.raport.raport', [
            "keyword" => $keyword,
            "raport" => $raport,
            "user" => $user,
            "iduser" => $iduser,
            "kelas" => $kelas,
            "mapel" => $mapel,
            "jurusan" => $jurusan,
            "posisi" => $posisi,
        ]);
    }

    public function tambahdetailraport(Request $request, $idraport) {
        $request->validate([
            "idmapel" => "required|numeric",
            "idjurusan" => "required|numeric",
            "idkelas" => "required|numeric",
        ]);

        try {
            $iduser = Auth::user()->iduser;
            $data = $request->all();
            $data["iduser"] = $iduser;
            $data["idraport"] = $idraport;
            detailraportM::create($data);

            return redirect('detailraport/'.$idraport.'/kelola')->with("success", "Data berhasil ditambahkan");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    public function detailraport(Request $request, $idraport)
    {

        $iduser = Auth::user()->iduser;
        $judul = raportM::where("idraport", $idraport)->first()->namaraport;

        $keyword = empty($request->keyword)?"":$request->keyword;
        $kelas = kelasM::get();
        $mapel = mapelM::get();
        $jurusan = jurusanM::get();

        $user = User::where("iduser", $iduser)->first();

        $detailraport = detailraportM::where('iduser', $iduser)
        ->where('idraport', $idraport)
        ->get();

        
        return view("pages.raport.detailraport", [
            "judul" => $judul,
            "idraport" => $idraport,
            "user" => $user,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
            "mapel" => $mapel,
            "keyword" => $keyword,
            "detailraport" => $detailraport,
        ]);

    }

    public function open(Request $request, $idraport)
    {
        $raport = raportM::where("idraport", $idraport)->first();
        if($raport->ket == true) {
            $ket = 0;
        }else {
            $ket = 1;
        }

        $raport->update([
            "ket" => $ket,
        ]);

        return redirect()->back()->withInput();
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
        try {
            
            $data = $request->all();
            $data["fase"] = strtoupper($request->fase);
            raportM::create($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
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
    public function destroy(raportM $raportM, $idraport)
    {
        raportM::destroy($idraport);
        return redirect()->back()->with("warning", "success")->withInput();
    }
}
