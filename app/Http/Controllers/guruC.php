<?php

namespace App\Http\Controllers;

use App\Models\User;
use Excel;
use Hash;
use App\Imports\UsersImport;
use Illuminate\Http\Request;

class guruC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $guru = User::where("name", "like", "%$keyword%")->paginate(15);

        $guru->appends($request->all());

        return view('pages.guru.dataguru', [
            "keyword" => $keyword,
            "guru" => $guru,
        ]);
    }
    
    public function import(Request $request) {
        try {
            if ($request->hasFile("file")) {
                $file = $request->file;
                Excel::import(new UsersImport, $file);
                
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
            $data['password'] = Hash::make($request->password);
            User::create($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $iduser)
    {
        try {
            $data = $request->all();
            $update = User::where('iduser', $iduser)->first();
            $update->update($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    public function reset(Request $request, $iduser) {
        try {
            $data["password"] = Hash::make('guru2023');
            $update = User::where('iduser', $iduser)->first();
            $update->update($data);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $iduser)
    {
        try {
            $update = User::destroy($iduser);

            return redirect()->back()->with("success", "success")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }
}
