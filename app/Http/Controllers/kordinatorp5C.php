<?php

namespace App\Http\Controllers;

use App\Models\identitasp5M;
use Illuminate\Http\Request;

class kordinatorp5C extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('pengaturanp5');
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
            'iduser' => 'required',
            'idkelas' => 'required',
            'idjurusan' => 'required',
        ]);
        try {
            
            $data = $request->all();

            identitasp5M::create($data);

            return redirect()->back()->with('success', 'Success');


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\identitasp5M  $identitasp5M
     * @return \Illuminate\Http\Response
     */
    public function show(identitasp5M $identitasp5M)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\identitasp5M  $identitasp5M
     * @return \Illuminate\Http\Response
     */
    public function edit(identitasp5M $identitasp5M)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\identitasp5M  $identitasp5M
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, identitasp5M $identitasp5M, $ididentitasp5)
    {
        $request->validate([
            'iduser' => 'required',
            'idkelas' => 'required',
            'idjurusan' => 'required',
        ]);
        try {

            $data = $request->all();

            identitasp5M::where("ididentitasp5", $ididentitasp5)->first()->update($data);

            return redirect()->back()->with('success', 'Success');


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\identitasp5M  $identitasp5M
     * @return \Illuminate\Http\Response
     */
    public function destroy(identitasp5M $identitasp5M, $ididentitasp5)
    {
        try{
            $destroy = identitasp5M::where('ididentitasp5', $ididentitasp5)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
