<?php

namespace App\DataTables;

use App\Models\Cuti;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class CutiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Cuti> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('status_badge', function ($cuti) {
                $badgeClass = '';
                switch ($cuti->status) {
                    case 'pending':
                        $badgeClass = 'bg-warning';
                        break;
                    case 'approved':
                        $badgeClass = 'bg-success';
                        break;
                    case 'rejected':
                        $badgeClass = 'bg-danger';
                        break;
                    default:
                        $badgeClass = 'bg-secondary';
                        break;
                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($cuti->status) . '</span>';
            })
            ->addColumn('action', function ($cuti) {
                return view('e-layanan.cuti.action', compact('cuti'));
            })
            ->setRowId('id')
            ->rawColumns(['status_badge', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Cuti>
     */
    public function query(Cuti $model): QueryBuilder
    {
        // Filter cuti based on the authenticated user's pegawai_id
        return $model->newQuery()->where('pegawai_id', Auth::user()->pegawai->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cuti-table')
            ->columns($this->getColumns())
            ->ajax(route('cuti.index'))
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
            Column::make('start_date')->title('Tanggal Mulai'),
            Column::make('end_date')->title('Tanggal Selesai'),
            Column::make('reason')->title('Alasan'),
            Column::computed('status_badge')->title('Status')->exportable(false)->printable(false),
            Column::make('leave_type')->title('Jenis Cuti'),
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
        return 'Cuti_' . date('YmdHis');
    }
}
