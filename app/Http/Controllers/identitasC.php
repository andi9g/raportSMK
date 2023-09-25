<?php

namespace App\Http\Controllers;

use App\Models\identitasM;
use Illuminate\Http\Request;
use Auth;

class identitasC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identitas = identitasM::where("iduser", Auth::user()->iduser)->first();

        return view("pages.identitas.identitas", [
            "identitas" => $identitas,
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
            "email" => "required|email",
            "alamat" => "required",
            "agama" => "required",
            "posisi" => "required",
            "jk" => "required",
            "hp" => "required|numeric",
        ]);

        // try {
            $iduser = Auth::user()->iduser;
            $cek = identitasM::where("iduser", $iduser)->count();
            $data = $request->all();

            if($cek > 0) {
                identitasM::where("iduser", $iduser)->update($data);
                return redirect()->back()->with("success", "Identitas berhasil diupdate")->withInput();
            }else {
                $data["iduser"] = $iduser;
                identitasM::create($data);
                return redirect('home')->with("success", "Terima kasih, Data telah lengkap");
            }

            return redirect('identitas')->with("error", "terjadi kesalaan");
        // } catch (\Throwable $th) {
        //     return redirect('identitas')->with("error", "terjadi kesalaan");
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\identitasM  $identitasM
     * @return \Illuminate\Http\Response
     */
    public function show(identitasM $identitasM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\identitasM  $identitasM
     * @return \Illuminate\Http\Response
     */
    public function edit(identitasM $identitasM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\identitasM  $identitasM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, identitasM $identitasM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\identitasM  $identitasM
     * @return \Illuminate\Http\Response
     */
    public function destroy(identitasM $identitasM)
    {
        //
    }
}
