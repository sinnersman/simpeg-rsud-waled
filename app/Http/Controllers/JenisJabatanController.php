<?php

namespace App\Http\Controllers;

use App\DataTables\JenisJabatanDataTable;
use App\Imports\JenisJabatanImport;
use App\Models\JenisJabatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JenisJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JenisJabatanDataTable $dataTable)
    {
        $title = 'Master Jenis Jabatan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Jenis Jabatan', 'active' => true],
        ];

        return $dataTable->render('jenis_jabatan.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:jenis_jabatans,kode',
            'nama' => 'required|string|max:255',
        ]);

        JenisJabatan::create($request->all());

        return redirect()->route('jenis_jabatan.index')
            ->with('success', 'Jenis Jabatan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisJabatan $jenisJabatan)
    {
        // This method is not used as per except(['show']) in routes
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisJabatan $jenisJabatan)
    {
        return view('jenis_jabatan.edit', compact('jenisJabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisJabatan $jenisJabatan)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:jenis_jabatans,kode,' . $jenisJabatan->id,
            'nama' => 'required|string|max:255',
        ]);

        $jenisJabatan->update($request->all());

        return redirect()->route('jenis_jabatan.index')
            ->with('success', 'Jenis Jabatan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisJabatan $jenisJabatan)
    {
        $jenisJabatan->delete();

        return redirect()->route('jenis_jabatan.index')
            ->with('success', 'Jenis Jabatan deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $jenisJabatans = JenisJabatan::onlyTrashed()->get();

        return view('jenis_jabatan.trash', compact('jenisJabatans'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $jenisJabatan = JenisJabatan::onlyTrashed()->findOrFail($id);
        $jenisJabatan->restore();

        return redirect()->route('jenis_jabatan.trash')
            ->with('success', 'Jenis Jabatan restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $jenisJabatan = JenisJabatan::onlyTrashed()->findOrFail($id);
        $jenisJabatan->forceDelete();

        return redirect()->route('jenis_jabatan.trash')
            ->with('success', 'Jenis Jabatan permanently deleted successfully');
    }

    /**
     * Download Excel template for Jenis Jabatan.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'kode');
        $sheet->setCellValue('B1', 'nama');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_jenis_jabatan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Import Excel data for Jenis Jabatan.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new JenisJabatanImport, $request->file('excel_file'));

        return redirect()->route('jenis_jabatan.index')
            ->with('success', 'Data Jenis Jabatan berhasil diimpor.');
    }
}
