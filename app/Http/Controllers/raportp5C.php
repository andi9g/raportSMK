<?php

namespace App\Http\Controllers;

use App\Models\temap5M;
use App\Models\keteranganp5M;
use App\Models\identitasp5M;
use App\Models\dimensip5M;
use App\Models\subdimensip5M;
use App\Models\penilaianp5M;
use App\Models\raportp5M;
use App\Models\User;
use App\Models\sekolahM;
use App\Models\siswaM;
use Auth;
use PDF;
use Illuminate\Http\Request;

class raportp5C extends Controller
{

    public function siswa(Request $request, $idraportp5)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;
        $posisi = Auth::user()->identitas->posisi;
        
        $project = "";
        if($posisi == "admin") {
            $siswa = siswaM::where("nama", "like", "%$keyword%")
            ->orderBy("nama", "asc")
            ->paginate(20);
        }else {
            $identitasp5 = identitasp5M::where("iduser", Auth::user()->iduser)->first();
            $idkelas = $identitasp5->idkelas;
            $idjurusan = $identitasp5->idjurusan;
            $project = $identitasp5->namaproject;

            $siswa = siswaM::where("idkelas", $idkelas)
            ->where("idjurusan", $idjurusan)
            ->where("nama", "like", "%$keyword%")
            ->orderBy("nama", "asc")
            ->paginate(20);
        }

        $siswa->appends($request->only(["limit", "keyword"]));
        
        $total = raportp5M::where("idraportp5", $idraportp5)->first();

