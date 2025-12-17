<?php

namespace App\Http\Controllers;

use App\Models\raportM;
use App\Models\identitasM;
use App\Models\User;
use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\mapelM;
use App\Models\walikelasM;
use App\Models\jurusanM;
use App\Models\nilairaportM;
use App\Models\elemenM;
use App\Models\sinkronM;
use App\Models\detailraportM;
use App\Models\ujianM;
use App\Models\pembinaexM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $pembinaex = pembinaexM::where("iduser", $iduser)->count();

        $posisi = AUth::user()->identitas->posisi;
        $posisi = identitasM::where("iduser", $iduser)->first()->posisi;
        $keyword = empty($request->keyword)?"":$request->keyword;

        if($posisi == "admin") {
            $raport = raportM::where("namaraport", "like", "%$keyword%")
            ->orWhere("semester", "like", "$keyword%")
            ->orderBy("idraport", "desc")
            ->paginate(15);

        }else {
            $raport = raportM::where("namaraport", "like", "%$keyword%")
            ->where("semester", "like", "$keyword%")
            ->where("ket", "!=", 1)
            ->orderBy("idraport", "desc")
            ->paginate(15);

        }


        $raport->appends($request->all());

        $kelas = kelasM::get();
        $mapel = mapelM::get();
        $jurusan = jurusanM::get();
        $ketraport = raportM::where("ket", 0)->get();
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
            "ketraport" => $ketraport,
            "pembinaex" => $pembinaex,
        ]);
    }

    public function sinkron(Request $request, $idraport)
    {

        try {

            $iduser = Auth::user()->iduser;

            $raport = raportM::where("idraport", $idraport)->select("idtarget")->first();

            detailraportM::where("iduser", $iduser)->where("idraport", $idraport)->delete();

            $detailraport = detailraportM::where("iduser", $iduser)->where("idraport", $raport->idtarget)->get();
            // dd(count($detailraport));

            foreach ($detailraport as $dr) {
                // dd($dr->toArray());
                $cek = detailraportM::where("iduser", $iduser)->where("idtarget", $dr->iddetailraport)->count();
                if($cek == 0) {
                    $dera = new detailraportM;
                    $dera->iduser = $iduser;
                    $dera->idraport = $idraport;
                    $dera->idkelas = $dr->idkelas;
                    $dera->idmapel = $dr->idmapel;
                    $dera->idjurusan = $dr->idjurusan;
                    $dera->idtarget = $dr->iddetailraport;
                    $dera->save();

                    $idraportbaru = $dera->iddetailraport;
                    $elemen = elemenM::where("iddetailraport", $dr->iddetailraport)->where("iduser", $iduser)->get();

                    // dd(count($elemen)." ".$iddetailraport);
                    foreach ($elemen as $el) {
                        // dd($dr->toArray());
                        $cek = elemenM::where("iddetailraport", $dr->iddetailraport)->where("idtarget", $el->idelemen)->where("iduser", $iduser)->count();
                        if($cek == 0) {
                            $elementambah = new elemenM;
                            $elementambah->iddetailraport = $idraportbaru;
                            $elementambah->iduser = $iduser;
                            $elementambah->elemen = $el->elemen;
                            $elementambah->persen = $el->persen;
                            $elementambah->idtarget = $el->idelemen;
                            $elementambah->save();

                            $nilairaport = nilairaportM::where("iddetailraport", $dr->iddetailraport)->where("idelemen", $elementambah->idtarget)->get();
                            foreach ($nilairaport as $nr) {
                                // dd($dr->toArray());
                                $cek = nilairaportM::where("idtarget", $nr->idnilairaport)->where("idelemen", $elementambah->idtarget)->count();
                                if($cek == 0) {
                                    $nilairaporttambah = new nilairaportM;
                                    $nilairaporttambah->iddetailraport = $idraportbaru;
                                    $nilairaporttambah->idsiswa = $nr->idsiswa;
                                    $nilairaporttambah->nilai = $nr->nilai;
                                    $nilairaporttambah->idelemen = $elementambah->idelemen;
                                    $nilairaporttambah->idtarget = $nr->idnilairaport;
                                    $nilairaporttambah->save();
                                }
                            }

                        }
                    }
                }


            }

            $sinkron = new sinkronM;
            $sinkron->idraport = $idraport;
            $sinkron->iduser = $iduser;
            $sinkron->save();

            return redirect()->back()->with("success", "Sinkron Berhasil")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();
        }




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

        $raport = raportM::where("ket", 0)->get();
        // dd($raport);


        return view("pages.raport.detailraport", [
            "judul" => $judul,
            "idraport" => $idraport,
            "user" => $user,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
            "mapel" => $mapel,
            "keyword" => $keyword,
            "detailraport" => $detailraport,
            "raport" => $raport,
        ]);

    }

    public function ubahjurusan(Request $request, $iddetailraport)
    {
        $request->validate([
            "jurusan" => "required",
        ]);

        try{
            $jurusan = $request->jurusan;
            $data = detailraportM::where("iddetailraport", $iddetailraport)->first();
            $idmapel = $data->idmapel;
            $idjurusan = $data->idjurusan;
            $iduser = $data->iduser;
            $idraport = $data->idraport;

            $cek = detailraportM::where("idjurusan", $jurusan)
            ->where("idmapel", $idmapel)
            ->where("iduser", $iduser)
            ->where("idraport", $idraport)
            ->count();

            if($cek == 0) {
                $data->update([
                    "idjurusan" => $jurusan,
                ]);
                return redirect()->back()->with('success', 'Update Berhasil');
            }else {
                return redirect()->back()->with('error', 'Jurusan telah ada');
            }


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }

    }

    public function ubahnamamapel(Request $request, $iddetailraport)
    {
        $request->validate([
            "idmapel" => "required",
        ]);

        try{
            $idmapel = $request->idmapel;
            $data = detailraportM::where("iddetailraport", $iddetailraport)->first();
            $idjurusan = $data->idjurusan;
            $iduser = $data->iduser;
            $idraport = $data->idraport;

            $cek = detailraportM::where("idjurusan", $idjurusan)
            ->where("idmapel", $idmapel)
            ->where("iduser", $iduser)
            ->where("idraport", $idraport)
            ->count();

            if($cek == 0) {
                $data->update([
                    "idmapel" => $idmapel,
                ]);
                return redirect()->back()->with('success', 'Update Berhasil');
            }else {
                return redirect()->back()->with('error', 'Jurusan telah ada');
            }


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }

    }

    public function pindah(Request $request, $iddetailraport)
    {
        $request->validate([
            "idraport" => "required|numeric",
        ]);

        $detailraport = detailraportM::where("iddetailraport", $iddetailraport)->first();

        $idsiswa = siswaM::where("idkelas", $detailraport->idkelas)
        ->where("idjurusan", $detailraport->idjurusan)
        ->select("idsiswa")->get()->toArray();

        $ujian = ujianM::where("idraport", $detailraport->idraport)
        ->where("idmapel", $detailraport->idmapel)
        ->whereIn("idsiswa", $idsiswa)->update([
            "idraport" => $request->idraport,
        ]);

        $detailraport->update([
            "idraport" => $request->idraport,
        ]);

        return redirect()->back()->with("success", "data berhasil dipindahkan!");


        

    }
    public function duplikat(Request $request, $iddetailraport)
    {
        $request->validate([
            "jurusan" => "required",
        ]);

        // try{
            $iduser = Auth::user()->iduser;
            $jurusan = $request->jurusan;
            $data = detailraportM::where("iddetailraport", $iddetailraport)->first();
            $idmapel = $data->idmapel;
            $idjurusan = $data->idjurusan;
            $iduser = $data->iduser;
            $idraport = $data->idraport;

            $elemen = elemenM::where("iddetailraport", $iddetailraport)->get();



            $cek = detailraportM::where("idjurusan", $jurusan)
            ->where("idmapel", $idmapel)
            ->where("iduser", $iduser)
            ->where("idraport", $idraport)
            ->count();

            if($cek == 0) {
                $data = $data->toArray();
                unset($data["iddetailraport"]);
                $data["idjurusan"] = $jurusan;
                $data["iduser"] = $iduser;
                $new = detailraportM::create($data);
                $iddetailraport = $new->iddetailraport;

                foreach ($elemen as $e) {
                    $elm = $e->toArray();
                    unset($elm["idelemen"]);
                    $elm["iduser"] = $iduser;
                    $elm["iddetailraport"] = $iddetailraport;

                    elemenM::create($elm);
                }

                return redirect()->back()->with('success', 'Update Berhasil');
            }else {
                return redirect()->back()->with('error', 'Data sudah ada atau telah di duplikat');
            }


        // }catch(\Throwable $th){
        //     return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        // }

    }



    public function cetak(Request $request, $iddetailraport)
    {
        try {
            $iduser = Auth::user()->iduser;

            $detailraport = detailraportM::where("iduser", $iduser)
            ->where("iddetailraport", $iddetailraport)
            ->count();
            if($detailraport == 0) {
                return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
            }

            $detailraport = detailraportM::where("iduser", $iduser)
            ->where("iddetailraport", $iddetailraport)
            ->first();

            $namakelas = $detailraport->kelas->namakelas;
            $idraport = $detailraport->raport->idraport;
            $idkelas = $detailraport->kelas->idkelas;
            $namamapel = $detailraport->mapel->namamapel;
            $idmapel = $detailraport->mapel->idmapel;
            $idjurusan = $detailraport->jurusan->idjurusan;


            $siswa = siswaM::where('idkelas', $idkelas)
            ->where("idjurusan", $idjurusan)->get();

            foreach ($siswa as $s) {

                $idsiswa = $s->idsiswa;
                $elemen = elemenM::where("iddetailraport", $iddetailraport)
                ->where("iduser", $iduser)->get();

                $nilaisiswa = [];
                $totalnilaisiswa = 0;
                foreach ($elemen as $e) {
                    $nilai = nilairaportM::where("idsiswa", $s->idsiswa)
                    ->where("idelemen", $e->idelemen)
                    ->get();

                    if(count($nilai)==0) {
                        $nilaisiswa[] = [
                            "namaelemen" => $e->elemen,
                            "nilai" => 0,
                        ];

                    }

                    foreach ($nilai as $n) {
                        $nilaisiswa[] = [
                            "namaelemen" => $e->elemen,
                            "nilai" => (int)(empty($n->nilai)?0:$n->nilai),
                        ];


                        $totalnilaisiswa = $totalnilaisiswa + (empty($n->nilai)?0:$n->nilai);

                    }
                }

                $totalnilai1 = $totalnilaisiswa / count($elemen);


                $ujian = ujianM::where("idraport", $idraport)
                ->where("idsiswa", $idsiswa)
                ->where("idmapel", $idmapel)
                ->first();

                $praktek = (int)empty($ujian->lisan)?0:$ujian->lisan;
                $nonpraktek = (int)empty($ujian->nonlisan)?0:$ujian->nonlisan;

                if($praktek != 0 && $nonpraktek != 0) {
                    $totalnilai2 = ($praktek + $nonpraktek) / 2;
                }else {
                    $totalnilai2 = $praktek + $nonpraktek;
                }

                $hasil = ($totalnilai1*0.8) + ($totalnilai2 * 0.2);

                $data[] = [
                    "namasiswa" => $s->nama,
                    "tugas" => $nilaisiswa,
                    "praktek" => $praktek,
                    "nonpraktek" => $nonpraktek,
                    "hasil" => $hasil,
                ];

            }

            $data = collect($data);
            $data = $data->sortByDesc("hasil");

            $pdf = PDF::loadView("laporan.raport.penilaian", [
                "data" => $data,
                "elemen" => $elemen,
            ])->setPaper('a4', 'landscape');

            return $pdf->stream($namamapel.".pdf");






        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function ranking(Request $request, $idraport)
    {
        // try {

            $ididentitas = Auth::user()->identitas->ididentitas;
            $idkelas = walikelasM::where("ididentitas", $ididentitas)->first()->idkelas;
            $idjurusan = walikelasM::where("ididentitas", $ididentitas)->first()->idjurusan;

            $siswa = siswaM::where('idkelas', $idkelas)
            ->where("idjurusan", $idjurusan)->get();

            $hasil = [];
            foreach ($siswa as $s) {
                $idsiswa = $s->idsiswa;
                $mapel = detailraportM::where("idraport", $idraport)->select("idmapel")
                ->where("idjurusan", $idjurusan)
                ->where('idkelas', $idkelas)->groupBy("idmapel")->get();

                $data = [];
                $ratarata = 0;
                foreach ($mapel as $m) {
                    $idmapel = $m->idmapel;
                    $detailraport = detailraportM::where("idraport", $idraport)->where("idmapel", $m->idmapel)
                    ->where('idjurusan', $idjurusan)
                    ->where('idkelas', $idkelas)
                    ->get();
                    // dd($detailraport->toArray());
                    $i = 1;


                    $tampung = 0;
                    $tampung2 = [];
                    foreach ($detailraport as $dr) {
                        $nilairaport = nilairaportM::join("elemen", "elemen.idelemen", "nilairaport.idelemen")
                        ->select("nilairaport.*")
                        ->where("nilairaport.iddetailraport", $dr->iddetailraport)
                        ->where("nilairaport.idsiswa", $s->idsiswa)
                        ->get();

                        // dd($nilairaport);
                        foreach ($nilairaport as $n) {
                            $tampung = $tampung + $n->nilai;

                            $tampung2[] = [
                                "elemen" => $n->elemen->elemen,
                                "nama" => $n->nilai,
                            ];

                        }



                    }

                    if($tampung != 0) {
                        $general = round($tampung / count($tampung2));
                    }else {
                        $general = $tampung;
                    }



                    $ujian = ujianM::where("idraport", $idraport)
                    ->where("idsiswa", $idsiswa)
                    ->where("idmapel", $idmapel)
                    ->first();

                    $praktek = (int)empty($ujian->lisan)?0:$ujian->lisan;
                    $nonpraktek = (int)empty($ujian->nonlisan)?0:$ujian->nonlisan;

                    if($praktek != 0 && $nonpraktek != 0) {
                        $totalnilai2 = ($praktek + $nonpraktek) / 2;
                    }else {
                        $totalnilai2 = $praktek + $nonpraktek;
                    }


                    $data[] = [
                        "nilai" => $tampung2,
                        "mapel" => $m->mapel->namamapel,
                        "praktek" => $praktek,
                        "nonpraktek" => $nonpraktek,
                        "hasil" => ($general + $totalnilai2) / 2,
                    ];

                    $ratarata = $ratarata + (($general + $totalnilai2) / 2);

                    // $hasil = ($rata + $totalnilai2) / 2;


                }
                // dd($ratarata);
                $ratarata = $ratarata / count($mapel);
                $hasil[] = [
                    "namasiswa" => $s->nama,
                    "data" => $data,
                    "ratarata" => round($ratarata),
                ];


            }

            $data = collect($hasil);
            $data = $data->sortByDesc("ratarata");

            // dd($data->toArray());

            // $data = collect($data);
            // $data = $data->sortByDesc("hasil");

            $pdf = PDF::loadView("laporan.raport.ranking", [
                "data" => $data,
                "mapel" => $mapel,
                // "elemen" => $elemen,
            ])->setPaper('a4', 'landscape');

            return $pdf->stream("asdasd.pdf");






        // } catch (\Throwable $th) {
        //     return redirect()->back()->withInput();
        // }
    }

    public function leger(Request $request, $idraport)
    {
        $raport = raportM::where("idraport", $idraport)->first();
        $walikelas = Auth::user()->identitas->walikelas;
        $idjurusan = $walikelas->identitas->walikelas->idjurusan;
        $idkelas = $walikelas->identitas->walikelas->idkelas;

        $detailraport = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
        ->where("idjurusan", $idjurusan)->orderBy("idmapel", "asc")->select("idmapel")->groupBy("idmapel")->get();

        // dd($detailraport->toArray());
        
        $kejuruan = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
        ->where("idjurusan", $idjurusan)->whereHas('mapel', function ($query) {
            $query->where('ket', 'kejuruan');
        })->distinct()->count('idmapel');

        if($raport->kelas->namakelas=="XI") {
            $kejuruan = $kejuruan + 1;
        }
        
        $umum = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
        ->where("idjurusan", $idjurusan)->whereHas('mapel', function ($query) {
            $query->where('ket', 'umum');
        })->distinct()->count('idmapel');
        
        $murid = siswaM::where("idkelas", $idkelas)->where("idjurusan", $idjurusan)->get();
        $validasijurusan = $kejuruan;
            
        $data = [];
        foreach ($murid as $siswa) {

            $mapel = [];
            $ratarata = 0;
            $pilihanIteration = 0;

            // $kejuruan1 = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
            // ->where("idjurusan", $idjurusan)->whereHas('mapel', function ($query) {
            //     $query->where('ket', 'kejuruan');
            // })->distinct()->count('idmapel');            

            $cek_mapel = [];
            foreach ($detailraport as $detail) {
                $mapelpilihan = null;

                // if($detail->mapel->ket=="pilihan") {
                //     // $cek1 = detailraportM::where('idraport', $raport->idraport)
                //     // ->where("idkelas", $raport->idkelas)
                //     // ->where("idjurusan", $idjurusan)
                //     // ->where("idmapel", $detail->mapel->idmapel)
                //     // ->select("iddetailraport")->first();
                    
                //     $cek_mapel[] = $detail->mapel->namamapel;
                //     $cek2 = nilairaportM::where("iddetailraport", $detail->iddetailraport)
                //     ->where("idsiswa", $siswa->idsiswa)->count();
                    
                //     if($cek2 == 0) {
                //         $pilihanIteration++;
                //         continue;
                //         // dd($cek2);
                //     }else {
                //         if($validasijurusan == $kejuruan1) {
                //             $mapelpilihan = "Mapel Pilihan";
                //             $kejuruan1 = $kejuruan1 + 1;
                //             // dd($detail->mapel->toArray());
                //         }
                //     }
                //     // dd($cek->toArray());
                // }

                // dd($detailraport->toArray());
                $idmapel = $detail->idmapel;
                if($detail->mapel->ket=="pilihan") {
                    $iddetailraport = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
                    ->where("idmapel", $detail->mapel->idmapel)
                    ->select("iddetailraport")->get();
                    
                    $datanilai = nilairaportM::whereIn("iddetailraport", $iddetailraport->toArray())
                    ->where("idsiswa", $siswa->idsiswa)->get();
                    
                    $mapelpilihan = "Mapel Pilihan";

                    if($pilihanIteration > 0) {
                        continue;
                    }
                    
                    $pilihanIteration++;


                }else {
                    $iddetailraport = detailraportM::where('idraport', $raport->idraport)->where("idkelas", $raport->idkelas)
                    ->where("idjurusan", $idjurusan)
                    ->where("idmapel", $detail->mapel->idmapel)
                    ->select("iddetailraport")->get();
    
                    $datanilai = nilairaportM::whereIn("iddetailraport", $iddetailraport->toArray())
                    ->where("idsiswa", $siswa->idsiswa)->get();
                }

                $n1 = 0;
                $n2 = 0;
                
                // if($detail->mapel->namamapel == "Pendidikan Agama & Budipekerti") {
                //     dd($datanilai);
                // }

                foreach ($datanilai as $n) {
                    $n1 = $n1 + $n->nilai;
                }

                $ujian = ujianM::where("idraport", $idraport)
                ->where("idsiswa", $siswa->idsiswa)
                ->where("idmapel", $idmapel)
                ->first();
                $ujian1 = $ujian ? $ujian->lisan : 0;
                $ujian2 = $ujian ? $ujian->nonlisan : 0;
                
                if($ujian1 > 0 && $ujian2 > 0) {
                    $n2 = round(($ujian1 + $ujian2) / 2);
                }else {
                    $n2 = round($ujian1 + $ujian2);
                }
                
                $n1 = $n1;
                
                if(count($datanilai) > 0) {
                    $n1 = $n1 / count($datanilai);
                }
                
                
                if($raport->kategori == "new") {
                    $n3 = round(($n1*0.8) + ($n2*0.2));
                }else {
                    $n3 = round((($n1) + ($n2)) / 2);
                }
                
                

                $mapel[] = collect([
                    "namamapel" => empty($mapelpilihan) ? $detail->mapel->namamapel : $mapelpilihan,
                    "ket" => $detail->mapel->ket,
                    "nilai" => $n3,
                ]);

                

                $ratarata = $ratarata + $n3;
            }

            $data[] = collect([
                "ratarata" => $ratarata,
                "hasil" => round($ratarata / (count($detailraport) - $pilihanIteration), 2),
                "siswa" => $siswa->nama,
                "nisn" => $siswa->nisn,
                "mapel" => $mapel,
            ]);

            
            
        }
        

        $collect = collect($data);
        $sort = $collect->sortByDesc("ratarata");

        // dd($sort->toArray());
        // dd($sort);

        // foreach ($sort->first()["mapel"] as $mapel) {
        //     dd($mapel[]);
        // }

        // dd(count($sort->first()["mapel"]));
        // dd($kejuruan." ".$umum);
        
        $pdf = PDF::loadView("laporan.raport.leger", [
            "data" => $sort,
            "raport" => $raport,
            "kejuruan" => $kejuruan,
            "umum" => $umum,
            // "elemen" => $elemen,
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream("Leger.pdf");


        


        // $data[] = [
        //     "nilai" => $tampung2,
        //     "mapel" => $m->mapel->namamapel,
        //     "ket" => $m->mapel->ket,
        //     "praktek" => $praktek,
        //     "nonpraktek" => $nonpraktek,
        //     "hasil" => round(($general + $totalnilai2) / 2),
        // ];

        // $ratarata = $ratarata + (($general + $totalnilai2) / 2);


        // $output[] = [
        //     "jurusan" => $jur->jurusan,
        //     "idjurusan" => $jur->idjurusan,
        //     "idkelas" => $idkelas,
        //     "namajurusan" => $jur->namajurusan,
        //     "kelas" => $namakelas,
        //     "data" => $hasil,
        //     "jumlahmapel" => count($mapel),
        //     "mapel" => $mapel,
        //     "kejuruan" => $kejuruan,
        //     "umum" => $umum,
        //     "judul" => $namaraport,
        //     "tahun" => $tahunraport,
        // ];
        
        
        
        // try {
            // $raport = raportM::where("idraport", $idraport)->first();
            // $tahunraport = $raport->tahun."/".($raport->tahun + 1);
            // $namaraport = $raport->namaraport;
            // if($namaraport == "raport uts") {
            //     $namaraport = "ASESMEN TENGAH SEMESTER";
            // }
            // $namaraport = $namaraport." ".strtoupper($raport->semester);


            // $ididentitas = Auth::user()->identitas->ididentitas;


            // if(Auth::user()->identitas->posisi == "walikelas") {
            //     $idjurusan = Auth::user()->identitas->walikelas->idjurusan;
            //     $idkelas = Auth::user()->identitas->walikelas->idkelas;

            //     $jurusan = jurusanM::where("idjurusan", $idjurusan)->get();
            // }else {
            //     if($request->idjurusan == "all") {
            //         $jurusan = jurusanM::get();
            //     }else {
            //         $jurusan = jurusanM::where("idjurusan", $request->idjurusan)->get();
            //     }
            //     $idkelas = $request->idkelas;
            // }

            // $output = [];
            // foreach ($jurusan as $jur) {

            //     $namakelas = kelasM::where("idkelas", $idkelas)->first()->namakelas;
            //     $idjurusan = $jur->idjurusan;

            //     $siswa = siswaM::where('idkelas', $idkelas)
            //     ->where("idjurusan", $idjurusan)->get();




            //     // dd($mapel);
            //     $hasil = [];
            //     foreach ($siswa as $s) {

            //         $mapel = detailraportM::where("idraport", $idraport)->select("idmapel")
            //         ->where("idjurusan", $jur->idjurusan)
            //         ->whereHas("mapel", function ($query) {
            //             $query->where("ket", "!=", "pilihan");
            //         })
            //         ->where('idkelas', $idkelas)->groupBy("idmapel")->get();

            //         $idsiswa = $s->idsiswa;

            //         // dd($mapel);
                    
            //         // if(count($mapel) == 0) {
            //         //     continue;
            //         // }

            //         $data = [];
            //         $ratarata = 0;
            //         $kejuruan = 0;
            //         $umum = 0;
                    

            //         foreach ($mapel as $m) {
            //             if($m->mapel->ket == "kejuruan") {
            //                 $kejuruan = $kejuruan + 1;
            //             }else {
            //                 $umum = $umum + 1;
            //             }
            //             $ceknamamapel = $m->mapel->namamapel;

            //             $idmapel = $m->idmapel;
            //             $detailraport = detailraportM::where("idraport", $idraport)->where("idmapel", $m->idmapel)
            //             ->where('idjurusan', $jur->idjurusan)
            //             ->where('idkelas', $idkelas)
            //             ->orderBy("iddetailraport", "desc")
            //             ->get();
            //             // dd($detailraport->toArray());
            //             $i = 1;



            //             $tampung = 0;
            //             $tampung2 = [];
            //             foreach ($detailraport as $dr) {
            //                 $nilairaport = nilairaportM::join("elemen", "elemen.idelemen", "nilairaport.idelemen")
            //                 ->select("nilairaport.*")
            //                 ->where("nilairaport.iddetailraport", $dr->iddetailraport)
            //                 ->where("nilairaport.idsiswa", $s->idsiswa)
            //                 ->get();





            //                 // dd($nilairaport);
            //                 foreach ($nilairaport as $n) {
            //                     $tampung = $tampung + $n->nilai;

            //                     $tampung2[] = [
            //                         "elemen" => $n->elemen->elemen,
            //                         "nama" => $n->nilai,
            //                     ];

            //                 }




            //             }



            //             if($tampung != 0) {
            //                 $general = round($tampung / count($tampung2));
            //             }else {
            //                 $general = $tampung;
            //             }

            //             // if($ceknamamapel == "Pendidikan Agama & Budipekerti") {
            //             //     dd($general);
            //             // }



            //             $ujian = ujianM::where("idraport", $idraport)
            //             ->where("idsiswa", $idsiswa)
            //             ->where("idmapel", $idmapel)
            //             ->first();

                        

            //             $praktek = (int)empty($ujian->lisan)?0:$ujian->lisan;
            //             $nonpraktek = (int)empty($ujian->nonlisan)?0:$ujian->nonlisan;

            //             if($praktek != 0 && $nonpraktek != 0) {
            //                 $totalnilai2 = ($praktek + $nonpraktek) / 2;
            //             }else {
            //                 $totalnilai2 = $praktek + $nonpraktek;
            //             }


            //             $data[] = [
            //                 "nilai" => $tampung2,
            //                 "mapel" => $m->mapel->namamapel,
            //                 "ket" => $m->mapel->ket,
            //                 "praktek" => $praktek,
            //                 "nonpraktek" => $nonpraktek,
            //                 "hasil" => round(($general + $totalnilai2) / 2),
            //             ];

            //             $ratarata = $ratarata + (($general + $totalnilai2) / 2);

            //             // $hasil = ($rata + $totalnilai2) / 2;


            //         }
            //         // dd($ratarata);
            //         $jumlahnilai = $ratarata;
            //         if($ratarata > 0) {
            //             $ratarata = $ratarata / count($mapel);
            //         }else {
            //             $ratarata = 0;
            //         }
            //         $hasil[] = [
            //             "namasiswa" => $s->nama,
            //             "nisn" => sprintf("%010s",$s->nisn),
            //             "data" => $data,
            //             "ratarata" => round($ratarata),
            //             "jumlahnilai" => round($jumlahnilai),
            //         ];

            //         // dd($hasil);


            //     }

            //     if($request->opsi == "urut") {
            //         $hasil = collect($hasil);
            //         $hasil = $hasil->sortByDesc("jumlahnilai");
            //         // dd($hasil);
            //     }

            //     $output[] = [
            //         "jurusan" => $jur->jurusan,
            //         "idjurusan" => $jur->idjurusan,
            //         "idkelas" => $idkelas,
            //         "namajurusan" => $jur->namajurusan,
            //         "kelas" => $namakelas,
            //         "data" => $hasil,
            //         "jumlahmapel" => count($mapel),
            //         "mapel" => $mapel,
            //         "kejuruan" => $kejuruan,
            //         "umum" => $umum,
            //         "judul" => $namaraport,
            //         "tahun" => $tahunraport,
            //     ];
                


            // }

            // dd($output);
            // // dd($request->opsi);


            // $pdf = PDF::loadView("laporan.raport.leger", [
            //     "data" => $output,
            //     "raport" => $raport,
            //     // "elemen" => $elemen,
            // ]);
            // $pdf->setPaper('a4', 'landscape');

            // return $pdf->stream("Leger.pdf");






        // } catch (\Throwable $th) {
        //     return redirect()->back()->withInput();
        // }
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
    public function update(Request $request, raportM $raportM, $idraport)
    {
        try {

            $data = $request->all();
            $data["fase"] = strtoupper($request->fase);
            raportM::where("idraport", $idraport)->first()->update($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
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

    public function hapus(raportM $raportM, $iddetailraport)
    {
        try {
            $iduser = Auth::user()->iduser;
            $cek = detailraportM::where("iduser", $iduser)
            ->where("iddetailraport", $iddetailraport);

            if($cek->count() === 0) {
                return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
            }

            $idraport = $cek->first()->idraport;
            $cek->delete();
            return redirect()->back()->with("success", "Data berhasil dihapus")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }

        raportM::destroy($idraport);
        return redirect()->back()->with("warning", "success")->withInput();
    }
}
