<?php

namespace App\Http\Controllers;

use App\Models\pklM;
use App\Models\kelasM;
use App\Models\walikelasM;
use App\Models\walikelaspklM;
use App\Models\kepalasekolahpklM;
use App\Models\kajurpklM;
use App\Models\jurusanM;
use App\Models\user;
use Illuminate\Http\Request;

class raporpklC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = pklM::orderBy("idpkl","asc")->paginate(15);
        // dd($data);

        $kelas = kelasM::get();

        return view('pages.raport.pkl', [
            'keyword' => $keyword,
            'raport' => $data,
            'kelas' => $kelas,
        ]);
    }


    public function ttd(Request $request, $idpkl) {
        $walikelas = walikelasM::get();    
        $user = User::orderBy("name", "asc")->get();
        $jurusan = jurusanM::get();    


        $walikelaspkl = walikelaspklM::where("idpkl", $idpkl)->get();
        $kepalasekolahpkl = kepalasekolahpklM::where("idpkl", $idpkl)->get();
        $kajurpkl = kajurpklM::where("idpkl", $idpkl)->get();
        return view("pages.raport.ttdpkl", [
            "walikelas" => $walikelas,
            "user" => $user,
            "walikelaspkl" => $walikelaspkl,
            "kepalasekolahpkl" => $kepalasekolahpkl,
            "kajurpkl" => $kajurpkl,
            "jurusan" => $jurusan,
            "idpkl" => $idpkl,
        ]);
     }

    public function tambahwalikelas(Request $request, $idpkl)
    {
        try{
            $data = $request->all();
            $data["idpkl"] = $idpkl;

            walikelaspklM::create($data);
            
            return redirect()->back()->with('success', 'Walikelas berhasil ditambahkan');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapuswalikelas(Request $request, $idwalikelaspkl)
    {
        try{
            $destroy = walikelaspklM::where('idwalikelaspkl', $idwalikelaspkl)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    
    //kepala sekolah
    public function tambahkepalasekolah(Request $request, $idpkl)
    {
        try{
            $data = $request->all();
            $data["idpkl"] = $idpkl;

            kepalasekolahpklM::create($data);
            
            return redirect()->back()->with('success', 'kepalasekolah berhasil ditambahkan');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapuskepalasekolah(Request $request, $idkepalasekolahpkl)
    {
        try{
            $destroy = kepalasekolahpklM::where('idkepalasekolahpkl', $idkepalasekolahpkl)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    //Kajur
    public function tambahkajur(Request $request, $idpkl)
    {
        try{
            $data = $request->all();
            $data["idpkl"] = $idpkl;

            kajurpklM::create($data);
            
            return redirect()->back()->with('success', 'kajur berhasil ditambahkan');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapuskajur(Request $request, $idkajurpkl)
    {
        try{
            $destroy = kajurpklM::where('idkajurpkl', $idkajurpkl)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    
    
    
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
            'idkelas' => 'required',
            'tahunajaran' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            $data["status"] = 1;
        
            $store = pklM::create($data);
            if($store) {
                return redirect()->back()->with('success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pklM  $pklM
     * @return \Illuminate\Http\Response
     */
    public function show(pklM $pklM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pklM  $pklM
     * @return \Illuminate\Http\Response
     */
    public function edit(pklM $pklM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pklM  $pklM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pklM $pklM, $idpkl)
    {
        $request->validate([
            'idkelas' => 'required',
            'tahunajaran' => 'required',
            'status' => 'required',
        ]);
        
        
        try{
            $data = $request->only("idkelas", "tahunajaran", "status", "tanggalmulai", "tanggalselesai", "tanggalcetak");
        
            $update = pklM::where("idpkl", $idpkl)->update($data);
            if($update) {
                return redirect()->back()->with('success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pklM  $pklM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pklM $pklM)
    {
        return redirect()->back()->with('warning', 'Fitur hapus belum tersedia');
    }
}
