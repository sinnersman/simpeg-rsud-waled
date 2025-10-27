<?php

namespace App\Http\Controllers;

use App\DataTables\GolonganDataTable;
use App\Imports\GolonganImport;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GolonganDataTable $dataTable)
    {
        $title = 'Master Golongan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Golongan', 'active' => true],
        ];

        return $dataTable->render('golongan.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('golongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'golongan' => 'required',
            'pangkat' => 'required',
        ]);

        Golongan::create($request->all());

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        return view('golongan.show', compact('golongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('golongan.edit', compact('golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'kode' => 'required',
            'golongan' => 'required',
            'pangkat' => 'required',
        ]);

        $golongan->update($request->all());

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan deleted successfully');
    }

    /**
     * Display a listing of the trashed resource.
     */
    public function trash()
    {
        $golongans = Golongan::onlyTrashed()->get();

        return view('golongan.trash', compact('golongans'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $golongan = Golongan::onlyTrashed()->findOrFail($id);
        $golongan->restore();

        return redirect()->route('golongan.trash')
            ->with('success', 'Golongan restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $golongan = Golongan::onlyTrashed()->findOrFail($id);
        $golongan->forceDelete();

        return redirect()->route('golongan.trash')
            ->with('success', 'Golongan permanently deleted successfully');
    }

    /**
     * Download Excel template for Golongan.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'kode');
        $sheet->setCellValue('B1', 'golongan');
        $sheet->setCellValue('C1', 'pangkat');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_golongan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Import Excel data for Golongan.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new GolonganImport, $request->file('excel_file'));

        return redirect()->route('golongan.index')
            ->with('success', 'Data Golongan berhasil diimpor.');
    }
}
