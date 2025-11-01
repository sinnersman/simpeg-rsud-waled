<?php

namespace App\Http\Controllers;

use App\Models\IndukUnitKerja;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPegawai = \App\Models\Pegawai::count();
        $lakiLaki = \App\Models\Pegawai::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = \App\Models\Pegawai::where('jenis_kelamin', 'Perempuan')->count();

        $lakiLakiPercentage = ($totalPegawai > 0) ? ($lakiLaki / $totalPegawai) * 100 : 0;
        $perempuanPercentage = ($totalPegawai > 0) ? ($perempuan / $totalPegawai) * 100 : 0;

        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                ['name' => 'Main'],
                ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ],
            'totalPegawai' => $totalPegawai,
            'lakiLaki' => $lakiLaki,
            'perempuan' => $perempuan,
            'lakiLakiPercentage' => round($lakiLakiPercentage, 2),
            'perempuanPercentage' => round($perempuanPercentage, 2),
        ];

        return view('dashboard', $data);
    }

    public function organizationChart()
    {
        $jabatans = Jabatan::all();

        $chartData = [];
        $chartData[] = ['Name', 'Manager', 'ToolTip'];

        $createdJabatanNodes = []; // To store created Jabatan nodes for parent lookup

        // First pass: Identify and add top-level Jabatan (e.g., DIREKTUR)
        foreach ($jabatans as $jabatan) {
            $jabatanName = $jabatan->nama_jabatan;

            if (str_contains($jabatanName, 'DIREKTUR') && !str_contains($jabatanName, 'WAKIL')) {
                $chartData[] = [['v' => 'jabatan_' . $jabatan->id, 'f' => $jabatanName], '', ''];
                $createdJabatanNodes[$jabatan->id] = $jabatan;
            }
        }

        // Second pass: Infer hierarchy for other Jabatan
        foreach ($jabatans as $jabatan) {
            $parentId = '';
            $jabatanName = $jabatan->nama_jabatan;

            if (isset($createdJabatanNodes[$jabatan->id])) {
                continue; // Already added as top-level
            }

            // Heuristic to find parent based on keywords
            if (str_contains($jabatanName, 'WAKIL DIREKTUR')) {
                $direktur = Jabatan::where('nama_jabatan', 'DIREKTUR')->first();
                if ($direktur) {
                    $parentId = 'jabatan_' . $direktur->id;
                }
            } elseif (str_contains($jabatanName, 'KEPALA BIDANG')) {
                $wadir = Jabatan::where('nama_jabatan', 'WAKIL DIREKTUR UMUM DAN KEUANGAN')->first(); // Assuming this is the relevant WADIR
                if ($wadir) {
                    $parentId = 'jabatan_' . $wadir->id;
                }
            } elseif (str_contains($jabatanName, 'KEPALA BAGIAN')) {
                $kepalaBidang = Jabatan::where('nama_jabatan', 'KEPALA BIDANG PELAYANAN MEDIS DAN PENGENDALIAN MUTU')->first(); // Assuming this is the relevant KEPALA BIDANG
                if ($kepalaBidang) {
                    $parentId = 'jabatan_' . $kepalaBidang->id;
                }
            } elseif (str_contains($jabatanName, 'KEPALA SUBBAGIAN')) {
                $kepalaBagian = Jabatan::where('nama_jabatan', 'KEPALA BAGIAN UMUM DAN KEPEGAWAIAN')->first(); // Assuming this is the relevant KEPALA BAGIAN
                if ($kepalaBagian) {
                    $parentId = 'jabatan_' . $kepalaBagian->id;
                }
            }

            // Default parent if no specific parent found (e.g., under DIREKTUR if no other parent)
            if (empty($parentId)) {
                $direktur = Jabatan::where('nama_jabatan', 'DIREKTUR')->first();
                if ($direktur) {
                    $parentId = 'jabatan_' . $direktur->id;
                }
            }

            $chartData[] = [['v' => 'jabatan_' . $jabatan->id, 'f' => $jabatanName], $parentId, ''];
            $createdJabatanNodes[$jabatan->id] = $jabatan; // Add to created nodes for future lookups
        }

        $data = [
            'title' => 'Struktur Organisasi',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('dashboard.index')],
                ['name' => 'Struktur Organisasi', 'active' => true],
            ],
            'chartData' => json_encode($chartData),
        ];

        return view('organization_chart', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function settings()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => route('dashboard.index')],
                ['name' => 'Dashboard'],
            ],
        ];

        return view('settings', $data);
    }
}