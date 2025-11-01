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
        // Fetch all jabatans with their parent relationship
        $jabatans = Jabatan::with('parent')->get();

        $chartData = [];
        $chartData[] = ['Name', 'Manager', 'ToolTip']; // Google Charts header

        // Build a map of jabatan ID to its data for easy lookup
        $jabatanMap = $jabatans->keyBy('id');

        // Add nodes to chartData
        foreach ($jabatans as $jabatan) {
            $parentId = '';
            if ($jabatan->parent_jabatan_id && isset($jabatanMap[$jabatan->parent_jabatan_id])) {
                $parentId = 'jabatan_' . $jabatan->parent_jabatan_id;
            }

            $chartData[] = [
                ['v' => 'jabatan_' . $jabatan->id, 'f' => $jabatan->nama_jabatan],
                $parentId,
                $jabatan->nama_jabatan // Tooltip can be the same for now
            ];
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