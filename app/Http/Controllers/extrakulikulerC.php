<?php

namespace App\Http\Controllers;

use App\Models\pembinaexM;
use App\Models\penilaianexM;
use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Auth;
use Illuminate\Http\Request;

class extrakulikulerC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $idraport)
    {
        $iduser = Auth::user()->iduser;
        $pembinaex = pembinaexM::where("iduser", $iduser)->get();

        return view("pages.extrakulikuler.extrakulikuler", [
            "pembinaex" => $pembinaex,
            "idraport" => $idraport,
        ]);

    }

    public function kelola(Request $request, $idraport, $idpembinaex) {

        $keyword = empty($request->keyword)?'':$request->keyword;
        $idkelas = empty($request->kelas)?'':$request->kelas;
        $idjurusan = empty($request->jurusan)?'':$request->jurusan;

        $kelas = kelasM::get();
        $jurusan = jurusanM::get();

        $siswa = siswaM::orderBy("idkelas", "asc")
        ->orderBy("idjurusan", "asc")
        ->where("nama", "like", "$keyword%")
        ->where("idkelas", "like", "%$idkelas%")
        ->where("idjurusan", "like", "%$idjurusan%")
        ->paginate(25);

        $siswa->appends($request->only(["limit", "keyword", "jurusan", "kelas"]));

        return view("pages.extrakulikuler.kelola", [
            "siswa" => $siswa,
            "keyword" => $keyword,
            "idkelas" => $idkelas,
            "idjurusan" => $idjurusan,
            "idraport" => $idraport,
            "idpembinaex" => $idpembinaex,

            "kelas" => $kelas,
            "jurusan" => $jurusan,
        ]);

    }

    public function kirim(Request $request, $idsiswa) {
        
        $request->validate([
            "nilai" => "required",
            "idpembinaex" => "required",
            "idraport" => "required",
        ]);

        try{
            $nilai = $request->nilai;
            $idpembina = $request->idpembinaex;
            $idraport = $request->idraport;

            $iduser = Auth::user()->iduser;
            $cek = pembinaexM::where("iduser", $iduser)->where("idpembinaex", $idpembina)->count();

            if($cek == 0) {
                $pesan = [
                    "icon" => "warning",
                    "title" => "warning",
                    "message"  => "Tidak ada hak",
                ];
                return $pesan;
            }

            $penilaian = penilaianexM::where("idpembinaex", $idpembina)
            ->where("idraport", $idraport)
            ->where("idsiswa", $idsiswa);

            if($penilaian->count() == 1) {
                $penilaian->first()->update([
                    "nilai" => $nilai,
                ]);
            }else {
                $data = $request->all();
                $data["idsiswa"] = $idsiswa;
                penilaianexM::create($data);
            }

            $pesan = [
                "icon" => "success",
                "title" => "success",
                "message"  => "Nilai berhasil diupdate",
            ];

            return $pesan;
        
        }catch(\Throwable $th){
            $pesan = [
                "icon" => "error",
                "title" => "error",
                "message"  => "Terjadi kesalahan",
            ];
    
            return $pesan;
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
    public function update(Request $request, pembinaexM $pembinaexM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pembinaexM  $pembinaexM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pembinaexM $pembinaexM, $idpenilaianex)
    {
        try{
            penilaianexM::destroy($idpenilaianex);

            return redirect()->back()->with("success", "Penghapusan berhasil")->withInput();
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
