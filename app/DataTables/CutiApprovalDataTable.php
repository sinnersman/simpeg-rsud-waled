<?php

namespace App\DataTables;

use App\Models\Cuti;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class CutiApprovalDataTable extends DataTable
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
            ->addColumn('pegawai_name', function ($cuti) {
                return $cuti->pegawai->nama_lengkap ?? '-';
            })
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
                return view('e-layanan.cuti-approval.action', compact('cuti'));
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
        $user = Auth::user();
        return $model->newQuery()
            ->where(function (QueryBuilder $query) use ($user) {
                // Show to Level 1 Approver if pending Level 1 approval
                $query->where('approval_1_status', 'pending')
                      ->where('approver_1_id', $user->id); // Placeholder: Replace with actual logic to determine if $user is approver_1

                // Show to Level 2 Approver if Level 1 approved and pending Level 2 approval
                $query->orWhere(function (QueryBuilder $query) use ($user) {
                    $query->where('approval_1_status', 'approved')
                          ->where('approval_2_status', 'pending')
                          ->where('approver_2_id', $user->id); // Placeholder: Replace with actual logic to determine if $user is approver_2
                });
            })
            ->with('pegawai');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cuti-approval-table')
            ->columns($this->getColumns())
            ->ajax(route('cuti.approval.index'))
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
            Column::make('pegawai_name')->title('Nama Pegawai')->name('pegawai.nama_lengkap'),
            Column::make('start_date')->title('Tanggal Mulai'),
            Column::make('end_date')->title('Tanggal Selesai'),
            Column::make('reason')->title('Alasan'),
            Column::make('leave_type')->title('Jenis Cuti'),
            Column::computed('status_badge')->title('Status')->exportable(false)->printable(false),
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
        return 'CutiApproval_' . date('YmdHis');
    }
}
