<?php

namespace App\Http\Controllers;

use App\Models\nilairaportM;
use App\Models\siswaM;
use App\Models\raportM;
use App\Models\elemenM;
use App\Models\subelemenM;
use App\Models\detailraportM;
use App\Models\catatanM;
use App\Models\jurusanM;
use App\Models\ujianM;
use App\Models\kehadiranM;
use App\Models\kelasM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Auth;

class nilaiC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $iddetailraport)
    {
        try {
            $iduser = Auth::user()->iduser;
            $detailraport = detailraportM::join("raport", "raport.idraport", "detailraport.idraport")
            ->join("mapel", "mapel.idmapel", "detailraport.idmapel")
            ->where("detailraport.iddetailraport", $iddetailraport)
            ->select("detailraport.*", "raport.namaraport", "mapel.namamapel", "mapel.idmapel", "mapel.ket")
            ->first();

            $idkelas = $detailraport->idkelas;
            $idjurusan = $detailraport->idjurusan;
            $idraport = $detailraport->idraport;
            $judul = "PENILAIAN". strtoupper($detailraport->namaraport);
            $mapel = ucwords($detailraport->namamapel);
            $idmapel = ucwords($detailraport->idmapel);

            $elemen = elemenM::where("iddetailraport", $iddetailraport)
            ->where("iduser", $iduser)
            ->get();

            $dataJurusan = jurusanM::get();

            $jmlelemen = elemenM::where("iddetailraport", $iddetailraport)
            ->where("iduser", $iduser)
            ->get();

            $keyword = empty($request->keyword)?"":$request->keyword;
            $jurusan = empty($request->jurusan)?"":$request->jurusan;


            $siswa = siswaM::where("idjurusan", $idjurusan)
            ->where("idkelas", $idkelas)
            ->where("nama", "like", "%$keyword%")
            ->orderBy("nama", "asc")
            ->paginate(10);

            $siswa->appends($request->all());

            return view("pages.nilai.nilai", [
                "iddetailraport" => $iddetailraport,
                "judul" => $judul,
                "mapel" => $mapel,
                "idmapel" => $idmapel,
                "siswa" => $siswa,
                "keyword" => $keyword,
                "idraport" => $idraport,
                "elemen" => $elemen,
                "iduser" => $iduser,
                "jmlelemen" => $jmlelemen,
                "jurusan" => $jurusan,
                "detailraport" => $detailraport,
                "dataJurusan" => $dataJurusan,
            ]);

        } catch (\Throwable $th) {
            return redirect('raport')->with("error", "terjadi kesalahan");
        }
    }

    public function ujian(Request $request, $idraport)
    {
        try {
            $iduser = Auth::user()->iduser;
            $detailraport = detailraportM::where("idraport", $idraport)
            ->where("iduser", $iduser)->count();

            if($detailraport == 0 ){
                return redirect()->back()->with("error", "terjadi kesalahan");
            }

            $data = $request->all();

            $ujian = ujianM::where("idsiswa", $request->idsiswa)
            ->where("idmapel", $request->idmapel)
            ->where("idraport", $idraport);

            if($ujian->count() == 0) {
                $data["idraport"] = $idraport;
                ujianM::create($data);
            }else {
                $ujian->first()->update($data);
            }
            return redirect()->back()->with("success", "Nilai Ujian Berhasil Diinput");

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Terjadi kesalahan");
        }


    }





    public function kehadiran(Request $request, $idraport)
    {
        try{
            $iduser = Auth::user()->iduser;

            $data = $request->all();
            $cek = kehadiranM::where("idsiswa", $request->idsiswa)->where("idraport", $idraport);

            if($cek->count() == 0) {
                $data["idraport"] = $idraport;
                kehadiranM::create($data);
            }else {
                $cek->first()->update($data);
            }
            return redirect()->back()->with("toast_success", "success");
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }


    }

    public function catatan(Request $request, $iddetailraport)
    {
        $iduser = Auth::user()->iduser;
        $detailraport = detailraportM::where("iddetailraport", $iddetailraport)
        ->where("iduser", $iduser)->count();

        // dd($request->idsiswa);
        if($detailraport == 0 ){
            return redirect()->back()->with("error", "terjadi kesalahan");
        }

        $data = $request->all();
        $cek = catatanM::where("idsiswa", $request->idsiswa)->where("iddetailraport", $iddetailraport);

        if($cek->count() == 0) {
            $data["iddetailraport"] = $iddetailraport;
            catatanM::create($data);
        }else {
            $cek->first()->update($data);
        }
        return redirect()->back()->with("toast_success", "Berhasil memberikan catatan");
    }

    public function elemen(Request $request, $iddetailraport)
    {
        try {
            $elemen = $request->elemen;
            $iduser = Auth::user()->iduser;

            $tambah = new elemenM;
            $tambah->iddetailraport = $iddetailraport;
            $tambah->elemen = $elemen;
            $tambah->iduser = $iduser;
            $tambah->save();

            return redirect()->back()->with("toast_success", "Elemen berhasil ditambahkan")->withInput();


        } catch (\Throwable $th) {
            return redirect('raport')->with("error", "terjadi kesalahan");
        }

    }

    public function hapuselemen(Request $request, $idelemen) {
        try {
            $iduser = Auth::user()->iduser;

            $cek = elemenM::where("idelemen", $idelemen)
            ->where("iduser", $iduser);
            if($cek->count() == 0) {
                return redirect('raport')->with("error", "terjadi kesalahan");
            }
            $cek->delete();
            return redirect()->back()->with("toast_success", "Elemen berhasil dihapus")->withInput();


        } catch (\Throwable $th) {
            return redirect('raport')->with("error", "terjadi kesalahan");
        }
    }

    public function ubahelemen(Request $request, $idelemen)
    {
        try {
            $iduser = Auth::user()->iduser;

            $cek = elemenM::where("idelemen", $idelemen)
            ->where("iduser", $iduser);
            if($cek->count() == 0) {
                return redirect('raport')->with("error", "terjadi kesalahan");
            }

            $data = $request->all();
            // dd($data);

            $cek->first()->update($data);

            return redirect()->back()->with("toast_success", "Elemen berhasil ditambahkan")->withInput();


        } catch (\Throwable $th) {
            return redirect('raport')->with("error", "terjadi kesalahan");
        }

    }


    public function nilai(Request $request, $iddetailraport)
    {
        try {
            $iduser = Auth::user()->iduser;
            $idsiswa = $request->idsiswa;

            $elemen = elemenM::where("iddetailraport", $iddetailraport)
            ->where("iduser", $iduser)
            ->get();

            $notif = true;

            foreach ($elemen as $e) {

                $name = "elemen".$e->idelemen;
                $nilai = $request->$name;
                $cek = nilairaportM::where("iddetailraport", $iddetailraport)
                ->where("idelemen", $e->idelemen)
                ->where("idsiswa", $idsiswa);

                if($nilai != null) {
                    if($cek->count() == 0) {
                        $tambah = new nilairaportM;
                        $tambah->iddetailraport = $iddetailraport;
                        $tambah->idelemen = $e->idelemen;
                        $tambah->idsiswa = $idsiswa;
                        $tambah->nilai = $nilai;
                        $tambah->save();
                    }else {
                        $cek->first()->update([
                            "nilai" => $nilai,
                        ]);

                    }
                }else {
                    $notif = false;
                }
            }

            if($notif == true) {
                return redirect()->back()->with("success", "Nilai berhasil diupdate")->withInput();

            }else {
                return redirect()->back()->with("warning", "Harap mengisi semua nilai")->withInput();
            }


        } catch (\Throwable $th) {
            return redirect('raport')->with("error", "terjadi kesalahan");
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nilairaportM  $nilairaportM
     * @return \Illuminate\Http\Response
     */
    public function show(nilairaportM $nilairaportM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nilairaportM  $nilairaportM
     * @return \Illuminate\Http\Response
     */
    public function edit(nilairaportM $nilairaportM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nilairaportM  $nilairaportM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nilairaportM $nilairaportM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nilairaportM  $nilairaportM
     * @return \Illuminate\Http\Response
     */
    public function destroy(nilairaportM $nilairaportM)
    {
        //
    }
}
