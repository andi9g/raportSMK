<?php

namespace App\Http\Controllers;

use App\Models\pesertapklM;
use App\Models\siswaM;
use App\Models\pklM;
use App\Models\cppklM;
use App\Models\elemencppklM;
use App\Models\walikelaspklM;
use App\Models\kepalasekolahpklM;
use App\Models\kajurpklM;
use App\Models\nilaipklM;
use App\Models\catatanpklM;
use App\Models\kehadiranpklM;
use Illuminate\Http\Request;
use Auth;
use PDF;

class pesertapklC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $idpkl)
    {
        $keyword = $request->keyword;
        $keyword2 = $request->keyword2;
        $carisiswa = siswaM::where("nisn", "like", "nisn%")
        ->orWhere("nama", "like", "%$keyword%")
        ->select("nisn")->get()->toArray();

        $iduser = Auth::user()->iduser;

        $pesertapkl = pesertapklM::where("idpkl", $idpkl)
        ->where("iduser", $iduser)
        ->when($carisiswa, function($query, $key) {
                $query->whereIn('nisn', $key);
        });

        //pilih peserta
        $siswaterdaftar = $pesertapkl->select("nisn")->get()->toArray();
        $siswa = siswaM::when($keyword2, function($query, $key) {
                $query->where('nama', 'like', '%'.$key.'%')
                ->orWhere("nisn", "like", "$key%");
        })
        ->whereNotIn("nisn", $siswaterdaftar)
        ->paginate(15);

        $siswa->appends($request->only(["limit", "keyword2"]));

        return view("pages.raport.pesertapkl", [
            'keyword' => $keyword,
            'keyword2' => $keyword2,
            'idpkl' => $idpkl,
            'pesertapkl' => $pesertapkl->get(),
            'siswa' => $siswa,
        ]);
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
    public function cetak(Request $request, $idpesertapkl)
    {
        $data = [];
        $pesertapkl = pesertapklM::where("idpesertapkl", $idpesertapkl)->first();
        $idpkl = $pesertapkl->idpkl;
        $nisn = $pesertapkl->nisn;
        $iduser = Auth::user()->iduser;

        $pkl = pklM::where("idpkl", $pesertapkl->idpkl)->first();
        $catatanpkl = catatanpklM::where("idpesertapkl", $idpesertapkl)->first();
        $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $idpesertapkl)->first();

        $siswa = siswaM::where("nisn", $nisn)->first();
        $identitas = [
            "nama" => $siswa->nama,
            "nis" => $siswa->nis,
            "nisn" => $siswa->nisn,
            "kelas" => $siswa->kelas->namakelas,
            "jurusan" => $siswa->jurusan->jurusan,
            "namajurusan" => $siswa->jurusan->namajurusan,
            "namakonsentrasi" => $siswa->jurusan->namakonsentrasi ?? "null",
            "tempatpkl" => $pesertapkl->tempatpkl,
            "pembimbingdudi" => $pesertapkl->pembimbingdudi,
            "jabatan" => $pesertapkl->jabatan,
            "tahunajaran" => $pkl->tahunajaran,
            "catatanpkl" => $catatanpkl->catatanpkl,
            "izin" => $kehadiranpkl->izin,
            "sakit" => $kehadiranpkl->sakit,
            "alfa" => $kehadiranpkl->alfa,
        ];

        $walikelaspkl = walikelaspklM::where("idjurusan", $siswa->idjurusan)
        ->where("idpkl", $idpkl)->first();
        $kajurpkl = kajurpklM::where("idjurusan", $siswa->idjurusan)
        ->where("idpkl", $idpkl)->first();
        $kepalasekolahpkl = kepalasekolahpklM::where("idpkl", $idpkl)->first();

        

        $nilai = collect([]);
        $nilaielemen = [];
        $cppkl = cppklM::orderBy("index", "asc")->get();
        
        foreach ($cppkl as $cp) {
            $deskripsipkl = collect([]);
            $nilaielemen = 0; 
            $elemenpkl = elemencppklM::where("idcppkl", $cp->idcppkl)->get();
            // dd($elemenpkl);
            foreach ($elemenpkl as $elemen) {
                $nilaipkl = nilaipklM::where("idpesertapkl", $idpesertapkl)
                ->where("idelemencppkl", $elemen->idelemencppkl)
                ->first();

                if(empty($nilaipkl->nilai)) {
                    dd("terjadi Error");
                }
                $nilaielemen = $nilaielemen + $nilaipkl->nilai;

                $deskripsipkl->push([
                    "index" => $nilaipkl->nilai > 75 ? 1 : 0,
                    "elemen" => $elemen->judulelemencppkl,
                ]);
            }
            
            $desc = $deskripsipkl->sortByDesc('index')->values()->all();
            // kumpulkan elemen berdasarkan index
                $mampu = [];
                $perlu = [];
                foreach ($desc as $d) {
                    if ($d['index'] == 1) {
                        $mampu[] = $d['elemen'];
                    } else {
                        $perlu[] = $d['elemen'];
                    }
                }

                // helper: gabungkan array jadi "a, b dan c"
                $joinElemen = function($arr) {
                    if (count($arr) === 0) return '';
                    if (count($arr) === 1) return $arr[0];
                    $last = array_pop($arr);
                    return implode(', ', $arr) . ' dan ' . $last;
                };

                $keterangan = '';

                if (!empty($mampu)) {
                    $keterangan .= 'Mampu ' . $joinElemen($mampu) . '.';
                }

                if (!empty($perlu)) {
                    if ($keterangan !== '') $keterangan .= ' ';
                    $keterangan .= 'Perlu ditingkatkan dalam ' . $joinElemen($perlu) . '.';
                }

                $nilai->push([
                    "cp" => $cp->judulcppkl,
                    "nilai" => round($nilaielemen / count($elemenpkl)),
                    "deskripsi" => $keterangan,
                ]); 
            
        }

        // dd($identitas);




        $pdf = PDF::loadView('pages.raport.cetakraporpkl', [
            'pesertapkl' => $pesertapkl,
            'pkl' => $pkl,
            'walikelaspkl' => $walikelaspkl,
            'kepalasekolahpkl' => $kepalasekolahpkl,
            'kajurpkl' => $kajurpkl,
            'identitas' => $identitas,
            'nilai' => $nilai,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream($pesertapkl->nisn.".pdf");
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
     * @param  \App\Models\pesertapklM  $pesertapklM
     * @return \Illuminate\Http\Response
     */
    public function show(pesertapklM $pesertapklM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pesertapklM  $pesertapklM
     * @return \Illuminate\Http\Response
     */
    public function edit(pesertapklM $pesertapklM)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pesertapklM  $pesertapklM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pesertapklM $pesertapklM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pesertapklM  $pesertapklM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pesertapklM $pesertapklM)
    {
        //
    }
}
