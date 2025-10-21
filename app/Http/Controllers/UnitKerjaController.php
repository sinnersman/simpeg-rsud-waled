<?php

namespace App\Http\Controllers;

use App\DataTables\UnitKerjaDataTable;
use App\Models\IndukUnitKerja;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnitKerjaImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UnitKerjaDataTable $dataTable)
    {
        $title = 'Master Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Unit Kerja', 'active' => true],
        ];

        return $dataTable->render('unit_kerja.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indukUnitKerjas = IndukUnitKerja::all();
        $title = 'Tambah Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Unit Kerja', 'url' => route('unit_kerja.index')],
            ['name' => 'Tambah Unit Kerja', 'active', true],
        ];

        return view('unit_kerja.create', compact('indukUnitKerjas', 'title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'kode' => 'required|string|unique:unit_kerja,kode|max:255',
            'nama_unit_kerja' => 'required|string|max:255',
        ]);

        UnitKerja::create($request->validated());

        return redirect()->route('unit_kerja.index')
            ->with('success', 'Unit Kerja created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitKerja $unitKerja)
    {
        // This method is intentionally left empty as per user's request to remove detail view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitKerja $unitKerja)
    {
        $indukUnitKerjas = IndukUnitKerja::all();
        $title = 'Edit Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Unit Kerja', 'url' => route('unit_kerja.index')],
            ['name' => 'Edit Unit Kerja', 'active', true],
        ];

        return view('unit_kerja.edit', compact('unitKerja', 'indukUnitKerjas', 'title', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'kode' => 'required|string|unique:unit_kerja,kode,'.$unitKerja->id.'|max:255',
            'nama_unit_kerja' => 'required|string|max:255',
        ]);

        $unitKerja->update($request->all());

        return redirect()->route('unit_kerja.index')
            ->with('success', 'Unit Kerja updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();

        return redirect()->route('unit_kerja.index')
            ->with('success', 'Unit Kerja deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $unitKerjas = UnitKerja::onlyTrashed()->get();
        $title = 'Recycle Bin Unit Kerja';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Unit Kerja', 'url' => route('unit_kerja.index')],
            ['name' => 'Recycle Bin Unit Kerja', 'active', true],
        ];

        return view('unit_kerja.trash', compact('unitKerjas', 'title', 'breadcrumbs'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $unitKerja = UnitKerja::onlyTrashed()->findOrFail($id);
        $unitKerja->restore();

        return redirect()->route('unit_kerja.trash')
            ->with('success', 'Unit Kerja restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $unitKerja = UnitKerja::onlyTrashed()->findOrFail($id);
        $unitKerja->forceDelete();

        return redirect()->route('unit_kerja.trash')
            ->with('success', 'Unit Kerja permanently deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new UnitKerjaImport, $request->file('file'));

        return redirect()->route('unit_kerja.index')->with('success', 'Unit Kerja imported successfully');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'induk_unit_kerja_id');
        $sheet->setCellValue('B1', 'kode');
        $sheet->setCellValue('C1', 'nama_unit_kerja');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_unit_kerja.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }
}
