<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\identitasM;
use App\Models\walikelasM;

class GerbangCekWaliKelas
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
        $cek = identitasM::where("iduser", Auth::user()->iduser)->first();
        
        
        if($cek->posisi == "walikelas") {
            $walikelas = walikelasM::where("ididentitas", $cek->ididentitas)->count();
            if($walikelas == 0) {
                return redirect('walikelas')->with("warning", "silahkan melengkapi data walikelas");
            }else {
                return $next($request);
            }
        }else {
            return $next($request); 
        }
    }
}
