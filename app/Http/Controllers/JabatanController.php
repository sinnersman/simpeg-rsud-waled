<?php

namespace App\Http\Controllers;

use App\DataTables\JabatanDataTable;
use App\Imports\JabatanImport;
use App\Models\Jabatan;
use App\Models\JenisJabatan;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JabatanDataTable $dataTable)
    {
        $title = 'Master Jabatan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Jabatan', 'active' => true],
        ];

        return $dataTable->render('jabatan.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisJabatans = JenisJabatan::all();
        $jenjangs = Jenjang::all();
        $jabatans = Jabatan::all(); // Get all jabatans for parent selection
        return view('jabatan.create', compact('jenisJabatans', 'jenjangs', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:255|unique:jabatans,kode_jabatan',
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'parent_jabatan_id' => 'nullable|exists:jabatans,id',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        $jenisJabatans = JenisJabatan::all();
        $jenjangs = Jenjang::all();
        $jabatans = Jabatan::where('id', '!=', $jabatan->id)->get(); // Get all jabatans except the current one
        return view('jabatan.edit', compact('jabatan', 'jenisJabatans', 'jenjangs', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:255|unique:jabatans,kode_jabatan,' . $jabatan->id,
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'parent_jabatan_id' => 'nullable|exists:jabatans,id',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $jabatans = Jabatan::onlyTrashed()->get();

        return view('jabatan.trash', compact('jabatans'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $jabatan = Jabatan::onlyTrashed()->findOrFail($id);
        $jabatan->restore();

        return redirect()->route('jabatan.trash')
            ->with('success', 'Jabatan restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $jabatan = Jabatan::onlyTrashed()->findOrFail($id);
        $jabatan->forceDelete();

        return redirect()->route('jabatan.trash')
            ->with('success', 'Jabatan permanently deleted successfully');
    }

    /**
     * Download Excel template for Jabatan.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'kode_jabatan');
        $sheet->setCellValue('B1', 'nama_jabatan');
        $sheet->setCellValue('C1', 'jenis_jabatan_id');
        $sheet->setCellValue('D1', 'jenjang_id');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_jabatan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Import Excel data for Jabatan.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new JabatanImport, $request->file('excel_file'));

        return redirect()->route('jabatan.index')
            ->with('success', 'Data Jabatan berhasil diimpor.');
    }

    public function organizationChart()
    {
        $title = 'Struktur Organisasi Jabatan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Jabatan', 'url' => route('jabatan.index')],
            ['name' => 'Struktur Organisasi', 'active' => true],
        ];

        // Fetch all jabatans with their parent relationship
        $jabatans = Jabatan::with('parent')->get();

        // Transform data for OrgChart.js (or similar library)
        // This is a basic transformation, might need adjustment based on the chosen library
        $chartData = $jabatans->map(function ($jabatan) {
            return [
                'id' => $jabatan->id,
                'pid' => $jabatan->parent_jabatan_id,
                'name' => $jabatan->nama_jabatan,
                'title' => $jabatan->jenisJabatan->nama ?? '', // Assuming JenisJabatan is loaded
                // Add more fields as needed for the chart display
            ];
        });

        return view('jabatan.organization_chart', compact('title', 'breadcrumbs', 'chartData'));
    }
}
