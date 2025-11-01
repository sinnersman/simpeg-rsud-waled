<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsurePegawaiProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply this middleware to authenticated 'pegawai' users
        if (Auth::check() && Auth::user()->role === 'pegawai') {
            $pegawai = Auth::user()->pegawai;

            // Define what constitutes an incomplete profile
            // For example, if nama_lengkap, tanggal_lahir, or alamat_lengkap are missing
            // Define what constitutes an incomplete profile
            // For example, if nama_lengkap, tanggal_lahir, or alamat_lengkap are missing

            if (!$pegawai ||
                empty($pegawai->nama_lengkap) ||
                empty($pegawai->tanggal_lahir) ||
                empty($pegawai->alamat_lengkap) ||
                empty($pegawai->jabatan_id) ||
                empty($pegawai->jenis_jabatan_id) ||
                empty($pegawai->jenjang_id) ||
                empty($pegawai->golongan_id) ||
                empty($pegawai->unit_kerja_id) ||
                empty($pegawai->induk_unit_kerja_id)
            ) {
                // Allow access to the profile editing page itself
                if ($request->routeIs('pegawai.myBiodataEdit') || $request->routeIs('pegawai.myBiodataUpdate') || $request->routeIs('users.leaveImpersonation')) {
                    return $next($request);
                }

                return redirect()->route('pegawai.myBiodataEdit')
                                 ->with('warning', 'Silakan lengkapi data diri Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
