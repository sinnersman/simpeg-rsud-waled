<?php

namespace App\Http\Controllers;

use App\DataTables\JenjangDataTable;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JenjangImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JenjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JenjangDataTable $dataTable)
    {
        $title = 'Master Jenjang';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Jenjang', 'active' => true],
        ];

        return $dataTable->render('jenjang.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenjang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:jenjangs,kode',
            'nama' => 'required|string|max:255',
        ]);

        Jenjang::create($request->all());

        return redirect()->route('jenjang.index')
            ->with('success', 'Jenjang created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenjang $jenjang)
    {
        // This method is not used as per except(['show']) in routes
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenjang $jenjang)
    {
        return view('jenjang.edit', compact('jenjang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenjang $jenjang)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:jenjangs,kode,' . $jenjang->id,
            'nama' => 'required|string|max:255',
        ]);

        $jenjang->update($request->all());

        return redirect()->route('jenjang.index')
            ->with('success', 'Jenjang updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenjang $jenjang)
    {
        $jenjang->delete();

        return redirect()->route('jenjang.index')
            ->with('success', 'Jenjang deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $jenjangs = Jenjang::onlyTrashed()->get();

        return view('jenjang.trash', compact('jenjangs'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $jenjang = Jenjang::onlyTrashed()->findOrFail($id);
        $jenjang->restore();

        return redirect()->route('jenjang.trash')
            ->with('success', 'Jenjang restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $jenjang = Jenjang::onlyTrashed()->findOrFail($id);
        $jenjang->forceDelete();

        return redirect()->route('jenjang.trash')
            ->with('success', 'Jenjang permanently deleted successfully');
    }

    /**
     * Download Excel template for Jenjang.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'kode');
        $sheet->setCellValue('B1', 'nama');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_jenjang.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Import Excel data for Jenjang.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new JenjangImport, $request->file('excel_file'));

        return redirect()->route('jenjang.index')
            ->with('success', 'Data Jenjang berhasil diimpor.');
    }
}