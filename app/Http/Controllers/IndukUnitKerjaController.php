<?php

namespace App\Http\Controllers;

use App\DataTables\IndukUnitKerjaDataTable;
use App\Models\IndukUnitKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IndukUnitKerjaImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IndukUnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndukUnitKerjaDataTable $dataTable)
    {
        $title = 'Master Induk Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Induk Unit Kerja', 'active', true],
        ];

        return $dataTable->render('induk_unit_kerja.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Induk Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Induk Unit Kerja', 'url' => route('induk_unit_kerja.index')],
            ['name' => 'Tambah Induk Unit Kerja', 'active', true],
        ];

        return view('induk_unit_kerja.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:induk_unit_kerja,kode|max:255',
            'nama_induk_unit_kerja' => 'required|string|max:255',
        ]);

        IndukUnitKerja::create($request->all());

        return redirect()->route('induk_unit_kerja.index')
            ->with('success', 'Induk Unit Kerja created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndukUnitKerja $indukUnitKerja)
    {
        // This method is intentionally left empty as per user's request to remove detail view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndukUnitKerja $indukUnitKerja)
    {
        $title = 'Edit Induk Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Induk Unit Kerja', 'url', route('induk_unit_kerja.index')],
            ['name' => 'Edit Induk Unit Kerja', 'active', true],
        ];

        return view('induk_unit_kerja.edit', compact('indukUnitKerja', 'title', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndukUnitKerja $indukUnitKerja)
    {
        $request->validate([
            'kode' => 'required|string|unique:induk_unit_kerja,kode,'.$indukUnitKerja->id.'|max:255',
            'nama_induk_unit_kerja' => 'required|string|max:255',
        ]);

        $indukUnitKerja->update($request->all());

        return redirect()->route('induk_unit_kerja.index')
            ->with('success', 'Induk Unit Kerja updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndukUnitKerja $indukUnitKerja)
    {
        $indukUnitKerja->delete();

        return redirect()->route('induk_unit_kerja.index')
            ->with('success', 'Induk Unit Kerja deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $indukUnitKerjas = IndukUnitKerja::onlyTrashed()->get();
        $title = 'Recycle Bin Induk Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Induk Unit Kerja', 'url' => route('induk_unit_kerja.index')],
            ['name' => 'Recycle Bin Induk Unit Kerja', 'active', true],
        ];

        return view('induk_unit_kerja.trash', compact('indukUnitKerjas', 'title', 'breadcrumbs'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $indukUnitKerja = IndukUnitKerja::onlyTrashed()->findOrFail($id);
        $indukUnitKerja->restore();

        return redirect()->route('induk_unit_kerja.trash')
            ->with('success', 'Induk Unit Kerja restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $indukUnitKerja = IndukUnitKerja::onlyTrashed()->findOrFail($id);
        $indukUnitKerja->forceDelete();

        return redirect()->route('induk_unit_kerja.trash')
            ->with('success', 'Induk Unit Kerja permanently deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new IndukUnitKerjaImport, $request->file('file'));

        return redirect()->route('induk_unit_kerja.index')->with('success', 'Induk Unit Kerja imported successfully');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'kode');
        $sheet->setCellValue('B1', 'nama_induk_unit_kerja');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_induk_unit_kerja.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }
}
