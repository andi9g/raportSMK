<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\identitasp5M;

class GerbangKordinator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $iduser = Auth::user()->iduser;
        $posisi = Auth::user()->identitas->posisi;
        $identitas = identitasp5M::where("iduser", $iduser)->count();

        if($identitas == 1 || ($posisi == "admin" || $posisi == "walikelas")) {
            return $next($request);
        }else {
            return redirect('home')->with("warning", "maaf anda bukan kordinator P5");
        }
    }
}
