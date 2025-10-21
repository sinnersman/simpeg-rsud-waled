<?php

namespace App\Http\Controllers;

use App\DataTables\JabatanDataTable;
use App\Imports\JabatanImport;
use App\Models\Jabatan;
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
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:255',
            'nama_jabatan' => 'required|string|max:255',
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
        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:255',
            'nama_jabatan' => 'required|string|max:255',
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
}
