<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\identitasM;
use Illuminate\Support\Facades\Auth;


class GerbangIdentitas
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

        $cek = identitasM::where("iduser", Auth::user()->iduser);

        if($cek->count() > 0) {
            return $next($request);
        }else {
            return redirect('identitas')->with('warning', "Silahkan melengkapi identitas Terlebih Dahulu");
        }
    }
}
