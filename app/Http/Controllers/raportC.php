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
use App\Models\detailraportM;
use App\Models\ujianM;
use Illuminate\Http\Request;
use Auth;
use PDF;

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
                            "nilai" => $totalnilaisiswa = $totalnilaisiswa + 0,
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
               
                $hasil = ($totalnilai1 + $totalnilai2) / 2;

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
                ->where('idkelas', $idkelas)->groupBy("idmapel")->get();
                
                $data = [];
                $ratarata = 0;
                foreach ($mapel as $m) {
                    $idmapel = $m->idmapel;
                    $detailraport = detailraportM::where("idraport", $idraport)->where("idmapel", $m->idmapel)
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
    public function hapus(raportM $raportM, $iddetailraport)
    {
        try {
            $iduser = Auth::user()->iduser;
            $cek = detailraportM::where("iduser", $iduser)
            ->where("iddetailraport", $iddetailraport);

            if($cek->count() === 0) {
                return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
            }
            
            $cek->delete();
            return redirect()->back()->with("success", "Data berhasil dihapus")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }

        raportM::destroy($idraport);
        return redirect()->back()->with("warning", "success")->withInput();
    }
}
