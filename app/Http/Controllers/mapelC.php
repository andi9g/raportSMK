<?php

namespace App\Http\Controllers;

use App\Models\mapelM;
use Excel;
use Hash;
use App\Imports\MapelImport;
use Illuminate\Http\Request;

class mapelC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $mapel = mapelM::where("namamapel", "like", "%$keyword%")->paginate(15);

        $mapel->appends($request->all());

        return view('pages.mapel.datamapel', [
            "keyword" => $keyword,
            "mapel" => $mapel,
        ]);
    }

    public function import(Request $request) {
        try {
            if ($request->hasFile("file")) {
                $file = $request->file;
                Excel::import(new MapelImport, $file);
                return redirect()->back()->with("success", "Data berhasil di import")->withInput();
            }



            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
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
        try {
            $data = $request->all();
            mapelM::create($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mapelM  $mapelM
     * @return \Illuminate\Http\Response
     */
    public function show(mapelM $mapelM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mapelM  $mapelM
     * @return \Illuminate\Http\Response
     */
    public function edit(mapelM $mapelM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mapelM  $mapelM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mapelM $mapelM, $idmapel)
    {
        try {
            $data = $request->all();
            $update = mapelM::where('idmapel', $idmapel)->first();
            $update->update($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mapelM  $mapelM
     * @return \Illuminate\Http\Response
     */
    public function destroy(mapelM $mapelM, $idmapel)
    {
        try {
            $update = mapelM::destroy($idmapel);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }
}
