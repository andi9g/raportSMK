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
use App\Models\kehadiranM;
use App\Models\catatanM;
use App\Models\ujianM;
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
    public function index(Request $request, $idraport)
    {   
        $keyword = empty($request->keyword)?"":$request->keyword;
        $kelas = empty($request->kelas)?"":$request->kelas;
        $jurusan = empty($request->jurusan)?"":$request->jurusan;

        $datajurusan = jurusanM::get();
        $datakelas = kelasM::get();

        $iduser = Auth::user()->iduser;
        $cek = identitasM::where("iduser", $iduser);

        if($cek->count() == 0) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
        
        // $idkelas = $cek->first()->walikelas->idkelas;
        // $idjurusan = $cek->first()->walikelas->idjurusan;

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
            $idkelas = $kelas;
            $idjurusan = $jurusan;
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
            "idraport" => $idraport,
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

     public function nilai(Request $request, $idsiswa, $idraport)
     {
        $iduser = Auth::user()->iduser;
        $identitas = identitasM::where("iduser", $iduser);
        if($identitas->count() == 0) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
        
        $detail = raportM::where("idraport", $idraport)->first();
        $siswa = siswaM::where("idsiswa", $idsiswa)->first();
        $sekolah = sekolahM::first();

        $mapel = [];
        
        
        $nilairaport = nilairaportM::join("detailraport", "detailraport.iddetailraport", "nilairaport.iddetailraport")
        ->join("raport", "raport.idraport", "detailraport.idraport")
        ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
        ->join("elemen", "elemen.idelemen", "nilairaport.idelemen")
        ->where("detailraport.idraport", $idraport)
        ->where("nilairaport.idsiswa", $idsiswa)
        ->orderBy("mapel.ket", "asc")
        ->orderBy("mapel.namamapel", "asc")
        ->orderBy("mapel.idmapel", "asc")
        ->select("mapel.idmapel")
        ->groupBy("mapel.idmapel")
        ->get();

        
        // dd($nilairaport->toArray());
        // $idmapel = null; 
        // $hitung = 1; 
        // $data = [];
        // $ket = null;
        // $umum = [];
        // $kejuruan = [];
        // $n1 = 0;
        // $n2 = 0;
        // $mapel = [];
        // $guru = "";
        foreach ($nilairaport as $nr) {
            $nilai2 = nilairaportM::join("detailraport", "detailraport.iddetailraport", "nilairaport.iddetailraport")
            ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
            ->join("elemen", "elemen.idelemen", "nilairaport.idelemen")
            ->select("nilairaport.*", "mapel.namamapel", "elemen.elemen")
            ->where("detailraport.idraport", $idraport)
            ->where("mapel.idmapel", $nr->idmapel)
            ->where("nilairaport.idsiswa", $idsiswa)
            ->get();
            // dd($nilai2);
            //nilai
            $n1 = 0;
            $catatanBaik = "";
            $catatanBuruk = "";
            foreach ($nilai2 as $nilai) {
                $n1 = $n1 + $nilai->nilai;
                
                if($nilai->nilai < 70) {
                    if(empty($catatanBuruk)) {
                        $catatanBuruk = "Perlu ditingkatkan dalam ".strtolower($nilai->elemen);
                    }else {
                        $catatanBuruk = $catatanBuruk.", ".strtolower($nilai->elemen);
                    }
                }else {
                    if(empty($catatanBaik)) {
                        $catatanBaik = "Menunjukan penguasaan yang baik dalam ".strtolower($nilai->elemen);
                    }else {
                        $catatanBaik = $catatanBaik.", ".strtolower($nilai->elemen);
                    }
                }
            }
            $catatanBaik = $catatanBaik;
            $catatanBuruk = $catatanBuruk;
            $nilai = $n1/count($nilai2);

            
            // $catatan = catatanM::join("detailraport", "detailraport.iddetailraport", "catatan.iddetailraport")
            // ->where("detailraport.idraport", $idraport)
            // ->where("catatan.idmapel", $nr->idmapel)
            // ->where("catatan.idsiswa", $idsiswa)
            // ->select("catatan.catatan")->get();

            // foreach ($catatan as $cat) {
            //     if(empty($catatanBuruk)) {
            //         $catatanBuruk = ucfirst(strtolower($cat->catatan));
            //     }else {
            //         $catatanBuruk = $catatanBuruk.", ".strtolower($cat->catatan);
            //     }
            // }

            $ujian = ujianM::where("idraport", $idraport)
            ->where("idmapel", $nr->idmapel)
            ->where("idsiswa", $idsiswa)
            ->orderBy("idujian", "desc");

            if ($ujian->count() > 0) {
                $ujian = $ujian->first();
                $lisan = $ujian->lisan;
                $nonlisan = $ujian->nonlisan;

                if($lisan == 0 || $nonlisan == 0) {
                    $nilaiujian = $lisan + $nonlisan;
                    $nilai = ($nilai + $nilaiujian) / 2;
                }else {
                    $nilaiujian = ($lisan + $nonlisan) / 2;
                    $nilai = ($nilai + $nilaiujian) / 2;
                }
            }
            
            $mapel[$nr->idmapel] = [
                "namamapel" => $nr->mapel->namamapel,
                "capaian" => $catatanBaik,
                "nilai" => round($nilai),
                "ket" => $nr->mapel->ket,
                "catatan" => $catatanBuruk,
            ];

            // dd($mapel);

        }
     
        $raport = raportM::where("idraport", $idraport)->first();
        

        $pdf = PDF::loadView("laporan.raport.nilai", [
            "siswa" => $siswa,
            "raport" => $raport,
            "sekolah" => $sekolah,
            "detail" => $detail,
            "identitas" => $identitas,
            "mapel" => $mapel,
        ]);

        return $pdf->stream("cover_".str_replace(" ", "", $siswa->nama).".pdf");


    }



    //  public function nilai(Request $request, $idsiswa, $idraport)
    //  {
    //     $iduser = Auth::user()->iduser;
    //     $identitas = identitasM::where("iduser", $iduser);
    //     if($identitas->count() == 0) {
    //         return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
    //     }
        
    //     $detail = raportM::where("idraport", $idraport)->first();
    //     $siswa = siswaM::where("idsiswa", $idsiswa)->first();
    //     $sekolah = sekolahM::first();

        
        
    //     $nilairaport = nilairaportM::join("detailraport", "detailraport.iddetailraport", "nilairaport.iddetailraport")
    //     ->join("raport", "raport.idraport", "detailraport.idraport")
    //     ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
    //     ->join("elemen", "elemen.idelemen", "nilairaport.idelemen")
    //     ->where("detailraport.idraport", $idraport)
    //     ->where("nilairaport.idsiswa", $idsiswa)
    //     ->orderBy("mapel.ket", "asc")
    //     ->orderBy("mapel.namamapel", "asc")
    //     ->orderBy("mapel.idmapel", "asc")
    //     ->get();

    //     // dd($nilairaport->toArray());
    //     $idmapel = null; 
    //     $hitung = 1; 
    //     $data = [];
    //     $ket = null;
    //     $umum = [];
    //     $kejuruan = [];
    //     $n1 = 0;
    //     $n2 = 0;
    //     $mapel = [];
    //     $guru = "";
    //     foreach ($nilairaport as $nilai) {
    //         if($nilai->mapel->ket == "kejuruan") {
    //             if($idmapel != $nilai->idmapel) {
    //                 $hitung = 1; 
    //                 $idmapel = $nilai->idmapel;
                    
    //                 $n1 = (int)$nilai->nilai;
    //                 $ket ="";
    //                 $ct = catatanM::join("detailraport", "detailraport.iddetailraport", "catatan.iddetailraport")
    //                 ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
    //                 ->where("mapel.idmapel", $nilai->idmapel)
    //                 ->where("catatan.idsiswa", $idsiswa)->where("detailraport.idraport", $nilai->detailraport->idraport)->get();
                    
    //                 if (count($ct) == 0) {
    //                     $catatan = "";
    //                 }else {
    //                     $catatan = "";
    //                     $guru = "";
    //                     $i=1;
    //                     foreach ($ct as $ct2) {
                            
    //                         if($i++ >= count($ct) && count($ct) !=1) {
    //                             $guru = $guru.", ".$ct2->catatan;
    //                         }else {
    //                             $guru = $guru.$ct2->catatan;
    //                         }
    //                     }
    //                 }
                    
    //                 if($n1 < 70) {
    //                     $catatan = (empty($catatan)?"Perlu ditingkatkan dalam ":$catatan." ")." ".$nilai->elemen;
    //                 }else {
    //                     $ket = $nilai->elemen;
    //                 }

    //             }else {
    //                 $n2 = (int)$nilai->nilai;
    //                 $hitung++; 
    //                 $n1 = (int)($n1 + $nilai->nilai);
    //                 if($n2 < 70) {
    //                     $catatan = (empty($catatan)?"Perlu ditingkatkan dalam ":$catatan.", ")." ".$nilai->elemen;
    //                 }else {
    //                     $ket = (empty($ket)?"":$ket .", ").$nilai->elemen;
    //                 }
    //             }
    //         }else if($nilai->mapel->ket == "umum") {
    //             if($idmapel != $nilai->idmapel) {
    //                 $hitung = 1; 
    //                 $idmapel = $nilai->idmapel;
                    
    //                 $n1 = (int)$nilai->nilai;
    //                 $ct = catatanM::join("detailraport", "detailraport.iddetailraport", "catatan.iddetailraport")
    //                 ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
    //                 ->where("mapel.idmapel", $nilai->idmapel)
    //                 ->where("catatan.idsiswa", $idsiswa)->where("detailraport.idraport", $nilai->detailraport->idraport)->get();
                    
    //                 if (count($ct) == 0) {
    //                     $catatan = "";
    //                 }else {
    //                     $catatan = "";
    //                     $guru = "";
    //                     $i=1;
    //                     foreach ($ct as $ct2 ) {
                            
    //                         if($i++ >= count($ct) && count($ct) !=1) {
    //                             $guru = $guru.", ".$ct2->catatan;
    //                         }else {
    //                             $guru = $guru.$ct2->catatan;
    //                         }
    //                     }
    //                 }
                    
    //                 if($n1 < 70) {
    //                     $catatan = (empty($catatan)?"Perlu ditingkatkan dalam ":$catatan." ")." ".$nilai->elemen;
    //                 }else {
    //                     $ket = $nilai->elemen;
    //                 }
    
    //             }else {
    //                 $hitung++; 
                    
    //                 $n2 = (int)$nilai->nilai;
    //                 $n1 = (int)($n1 + $nilai->nilai);
    //                 if($n2 < 70) {
    //                     $catatan = (empty($catatan)?"Perlu ditingkatkan dalam ":$catatan).", ".$nilai->elemen;
    //                 }else {
    //                     $ket = (empty($ket)?"":$ket .", ").$nilai->elemen;
    //                 }
    //             }

    //         }

            
    //         $mapel[$nilai->mapel->idmapel] = [
    //             "namamapel" => $nilai->mapel->namamapel,
    //             "capaian" => $ket,
    //             "nilai" => round($n1 / $hitung),
    //             "ket" => $nilai->mapel->ket,
    //             "catatan" => ucfirst(strtolower($catatan.". ".$guru)),
    //         ];

            

    //     }
     
        

    //     $pdf = PDF::loadView("laporan.raport.nilai", [
    //         "siswa" => $siswa,
    //         "sekolah" => $sekolah,
    //         "detail" => $detail,
    //         "identitas" => $identitas,
    //         "mapel" => $mapel,
    //     ]);

    //     return $pdf->stream("cover_".str_replace(" ", "", $siswa->nama).".pdf");


    // }

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
