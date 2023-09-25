<?php

namespace App\Http\Controllers;

use App\Models\raportM;
use App\Models\detailraportM;
use App\Models\nilairaportM;
use App\Models\siswaM;
use App\Models\sekolahM;
use App\Models\identitasM;
use App\Models\jurusanM;
use App\Models\kelasM;
use App\Models\User;
use Auth;
use PDF;
use Illuminate\Http\Request;

class cetakraportC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $iddetailraport)
    {   
        $keyword = empty($request->keyword)?"":$request->keyword;
        $kelas = empty($request->kelas)?"":$request->kelas;
        $jurusan = empty($request->jurusan)?"":$request->jurusan;

        $datajurusan = jurusanM::get();
        $datakelas = kelasM::get();

        $iduser = Auth::user()->iduser;
        $cek = detailraportM::where("iddetailraport", $iddetailraport)
        ->where("iduser", $iduser);

        if($cek->count() == 0) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
        
        $idkelas = $cek->first()->idkelas;
        $idjurusan = $cek->first()->idjurusan;
        $idraport = $cek->first()->idraport;

        $identitas = identitasM::where("iduser", $iduser)->first();
        $judul2 = null;
        if($identitas->posisi == "walikelas") {
            $idkelas = $identitas->walikelas->idkelas;
            $idjurusan = $identitas->walikelas->idjurusan;
            $siswa = siswaM::where("idkelas", $idkelas)->where("idjurusan", $idjurusan)
            ->orderBy("nama", "asc")
            ->where("idjurusan", $idjurusan)
            ->where("idkelas", $idkelas)
            ->where("nama", "like", "%$keyword%")->paginate(15);
            $judul2 = strtoupper($identitas->walikelas->kelas->namakelas)." [".($identitas->walikelas->jurusan->namajurusan)."]";
        }else if($identitas->posisi == "admin") {
            $siswa = siswaM::where("idkelas", "like","$kelas%")->where("idjurusan", "like",$jurusan."%")
            ->where("idjurusan", $idjurusan)
            ->where("idkelas", $idkelas)
            ->orderBy("nama", "asc")
            ->where("nama", "like", "%$keyword%")->paginate(15);
        }

        $siswa->appends($request->all());
        return view("pages.raport.cetakraport",[
            "keyword" => $keyword,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
            "identitas" => $identitas,
            "iddetailraport" => $iddetailraport,
            "siswa" => $siswa,
            "judul2" => $judul2,
            "datajurusan" => $datajurusan,
            "datakelas" => $datakelas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function nilai(Request $request, $idsiswa, $iddetailraport)
     {
        $iduser = Auth::user()->iduser;
        $cek = detailraportM::where("iddetailraport", $iddetailraport)
        ->where("iduser", $iduser);
        if($cek->count() == 0) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
        
        $detail = $cek->first();
        $siswa = siswaM::where("idsiswa", $idsiswa)->first();
        $sekolah = sekolahM::first();

        
        
        $nilairaport = nilairaportM::join("detailraport", "detailraport.iddetailraport", "nilairaport.iddetailraport")
        ->join("raport", "raport.idraport", "detailraport.idraport")
        ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
        ->join("elemen", "elemen.idelemen", "nilairaport.idelemen")
        ->where("detailraport.idraport", $detail->idraport)
        ->where("nilairaport.idsiswa", $idsiswa)
        ->orderBy("mapel.ket", "asc")
        ->orderBy("mapel.namamapel", "asc")
        ->get();

        // dd($nilairaport->toArray());
        $idmapel = null; 
        $hitung = 1; 
        $data = [];
        $ket = null;
        $umum = [];
        $kejuruan = [];
        $n1 = 0;
        $n2 = 0;
        foreach ($nilairaport as $nilai) {
            if($nilai->mapel->ket == "kejuruan") {
                if($idmapel != $nilai->idmapel) {
                    $hitung = 1; 
                    $idmapel = $nilai->idmapel;
                    
                    $n1 = (int)$nilai->nilai;
                    $ket ="";
                    $catatan = "";
                    if($n1 < 65) {
                        $catatan = "Perlu ditingkatkan pembelajaran "."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }else {
                        $ket = "".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }
    
                }else {
                    $n2 = (int)$nilai->nilai;
                    $hitung++; 
                    $n1 = (int)($n1 + $nilai->nilai);
                    if($n2 < 65) {
                        $catatan = (empty($catatan)?"Perlu ditingkatkan pembelajaran ":$catatan).", "."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }else {
                        $ket = (empty($ket)?"":$ket .", ")."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }
                }
            }else if($nilai->mapel->ket == "umum") {
                if($idmapel != $nilai->idmapel) {
                    $hitung = 1; 
                    $idmapel = $nilai->idmapel;
                    
                    $n1 = (int)$nilai->nilai;
                    $ket ="";
                    $catatan = "";
                    if($n1 < 65) {
                        $catatan = "Perlu ditingkatkan pembelajaran "."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }else {
                        $ket = "".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }
    
                }else {
                    $hitung++; 
                    
                    $n2 = (int)$nilai->nilai;
                    $n1 = (int)($n1 + $nilai->nilai);
                    if($n2 < 65) {
                        $catatan = (empty($catatan)?"Perlu ditingkatkan pembelajaran ":$catatan).", "."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }else {
                        $ket = (empty($ket)?"":$ket .", ")."".$this->angkaRomawi($hitung)."). ".$nilai->elemen;
                    }
                }

            }

            
            $mapel[$nilai->mapel->idmapel] = [
                "namamapel" => $nilai->mapel->namamapel,
                "capaian" => $ket,
                "nilai" => round($n1 / $hitung),
                "ket" => $nilai->mapel->ket,
                "catatan" => $catatan,
            ];

            

        }
     

        $pdf = PDF::loadView("laporan.raport.nilai", [
            "siswa" => $siswa,
            "sekolah" => $sekolah,
            "detail" => $detail,
            "mapel" => $mapel,
        ]);

        return $pdf->stream("cover_".str_replace(" ", "", $siswa->nama).".pdf");


    }

    function angkaRomawi($angka)
    {
        $angka = intval($angka);
        $result = '';
        
        $array = array('M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1);
        
        foreach($array as $roman => $value){
        $matches = intval($angka/$value);
        
        $result .= str_repeat($roman,$matches);
        
        $angka = $angka % $value;
        }
        
        return $result;
    }

    public function cover(Request $request, $idsiswa)
    {
        $siswa = siswaM::where("idsiswa", $idsiswa)->first();
        $pdf = PDF::loadView("laporan.raport.cover", [
            "siswa" => $siswa,
        ]);

        return $pdf->stream("cover_".str_replace(" ", "", $siswa->nama).".pdf");
    }

    public function identitas(Request $request, $idsiswa)
    {
        $siswa = siswaM::where("idsiswa", $idsiswa)->first();
        $pdf = PDF::loadView("laporan.raport.identitas", [
            "siswa" => $siswa,
        ]);

        return $pdf->stream("identitas_".str_replace(" ", "", $siswa->nama).".pdf");
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
