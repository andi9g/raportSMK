<?php

namespace App\Http\Controllers;

use App\Models\keteranganp5M;
use App\Models\identitasp5M;
use App\Models\User;
use App\Models\identitasM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Illuminate\Http\Request;

class pengaturanp5C extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keterangan = keteranganp5M::orderBy("index", "asc")->get();
        $index = count($keterangan) + 1;

        $identitas = identitasM::where("posisi", "!=", "admin")->get();
        $identitasp5 = identitasp5M::get();
        $kelas = kelasM::get();
        $jurusan = jurusanM::get();

        return view("pages.pengaturan.p5", [
            "keterangan" => $keterangan,
            "index" => $index,
            "identitas" => $identitas,
            "identitasp5" => $identitasp5,
            "kelas" => $kelas,
            "jurusan" => $jurusan,
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'inisialp5' => 'required',
            'keteranganp5' => 'required',
            'deskripsi' => 'required',
            'index' => 'required',
        ]);
        try {
            
          
            $data = $request->all();
        
            keteranganp5M::create($data);
            
            return redirect()->back()->with('success', 'Success');


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\keteranganp5M  $keteranganp5M
     * @return \Illuminate\Http\Response
     */
    public function show(keteranganp5M $keteranganp5M)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\keteranganp5M  $keteranganp5M
     * @return \Illuminate\Http\Response
     */
    public function edit(keteranganp5M $keteranganp5M)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\keteranganp5M  $keteranganp5M
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, keteranganp5M $keteranganp5M, $idketeranganp5)
    {
        $request->validate([
            'inisialp5' => 'required',
            'keteranganp5' => 'required',
            'deskripsi' => 'required',
            'index' => 'required',
        ]);
        try {
            
            
            $data = $request->all();
        
            keteranganp5M::where("idketeranganp5", $idketeranganp5)->first()->update($data);
            
            return redirect()->back()->with('success', 'Success');

            

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\keteranganp5M  $keteranganp5M
     * @return \Illuminate\Http\Response
     */
    public function destroy(keteranganp5M $keteranganp5M, $idketeranganp5)
    {
        try{
            $destroy = keteranganp5M::where('idketeranganp5', $idketeranganp5)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
