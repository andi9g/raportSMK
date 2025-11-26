<?php

namespace App\Http\Controllers;

use App\Models\cppklM;
use App\Models\elemencppklM;
use Illuminate\Http\Request;

class pengaturanpklC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = cppklM::when($keyword, function($query, $kw) {
            $query->where('judulcppkl', 'like', '%'.$kw.'%');
        })->orderBy("index", "asc")
        ->paginate(20);

        return view('pages.pengaturan.cppkl', [
            'keyword' => $keyword,
            'data' => $data,
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
            'judulcppkl' => 'required',
            'index' => 'numeric|required',
        ]);
        
        
        try{
           $data = $request->all();

           $store = cppklM::create($data);
            if($store) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cppklM  $cppklM
     * @return \Illuminate\Http\Response
     */
    public function show(cppklM $cppklM, $idcppkl)
    {
        $elemencppkl = elemencppklM::where("idcppkl", $idcppkl)->paginate(20);


        return view("pages.pengaturan.elemencppkl", [
            "data" => $elemencppkl,
            "idcppkl" => $idcppkl,
        ]);
        
    }

    public function tambahelemen(Request $request) {
        
        
        try{
            $data = $request->all();
            $tambah = elemencppklM::create($data);
            if ($tambah) {
                # code...
                return redirect()->back()->with('success', 'Success');
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    
    public function ubahelemen(Request $request, $idelemencppkl) {  
        try{
            $data = $request->judulelemencppkl;
            $update = elemencppklM::where("idelemencppkl", $idelemencppkl)->update([
                "judulelemencppkl" => $data,
            ]);
            if ($update) {
                # code...
                return redirect()->back()->with('success', 'Success');
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
    public function hapuselemen(Request $request, $idelemencppkl) {  
       try{
           $destroy = elemencppklM::where('idelemencppkl', $idelemencppkl)->delete();
           if($destroy) {
               return redirect()->back()->with('success', 'success');
           }
       }catch(\Throwable $th){
           return redirect()->back()->with('error', 'Terjadi kesalahan');
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cppklM  $cppklM
     * @return \Illuminate\Http\Response
     */
    public function edit(cppklM $cppklM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cppklM  $cppklM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cppklM $cppklM, $idcppkl)
    {
        $request->validate([
            'judulcppkl' => 'required',
            'index' => 'required|numeric',
        ]);
        
        
        try{
            $update = cppklM::where('idcppkl', $idcppkl)->update([
                "judulcppkl" => $request->judulcppkl,
                "index" => $request->index,
            ]);
            if($update) {
                return redirect()->back()->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cppklM  $cppklM
     * @return \Illuminate\Http\Response
     */
    public function destroy(cppklM $cppklM, $idcppkl)
    {
        try{
            $hapus = $cppklM->where("idcppkl", $idcppkl)->delete();
            if($hapus) {
                return redirect()->back()->with('warning', 'Berhasil dihapus');
            }
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }
}
