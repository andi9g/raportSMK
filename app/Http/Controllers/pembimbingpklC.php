<?php

namespace App\Http\Controllers;

use App\Models\jurusanM;
use App\Models\kelasM;
use App\Models\pembimbingpklM;
use App\Models\siswaM;
use App\Models\User;
use Illuminate\Http\Request;

class pembimbingpklC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $pembimbing = pembimbingpklM::select("iduser")->get()->toArray();
        // dd($pembimbing);
        $identitas = User::where("name", "!=", "admin")
        ->whereNotIn("iduser", $pembimbing)->get();
        $kelas = kelasM::get();
        $jurusan = jurusanM::get();


        $user = [];
        if(!empty($keyword)){
            $user = User::where("name", "like", "%$keyword%")->select("iduser")->get();
        }

        $pembimbingpkl = pembimbingpklM::when($user, function($query, $usr) {
                $query->whereIn('iduser', $usr);
        })->paginate(15);

        $pembimbingpkl->appends([$request->all()]);

        return view('pages.pkl.pembimbingpkl', [
            'identitas' => $identitas,
            'jurusan' => $jurusan,
            'kelas' => $kelas,
            'pembimbingpkl' => $pembimbingpkl,
            'keyword' => $keyword,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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
        ]);


        try{
            $iduser = $request->all();

            $store = pembimbingpklM::create($iduser);

            if($store) {
                return redirect()->back()->with('success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('danger', 'Terjadi kesalahan');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idpembimbingpkl)
    {
        try{
            $destroy = pembimbingpklM::where('idpembimbingpkl', $idpembimbingpkl)->delete();
            if($destroy) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
