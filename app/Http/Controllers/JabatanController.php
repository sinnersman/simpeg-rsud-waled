<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\DataTables\JabatanDataTable;

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
            ['name' => 'Master Jabatan', 'active' => true]
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
}