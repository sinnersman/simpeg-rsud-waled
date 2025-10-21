<?php

namespace App\DataTables;

use App\Models\PegawaiChangeRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminApprovalDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('pegawai_name', function (PegawaiChangeRequest $changeRequest) {
                return $changeRequest->pegawai->nama_lengkap ?? 'N/A';
            })
            ->addColumn('requested_by_name', function (PegawaiChangeRequest $changeRequest) {
                return $changeRequest->requestedBy->name ?? 'N/A';
            })
            ->addColumn('action', function (PegawaiChangeRequest $changeRequest) {
                return view('admin.approvals.action', compact('changeRequest'))->render();
            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->editColumn('created_at', function (PegawaiChangeRequest $changeRequest) {
                return $changeRequest->created_at->format('d-m-Y H:i:s');
            });
    }

    public function query(PegawaiChangeRequest $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['pegawai', 'requestedBy'])
            ->where('status', 'pending')
            ->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('adminapprovals-table')
            ->columns($this->getColumns())
            ->ajax(route('admin.approvals.index'))
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(false);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No.')->orderable(false)->searchable(false),
            Column::make('pegawai_name')->title('Pegawai'),
            Column::make('field_name')->title('Field'),
            Column::make('old_value')->title('Nilai Lama'),
            Column::make('new_value')->title('Nilai Baru'),
            Column::make('requested_by_name')->title('Diajukan Oleh'),
            Column::make('created_at')->title('Diajukan Pada'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'AdminApproval_' . date('YmdHis');
    }
}