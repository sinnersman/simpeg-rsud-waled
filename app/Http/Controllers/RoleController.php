<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Models\Role;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RoleImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        $title = 'Master Role';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Role', 'active' => true],
        ];

        return $dataTable->render('roles.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Role';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Role', 'url' => route('roles.index')],
            ['name' => 'Tambah Role', 'active' => true],
        ];

        return view('roles.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $title = 'Edit Role';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Master Role', 'url' => route('roles.index')],
            ['name' => 'Edit Role', 'active' => true],
        ];

        return view('roles.edit', compact('role', 'title', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'description' => 'nullable|string|max:255',
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new RoleImport, $request->file('file'));

        return redirect()->route('roles.index')->with('success', 'Role imported successfully');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'name');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_role.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }
}
