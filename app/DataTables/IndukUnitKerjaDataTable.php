<?php

namespace App\DataTables;

use App\Models\IndukUnitKerja;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IndukUnitKerjaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<IndukUnitKerja> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($indukUnitKerja) {
                return view('induk_unit_kerja.action', compact('indukUnitKerja'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<IndukUnitKerja>
     */
    public function query(IndukUnitKerja $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('indukunitkerja-table')
                    ->columns($this->getColumns())
                    ->ajax(route('induk_unit_kerja.index'))
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
            Column::make('kode'),
            Column::make('nama_induk_unit_kerja')->title('Nama Induk Unit Kerja'),
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
        return 'IndukUnitKerja_' . date('YmdHis');
    }
}