        $totalHitung = $total->temap5->dimensip5->subdimensip5->count();

        
        return view("pages.p5.siswa", [
            "keyword" => $keyword,
            "siswa" => $siswa,
            "project" => $project,
            "idraportp5" => $idraportp5,
            "totalHitung" => $totalHitung,
        ]);
    }


    public function formnilai(Request $request, $idraportp5, $nisn)
    {
        $nisn = sprintf("%010s", $nisn);

        $siswa = siswaM::where("nisn", $nisn)->first();
        
        $nilai = raportp5M::where("idraportp5", $idraportp5)->first();
        $temap5 = $nilai->temap5->get();
        
        $keteranganp5 = keteranganp5M::orderBy("index", "asc")->get();

        return view("pages.p5.penilaian", [
            "nisn" => $nisn,
            "idraportp5" => $idraportp5,
            "siswa" => $siswa,
            "temap5" => $temap5,
            "keteranganp5" => $keteranganp5,
        ]);
    }

    public function cetak(Request $request, $idraportp5, $nisn)
    {
        $keteranganp5 = keteranganp5M::orderBy("index", "asc")->get();

        $siswa = siswaM::where("nisn", sprintf("%010s", $nisn))->first();

        $raportp5 = raportp5M::where("idraportp5", $idraportp5)->first();

        $data = [];
        $temap5 = $raportp5->temap5->get();
        foreach ($temap5 as $tema) {
            
            $dimensip5 = $tema->dimensip5->get();
            $dim = [];
            foreach ($dimensip5 as $dimensi) {
                
                $subdimensip5 = $dimensi->subdimensip5->where("iddimensip5", $dimensi->iddimensip5)->get();
                
                $sub = [];
                foreach ($subdimensip5 as $subdimensi) {
                    $nilai = [];
                    $ket = [];
                    foreach ($keteranganp5 as $keterangan) {
                        $hitung = penilaianp5M::where("idketeranganp5", $keterangan->idketeranganp5)
                        ->where("nisn", sprintf("%010s", $nisn))
                        ->where("idsubdimensip5", $subdimensi->idsubdimensip5)
                        ->where("idraportp5", $idraportp5)
                        ->count();
                        
                        $nilai[] = $hitung;

                        if($hitung == 1) {
                            $ket[] = [
                                "keterangan" => $keterangan->keteranganp5,
                                "inisial" => $keterangan->inisialp5,
                            ];

                        }
                    }

                    $sub[] = [
                        "subdimensi" => $subdimensi->subdimensip5,
                        "deskripsi" => $subdimensi->deskripsi,
                        "nilai" => $nilai,
                        "keterangan" => $ket,
                    ];
                }

            $dim[] = [
                "dimensi" => $dimensi->dimensip5,
                "subdimensi" => $sub,
            ];


            }

        $data[] = [
            "tema" => $tema->temap5,
            "dimensi" => $dim,
        ];

        }

        // dd($data);
        $sekolah = sekolahM::first();

        $identitasp5 = identitasp5M::where("iduser", Auth::user()->iduser)->first();
        
        $pdf = PDF::loadView("laporan.p5.raport", [
            "siswa" => $siswa,
            "keteranganp5" => $keteranganp5,
            "data" => $data,
            "sekolah" => $sekolah,
            "detail" => $raportp5,
            "identitasp5" => $identitasp5,
        ]);


        return $pdf->stream("Raport_P5_".$siswa->nama.".pdf");


    }

    public function nilai(Request $request, $nisn, $idketeranganp5)
    {
        $nisn = sprintf("%010s", $nisn);
        $idketeranganp5 = $idketeranganp5;
        $idsubdimensip5 = $request->idsubdimensip5;
        $idraportp5 = $request->idraportp5;

        try{
            $cek = penilaianp5M::where("nisn", sprintf("%010s", $nisn))
            ->where("idsubdimensip5", $idsubdimensip5)
            ->where("idraportp5", $idraportp5);

            if($cek->count() == 0 ){
                $data["nisn"] = sprintf("%010s", $nisn); 
                $data["idketeranganp5"] = $idketeranganp5; 
                $data["idsubdimensip5"] = $idsubdimensip5; 
                $data["idraportp5"] = $idraportp5; 
                penilaianp5M::create($data);

                $pesan = [
                    "success" => "berhasil 1",
                ];
            }else {
                $data["nisn"] = sprintf("%010s", $nisn); 
                $data["idketeranganp5"] = $idketeranganp5; 
                $data["idsubdimensip5"] = $idsubdimensip5; 
                $data["idraportp5"] = $idraportp5; 
                $cek->first()->update($data);
                $pesan = [
                    "success" => "berhasil 2",
                ];
            }

            return $pesan;

        }catch(\Throwable $th){
            $pesan = [
                "success" => "Terjadi kesalahan",
            ];
            return $pesan;
        }
        
        
        
    }


    public function tambahprojectp5(Request $request, $idraportp5)
    {
        try{
            $iduser = Auth::user()->iduser;
            $data = $request->all();
            identitasp5M::where("iduser", $iduser)->first()->update($data);
    
            return redirect()->route("penilaian.raportp5", $idraportp5)->with("success", "Project telah ditambahkan");
        
        }catch(\Throwable $th){
            return redirect()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function ubahprojectp5(Request $request, $idraportp5)
    {
        try{
            $iduser = Auth::user()->iduser;
            $data = $request->all();
            identitasp5M::where("iduser", $iduser)->first()->update($data);
    
            return redirect()->route("penilaian.raportp5", $idraportp5)->with("success", "Project telah ditambahkan");
        
        }catch(\Throwable $th){
            return redirect('location')->with('toast_error', 'Terjadi kesalahan');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tahun = date("Y");
        $posisi = Auth::user()->identitas->posisi;

        if($posisi == "admin") {
            $raportp5 = raportp5M::get();
        }else {
            $raportp5 = raportp5M::where("ket", "!=", 0)->paginate(15);
        }

        return view("pages.p5.raport", [
            "posisi" => $posisi,
            "tahun" => $tahun,
            "raportp5" => $raportp5,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'fase' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
        
            raportp5M::create($data);
            
            return redirect()->back()->with('success', 'success');
            
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function temap5(Request $request, $idraportp5)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;
        $temap5 = temap5M::get();

        return view("pages.p5.tema", [
            "keyword" => $keyword,
            "idraportp5" => $idraportp5,
            "temap5" => $temap5,
        ]);
    }

    public function tambahtemap5(Request $request, $idraportp5)
    {
        $request->validate([
            'temap5' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            $data["idraportp5"] = $idraportp5;
            
            temap5M::create($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function ubahtemap5(Request $request, $idtemap5)
    {
        $request->validate([
            'temap5' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            
            temap5M::where("idtemap5", $idtemap5)->first()->update($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function hapustemap5(Request $request, $idtemap5)
    {
        try{
            $destroy = temap5M::where('idtemap5', $idtemap5)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function tambahdimensip5(Request $request)
    {
        $request->validate([
            'dimensip5' => 'required',
            'idtemap5' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            
            dimensip5M::create($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function ubahdimensip5(Request $request, $iddimensip5)
    {
        $request->validate([
            'dimensip5' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            
            dimensip5M::where("iddimensip5", $iddimensip5)->first()->update($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function hapusdimensip5(Request $request, $iddimensip5)
    {
        try{
            $destroy = dimensip5M::where('iddimensip5', $iddimensip5)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function tambahsubdimensip5(Request $request)
    {
        $request->validate([
            'subdimensip5' => 'required',
            'deskripsi' => 'required',
            'iddimensip5' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            
            subdimensip5M::create($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function ubahsubdimensip5(Request $request, $idsubdimensip5)
    {
        $request->validate([
            'subdimensip5' => 'required',
            'deskripsi' => 'required',
        ]);
        
        
        try{
            $data = $request->all();
            
            subdimensip5M::where("idsubdimensip5", $idsubdimensip5)->first()->update($data);

            return redirect()->back()->with('success', 'Success');
           
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function hapussubdimensip5(Request $request, $idsubdimensip5)
    {
        try{
            $destroy = subdimensip5M::where('idsubdimensip5', $idsubdimensip5)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
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
     * @param  \App\Models\temap5M  $temap5M
     * @return \Illuminate\Http\Response
     */
    public function show(temap5M $temap5M)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\temap5M  $temap5M
     * @return \Illuminate\Http\Response
     */
    public function edit(temap5M $temap5M)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\temap5M  $temap5M
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, temap5M $temap5M)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\temap5M  $temap5M
     * @return \Illuminate\Http\Response
     */
    public function destroy(temap5M $temap5M)
    {
        //
    }
}
