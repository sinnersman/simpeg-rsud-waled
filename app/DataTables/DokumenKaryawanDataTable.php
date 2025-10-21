<?php

namespace App\DataTables;

use App\Models\DokumenKaryawan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DokumenKaryawanDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('pegawai', function ($row) {
                return $row->pegawai ? $row->pegawai->nama_lengkap : 'N/A';
            })
            ->editColumn('file_path', function ($row) {
                return '<a href="' . Storage::url($row->file_path) . '" target="_blank" class="btn btn-sm btn-info">Lihat File</a>';
            })
            ->addColumn('action', function ($row) {
                return view('dokumen_karyawan.action', compact('row'))->render();
            })
            ->rawColumns(['file_path', 'action'])
            ->setRowId('id');
    }

    public function query(DokumenKaryawan $model): QueryBuilder
    {
        $query = $model->newQuery()->with('pegawai');

        if (auth()->user()->role === 'pegawai') {
            $pegawai = auth()->user()->pegawai;
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                $query->whereRaw('1 = 0'); // Return no results if pegawai has no biodata
            }
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('dokumenkaryawan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(false);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::make('DT_RowIndex')->title('No.')->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('nama_dokumen'),
            Column::make('file_path')->title('File'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];

        if (auth()->user()->role === 'superadmin') {
            array_splice($columns, 1, 0, [Column::make('pegawai')->title('Pegawai')]);
        }

        return $columns;
    }

    protected function filename(): string
    {
        return 'DokumenKaryawan_' . date('YmdHis');
    }
}