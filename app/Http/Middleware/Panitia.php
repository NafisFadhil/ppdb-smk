<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Panitia
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
        $levelname = $request->user()->level->name;
        if ($levelname !== 'super-admin' && $levelname !== 'siswa') {
            return $next($request);
        }
        
        return redirect('/')->withErrors([
            'alerts' => ['warning' => 'Halaman ini hanya bisa diakses oleh panitia ppdb.']
        ]);
    }
}
