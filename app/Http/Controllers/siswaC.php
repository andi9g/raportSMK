<?php

namespace App\Http\Controllers;

use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Excel;
use Hash;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;

class siswaC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $siswa = siswaM::where("nama", "like", "%$keyword%")
        ->orderBy("idjurusan", "ASC")
        ->orderBy("nama", "asc")
        ->paginate(15);

        $kelas = kelasM::get();
        $jurusan = jurusanM::get();

        $siswa->appends($request->all());

        return view('pages.siswa.datasiswa', [
            "keyword" => $keyword,
            "siswa" => $siswa,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
        ]);
    }

    public function import(Request $request) {
        // try {
            if ($request->hasFile("file")) {
                $file = $request->file;
                Excel::import(new SiswaImport, $file);
                return redirect()->back()->with("success", "Data berhasil di import")->withInput();
            }



            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        // }
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
        // try {
            $data = $request->all();
            $edit = siswaM::create($data);
            return redirect()->back()->with("success", "Data berhasil di edit")->withInput();

        // } catch (\Throwable $th) {
        //     return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function show(siswaM $siswaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function edit(siswaM $siswaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswaM $siswaM, $idsiswa)
    {
        try {
            $data = $request->all();
            $edit = siswaM::where("idsiswa", $idsiswa)->first();
            $edit->update($data);
            return redirect()->back()->with("success", "Data berhasil di edit")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswaM $siswaM, $idsiswa)
    {
        siswaM::destroy($idsiswa);
        return redirect()->back()->with("success", "Data berhasil di edit")->withInput();
    }
}
