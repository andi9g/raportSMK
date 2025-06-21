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
use App\Models\kelasM;
use App\Models\jurusanM;
use App\Models\judulp5M;
use App\Models\sekolahM;
use App\Models\siswaM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class raportp5C extends Controller
{

    public function siswa(Request $request, $idraportp5)
    {
        // try{
            $keyword = empty($request->keyword)?'':$request->keyword;
            $posisi = Auth::user()->identitas->posisi;
            $iduser = Auth::user()->iduser;
            $idjurusan = "1";
            $idkelas = "1";

            $raportp5 = raportp5M::where("idraportp5", $idraportp5)->first();

            $pages = empty($request->page)?1:$request->page;


            if($posisi == "admin") {
                $siswa = siswaM::where("nama", "like", "%$keyword%")
                ->orderBy("nama", "asc")
                ->paginate(20);
            }else if($posisi == "walikelas"){
                $idkelas = Auth::user()->identitas->walikelas->idkelas;
                $idjurusan = Auth::user()->identitas->walikelas->idjurusan;
                $identitasp5 = identitasp5M::where("iduser", Auth::user()->iduser)->first();

                if(!is_null($identitasp5)) {
                    $idkelas2 = $identitasp5->idkelas;
                    $idjurusan2 = $identitasp5->idjurusan;
                    if($idkelas == $idkelas2 && $idjurusan == $idjurusan2) {
                        $siswa = siswaM::where("idkelas", $idkelas)
                        ->where("idjurusan", $idjurusan)
                        ->where("nama", "like", "%$keyword%")
                        ->orderBy("nama", "asc")
                        ->paginate(20);
                    }else {
                        $idkelas = $identitasp5->idkelas;
                        $idjurusan = $identitasp5->idjurusan;

                        $siswa = siswaM::where("idkelas", $idkelas)
                        ->where("idjurusan", $idjurusan)
                        ->where("nama", "like", "%$keyword%")
                        ->orderBy("nama", "asc")
                        ->paginate(20);
                    }
                }else {
                    $siswa = siswaM::where("idkelas", $idkelas)
                    ->where("idjurusan", $idjurusan)
                    ->where("nama", "like", "%$keyword%")
                    ->orderBy("nama", "asc")
                    ->paginate(20);

                }
            }else {
                $identitasp5 = identitasp5M::where("iduser", Auth::user()->iduser)->first();
                $idkelas = $identitasp5->idkelas;
                $idjurusan = $identitasp5->idjurusan;

                $siswa = siswaM::where("idkelas", $idkelas)
                ->where("idjurusan", $idjurusan)
                ->where("nama", "like", "%$keyword%")
                ->orderBy("nama", "asc")
                ->paginate(20);
            }

            $raportp5 = raportp5M::where("idraportp5",$idraportp5)->first();

            $siswa->appends($request->only(["limit", "keyword"]));


            $totalHitung = 0;
            $temap5 = temap5M::where("idraportp5", $idraportp5)->get();

            foreach ($temap5 as $tema) {
                $dimensip5 = dimensip5M::where("idtemap5", $tema->idtemap5)->get();
                foreach ($dimensip5 as $dimensi) {
                    $subdimensip5 = subdimensip5M::where("iddimensip5", $dimensi->iddimensip5)->get();
                    foreach ($subdimensip5 as $looping) {
                        $totalHitung++;
                    }
                }
            }

            // $dimensi = dimensip5M::where("idtemap5", $total->temap5->idtemap5)->get()->subdimensip5->count();
            // $totalHitung = $total->temap5->where("idraportp5", $idraportp5)->first()->dimensip5->subdimensip5->count();

            $project = judulp5M::where("idraportp5", $idraportp5)
            ->where("idkelas", $raportp5->idkelas)
            ->where("idjurusan", $idjurusan)
            ->first();
            // dd($project);

            // dd($idkelas);

            return view("pages.p5.siswa", [
                "keyword" => $keyword,
                "siswa" => $siswa,
                "project" => $project,
                "idraportp5" => $idraportp5,
                "raportp5" => $raportp5,
                "totalHitung" => $totalHitung,
                "pages" => $pages,

                "idkelas" => $idkelas,
                "idjurusan" => $idjurusan,
            ]);

        // }catch(\Throwable $th){
        //     return redirect()->back()->with('toast_error', 'Silahkan melakukan pengelolaan rapor P5');
        // }
    }


    public function formnilai(Request $request, $idraportp5, $nisn, $pages)
    {
        $nisn = sprintf("%010s", $nisn);

        $pages = empty($pages)?1:$pages;

        $siswa = siswaM::where("nisn", $nisn)->first();

        $nilai = raportp5M::where("idraportp5", $idraportp5)->first();
        $temap5 = temap5M::where("idraportp5", $nilai->idraportp5)->get();

        $keteranganp5 = keteranganp5M::orderBy("index", "asc")->get();

        return view("pages.p5.penilaian", [
            "nisn" => $nisn,
            "idraportp5" => $idraportp5,
            "siswa" => $siswa,
            "temap5" => $temap5,
            "keteranganp5" => $keteranganp5,
            "pages" => $pages,
        ]);
    }

    public function cetak(Request $request, $idraportp5, $nisn)
    {
        try{
            $keteranganp5 = keteranganp5M::orderBy("index", "asc")->get();

            $siswa = siswaM::where("nisn", sprintf("%010s", $nisn))->first();

            $raportp5 = raportp5M::where("idraportp5", $idraportp5)->first();

            $data = [];
            $temap5 = temap5M::where("idraportp5", $idraportp5)->get();
            foreach ($temap5 as $tema) {

                $dimensip5 = dimensip5M::where("idtemap5", $tema->idtemap5)->get();
                $dim = [];
                foreach ($dimensip5 as $dimensi) {

                    $subdimensip5 = subdimensip5M::where("iddimensip5", $dimensi->iddimensip5)->get();

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




            $sekolah = sekolahM::first();

            // $identitasp5 = identitasp5M::where("iduser", Auth::user()->iduser)->first();
            $idkelas = Auth::user()->identitas->walikelas->idkelas;
            $idjurusan = Auth::user()->identitas->walikelas->idjurusan;
            $identitasp5 = identitasp5M::where("idkelas", $idkelas)
            ->where("idjurusan", $idjurusan)
            ->orderBy("ididentitasp5", "desc")
            ->first();

            $judulp5 = judulp5M::where("idjurusan", $idjurusan)
            ->where("idkelas", $raportp5->idkelas)
            ->where("idraportp5", $idraportp5)
            ->orderBy("idjudulp5", "desc")
            ->first()->judulp5 ?? "Belum Memiliki Judul";

            $pdf = PDF::loadView("laporan.p5.raport", [
                "siswa" => $siswa,
                "keteranganp5" => $keteranganp5,
                "data" => $data,
                "sekolah" => $sekolah,
                "judulp5" => $judulp5,
                "detail" => $raportp5,
                "identitasp5" => $identitasp5,
            ]);


            return $pdf->stream("Raport_P5_".$siswa->nama.".pdf");

        }catch(\Throwable $th){
            abort(500, 'MAAF, HANYA WALIKELAS YANG DAPAT MENCETAK');
        }



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
                    "success" => "berhasil",
                ];
            }else {
                $data["nisn"] = sprintf("%010s", $nisn);
                $data["idketeranganp5"] = $idketeranganp5;
                $data["idsubdimensip5"] = $idsubdimensip5;
                $data["idraportp5"] = $idraportp5;
                $cek->first()->update($data);
                $pesan = [
                    "success" => "berhasil",
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
            $judulp5 = $request->judulp5;

            $cek = judulp5M::where("idraportp5", $idraportp5)
            ->where("iduser", $iduser);

            $idkelas = Auth::user()->identitasp5->idkelas;
            $idjurusan = Auth::user()->identitasp5->idjurusan;

            if($cek->count() == 0) {
                judulp5M::create([
                    "iduser" => $iduser,
                    "idkelas" => $idkelas,
                    "idjurusan" => $idjurusan,
                    "judulp5" => $judulp5,
                    "idraportp5" => $idraportp5,
                ]);
            }else {
                $cek->first()->update([
                    "iduser" => $iduser,
                    "idkelas" => $idkelas,
                    "idjurusan" => $idjurusan,
                    "judulp5" => $judulp5,
                    "idraportp5" => $idraportp5,
                ]);
            }

            return redirect()->route("penilaian.raportp5", $idraportp5)->with("success", "Judul telah diupdate");

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Bukan hak admin');
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
        $iduser = Auth::user()->identitas->iduser;

        $dataKelas = kelasM::get();
        $dataJurusan = jurusanM::get();

        $idkelas = "";
        $idjurusan = "";
        if($posisi == "admin") {
            $raportp5 = raportp5M::orderBy("idraportp5", 'DESC')->get();

        }else if(!empty(Auth::user()->identitasp5->idkelas)) {

            $idkelas = Auth::user()->identitasp5->idkelas;
            $idjurusan = Auth::user()->identitasp5->idjurusan;
            $raportp5 = raportp5M::orderBy("idraportp5", 'DESC')->where("ket", "!=", 0)
            ->where("ket", 1)
            ->get();
        }else if($posisi="walikelas") {
            $idkelas = Auth::user()->identitas->walikelas->idkelas;
            $idjurusan = Auth::user()->identitas->walikelas->idjurusan;
            $raportp5 = raportp5M::orderBy("idraportp5", 'DESC')->where("ket", "!=", 0)
            ->where("ket", 1)
            ->get();
        }

        return view("pages.p5.raport", [
            "posisi" => $posisi,
            "tahun" => $tahun,
            "raportp5" => $raportp5,
            "idkelas" => $idkelas,
            "idjurusan" => $idjurusan,

            "dataKelas" => $dataKelas,
            "dataJurusan" => $dataJurusan,
        ]);
    }

    public function editraportp5(Request $request, $idraportp5)
    {
        $raportp5 = raportp5M::where("idraportp5", $idraportp5)->first();

        $data = $request->only(["tema", "idkelas", "tahun", "nomor", "semester"]);
        $data["fase"] = ($data["idkelas"]==1)?"E":"F";
        // dd($data);

        $raportp5->update($data);

        return redirect()->back()->with('success', 'Success');

    }
    public function openraportp5(Request $request, $idraportp5)
    {
        $raportp5 = raportp5M::where("idraportp5", $idraportp5)->first();

        $index = 1;
        if($raportp5->ket == 1) {
            $index = 0;
        }

        $raportp5->update([
            "ket" => $index,
        ]);

        return redirect()->back()->with('success', 'Success');
    }


    public function tambah(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tema' => 'required',
            'idkelas' => 'required',
            'nomor' => 'required',
        ]);


        try{
            $data = $request->all();
            $data["fase"] = ($data["idkelas"]==1)?"E":"F";
            dd($data);

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
        $temap5 = temap5M::where("idraportp5", $idraportp5)->get();

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
