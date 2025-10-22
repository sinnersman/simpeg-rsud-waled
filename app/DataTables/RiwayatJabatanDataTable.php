<?php

namespace App\DataTables;

use App\Models\RiwayatJabatan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RiwayatJabatanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('pegawai_name', function ($row) {
                return $row->pegawai ? $row->pegawai->nama_lengkap : '';
            })
            ->addColumn('jabatan_name', function ($row) {
                return $row->jabatan ? $row->jabatan->nama_jabatan : '';
            })
            ->addColumn('induk_unit_kerja_name', function ($row) {
                return $row->indukUnitKerja ? $row->indukUnitKerja->nama_induk_unit_kerja : '';
            })
            ->addColumn('unit_kerja_name', function ($row) {
                return $row->unitKerja ? $row->unitKerja->nama_unit_kerja : '';
            })
            ->editColumn('tanggal_masuk', function ($row) {
                return $row->tanggal_masuk ? $row->tanggal_masuk->format('d-m-Y') : '';
            })
            ->editColumn('tmt', function ($row) {
                return $row->tmt ? $row->tmt->format('d-m-Y') : '';
            })
            ->editColumn('tanggal_sk', function ($row) {
                return $row->tanggal_sk ? $row->tanggal_sk->format('d-m-Y') : '';
            })
            ->editColumn('tanggal_pelantikan', function ($row) {
                return $row->tanggal_pelantikan ? $row->tanggal_pelantikan->format('d-m-Y') : '';
            })
            ->addColumn('action', function($row){
                $editUrl = route('e-jabatan.edit', $row->id);
                $deleteUrl = route('e-jabatan.destroy', $row->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
                return "<a href='$editUrl' class='btn btn-primary btn-sm'>Edit</a>\n                        <form action='$deleteUrl' method='POST' style='display:inline-block;'>\n                            $csrf\n                            $method\n                            <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\ traditional_escape_sequence\")'>Delete</button>\n                        </form>";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RiwayatJabatan $model): QueryBuilder
    {
        return $model->newQuery()->with(['pegawai', 'jabatan', 'unitKerja', 'indukUnitKerja']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('riwayatjabatan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyle('os');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->visible(false),
            Column::make('pegawai_name')->title('Pegawai'),
            Column::make('jabatan_name')->title('Jabatan'),
            Column::make('induk_unit_kerja_name')->title('Induk Unit Kerja'),
            Column::make('unit_kerja_name')->title('Unit Kerja'),
            Column::make('jenis_jabatan'),
            Column::make('tanggal_masuk'),
            Column::make('tmt'),
            Column::make('jenis_pns'),
            Column::make('no_sk'),
            Column::make('tanggal_sk'),
            Column::make('pejabat_penetap'),
            Column::make('status_sumpah'),
            Column::make('no_pelantikan'),
            Column::make('tanggal_pelantikan'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.|
     */
    protected function filename(): string
    {
        return 'RiwayatJabatan_' . date('YmdHis');
    }
}
