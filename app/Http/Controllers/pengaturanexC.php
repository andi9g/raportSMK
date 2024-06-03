<?php

namespace App\Http\Controllers;

use App\Models\pembinaexM;
use App\Models\User;
use App\Models\identitasM;
use App\Models\siswa2M;
use App\Models\siswaM;
use Illuminate\Http\Request;

class pengaturanexC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pembina = pembinaexM::get();
        $identitas = identitasM::get();

        return view("pages.pengaturan.extrakulikuler",[
            "pembina" => $pembina,
            "identitas" => $identitas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function sinkron(Request $request)
    // {
    //     $siswalama = siswa2M::where("idkelas", 2)->get();

    //     foreach ($siswalama as $item) {
    //         $cek = siswaM::where("nisn", $item->nisn)->count();
    //         if($cek == 0) {
    //             $tambah = new siswaM;
    //             $tambah->nisn = $item->nisn;
    //             $tambah->nis = $item->nis;
    //             $tambah->nama = $item->nama;
    //             $tambah->tempatlahir = $item->tempatlahir;
    //             $tambah->agama = $item->agama;
    //             $tambah->alamat = $item->alamat;
    //             $tambah->idkelas = $item->idkelas;
    //             $tambah->idjurusan = $item->idjurusan;
    //             $tambah->save();
    //         }
    //     }

    //     return dd("SELESAI");
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();

            pembinaexM::create($data);

            return redirect()->back()->with('toast_success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pembinaexM  $pembinaexM
     * @return \Illuminate\Http\Response
     */
    public function show(pembinaexM $pembinaexM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pembinaexM  $pembinaexM
     * @return \Illuminate\Http\Response
     */
    public function edit(pembinaexM $pembinaexM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pembinaexM  $pembinaexM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pembinaexM $pembinaexM, $idpembinaex)
    {
        try{
            $data = $request->all();

            pembinaexM::where("idpembinaex", $idpembinaex)->first()->update($data);

            return redirect()->back()->with('toast_success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pembinaexM  $pembinaexM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pembinaexM $pembinaexM, $idpembinaex)
    {
        try{
            pembinaexM::destroy($idpembinaex);

            return redirect()->back()->with('toast_success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
