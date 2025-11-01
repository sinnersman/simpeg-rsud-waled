<?php

namespace App\Http\Controllers;

use App\Http\Requests\CutiRequest;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    public function index()
    {
        $cutis = Cuti::where('pegawai_id', Auth::user()->pegawai->id)->get();
        return view('e-layanan.cuti.index', compact('cutis'));
    }

    public function create()
    {
        return view('e-layanan.cuti.create');
    }

    public function store(CutiRequest $request)
    {
        $validated = $request->validated();
        $validated['pegawai_id'] = Auth::user()->pegawai->id;

        Cuti::create($validated);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibuat.');
    }
}
