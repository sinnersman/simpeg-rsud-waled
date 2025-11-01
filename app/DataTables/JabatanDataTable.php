<?php

namespace App\DataTables;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JabatanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Jabatan>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('jenis_jabatan_nama', function ($jabatan) {
                return $jabatan->jenisJabatan->nama ?? '-';
            })
            ->addColumn('jenjang_nama', function ($jabatan) {
                return $jabatan->jenjang->nama ?? '-';
            })
            ->addColumn('nama_jabatan_formatted', function ($jabatan) {
                $prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $jabatan->depth);
                return $prefix . $jabatan->nama_jabatan;
            })
            ->addColumn('parent_jabatan_name', function ($jabatan) {
                return $jabatan->parent->nama_jabatan ?? '-';
            })
            ->addColumn('action', function ($jabatan) {
                return view('jabatan.action', compact('jabatan'));
            })
            ->setRowId('id')
            ->rawColumns(['nama_jabatan_formatted', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Jabatan>
     */
    public function query(Jabatan $model): QueryBuilder
    {
        return $model->newQuery()->with(['jenisJabatan', 'jenjang', 'parent']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jabatan-table')
            ->columns($this->getColumns())
            ->ajax(route('jabatan.index'))
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(false);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('kode_jabatan')->title('Kode Jabatan')->addClass('text-left'),
            Column::computed('nama_jabatan_formatted')->title('Nama Jabatan'),
            Column::make('jenis_jabatan_nama')->title('Jenis Jabatan'),
            Column::make('jenjang_nama')->title('Jenjang'),
            Column::make('parent_jabatan_name')->title('Atasan Langsung')->name('parent.nama_jabatan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Jabatan_'.date('YmdHis');
    }
}
