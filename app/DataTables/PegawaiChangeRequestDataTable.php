<?php

namespace App\DataTables;

use App\Models\PegawaiChangeRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

class PegawaiChangeRequestDataTable extends DataTable
{
    public $pegawaiId;

    public function __construct($pegawaiId = null)
    {
        $this->pegawaiId = $pegawaiId;
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('field_name', function (PegawaiChangeRequest $changeRequest) {
                // You might want to make field names more readable
                return ucwords(str_replace('_', ' ', $changeRequest->field_name));
            })
            ->editColumn('old_value', function (PegawaiChangeRequest $changeRequest) {
                if ($changeRequest->field_name === 'foto_pegawai') {
                    return $changeRequest->old_value ? '<img src="' . Storage::url($changeRequest->old_value) . '" alt="Old Photo" style="max-width: 50px; max-height: 50px;">' : '-';
                }
                return $changeRequest->old_value ?? '-';
            })
            ->editColumn('new_value', function (PegawaiChangeRequest $changeRequest) {
                if ($changeRequest->field_name === 'foto_pegawai') {
                    return $changeRequest->new_value ? '<img src="' . Storage::url($changeRequest->new_value) . '" alt="New Photo" style="max-width: 50px; max-height: 50px;">' : '-';
                }
                return $changeRequest->new_value ?? '-';
            })
            ->editColumn('status', function (PegawaiChangeRequest $changeRequest) {
                $badgeClass = '';
                switch ($changeRequest->status) {
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
                return '<span class="badge ' . $badgeClass . '">' . $changeRequest->status . '</span>';
            })
            ->editColumn('created_at', function (PegawaiChangeRequest $changeRequest) {
                return $changeRequest->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('approved_at', function (PegawaiChangeRequest $changeRequest) {
                return $changeRequest->approved_at ? $changeRequest->approved_at->format('d-m-Y H:i:s') : '-';
            })
            ->addColumn('rejection_reason_display', function (PegawaiChangeRequest $changeRequest) {
                if ($changeRequest->status === 'rejected' && $changeRequest->rejection_reason) {
                    return '<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal" data-reason="' . htmlspecialchars($changeRequest->rejection_reason) . '">Lihat Alasan</button>';
                }
                return '-';
            })
            ->rawColumns(['old_value', 'new_value', 'status', 'rejection_reason_display'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PegawaiChangeRequest $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('pegawai_id', $this->pegawaiId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pegawaichangerequests-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5) // Order by created_at
            ->selectStyleSingle()
            ->responsive(true) // Make it responsive
            ->autoWidth(false) // Disable auto-width to allow responsive to work better
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', 'reset', 'reload'],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No.')->orderable(false)->searchable(false),
            Column::make('field_name')->title('Field'),
            Column::make('old_value')->title('Nilai Lama'),
            Column::make('new_value')->title('Nilai Baru'),
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Diajukan Pada'),
            Column::make('approved_at')->title('Disetujui/Ditolak Pada'),
            Column::computed('rejection_reason_display')->title('Alasan Penolakan')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PegawaiChangeRequest_' . date('YmdHis');
    }
}
