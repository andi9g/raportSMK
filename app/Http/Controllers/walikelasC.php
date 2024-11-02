<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\walikelasM;
use App\Models\identitasM;
use App\Models\User;
use App\Models\jurusanM;
use App\Models\kelasM;
use Illuminate\Support\Facades\Auth;

class walikelasC extends Controller
{

    public function index(Request $request) {
        $identitas = identitasM::where("iduser", Auth::user()->iduser)->first();
        $jurusan = jurusanM::get();
        $kelas = kelasM::get();

        if($identitas->walikelas != null) {
            return redirect("home")->with("toast_warning", "maaf data tidak dapat diubah")->withInput();
        }

        return view('pages.walikelas.index', [
            "identitas" => $identitas,
            "jurusan" => $jurusan,
            "kelas" => $kelas,
        ]);

    }

    public function update(Request $request, $ididentitas) {
        $walikelas = walikelasM::where("ididentitas", $ididentitas);
        $data = $request->all();
        if($walikelas->count()==null) {
            $data["ididentitas"] = $ididentitas;
            walikelasM::create($data);
        }else {
            $walikelas->first()->update($data);
        }

        return redirect('home')->with("welcome");
    }
}

