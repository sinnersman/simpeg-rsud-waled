<?php

namespace App\DataTables;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UnitKerjaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UnitKerja> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('induk_unit_kerja', function (UnitKerja $unitKerja) {
                return $unitKerja->indukUnitKerja->nama_induk_unit_kerja;
            })
            ->addColumn('action', function ($unitKerja) {
                return view('unit_kerja.action', compact('unitKerja'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UnitKerja>
     */
    public function query(UnitKerja $model): QueryBuilder
    {
        return $model->newQuery()->with('indukUnitKerja');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('unitkerja-table')
                    ->columns($this->getColumns())
                    ->ajax(route('unit_kerja.index'))
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('induk_unit_kerja')->title('Induk Unit Kerja'),
            Column::make('kode'),
            Column::make('nama_unit_kerja')->title('Nama Unit Kerja'),
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
        return 'UnitKerja_' . date('YmdHis');
    }
}
