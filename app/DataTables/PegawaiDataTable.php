<?php

namespace App\DataTables;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon; // Import Carbon for date formatting

class PegawaiDataTable extends DataTable
{
    /**
    * Build the DataTable class.
    *
    * @param QueryBuilder<Pegawai> $query Results from query() method.
    */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('foto', function (Pegawai $pegawai) {
            $url = $pegawai->foto_pegawai ? asset($pegawai->foto_pegawai) : asset('path/to/default/avatar.png');
            return '<img src="' . $url . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
        })
        ->addColumn('tempat_tanggal_lahir', function (Pegawai $pegawai) {
            return $pegawai->tempat_lahir . ', ' . Carbon::parse($pegawai->tanggal_lahir)->format('d M Y');
        })
        ->addColumn('action', function (Pegawai $pegawai) {
            $editUrl = route('pegawai.edit', $pegawai->id);
            $showUrl = route('pegawai.show', $pegawai->id);
            $deleteUrl = route('pegawai.destroy', $pegawai->id);
            
            return '
                    <a href="' . $showUrl . '" class="btn btn-info btn-sm">Detail</a>
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                    </form>';
        })
        ->rawColumns(['foto', 'action']) // Mark 'foto' and 'action' columns as raw HTML
        ->setRowId('id');
    }
    
    /**
    * Get the query source of dataTable.
    *
    * @return QueryBuilder<Pegawai>
    */
    public function query(Pegawai $model): QueryBuilder
    {
        return $model->newQuery();
    }
    
    /**
    * Optional method if you want to use the html builder.
    */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('pegawai-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('<"row mb-3"<"col-md-6"B><"col-md-6 text-end"l<"mt-2"f>>>rtip') // Custom DOM for layout
        ->orderBy(1)
        ->selectStyleSingle()
        ->buttons([
            [
                'text' => 'Tambah Pegawai',
                'className' => 'btn btn-primary mt-2',
                'action' => 'function (e, dt, node, config) { window.location = \'' . route('pegawai.create') . '\'; }'
            ],
            [
                'extend' => 'collection',
                'text' => 'Filter Jenis Kelamin',
                'className' => 'btn btn-secondary dropdown-toggle mt-2',
                'buttons' => [
                    [
                        'text' => 'Semua',
                        'action' => 'function (e, dt, node, config) { dt.column(5).search(\'\').draw(); }'
                    ],
                    [
                        'text' => 'Laki-laki',
                        'action' => 'function (e, dt, node, config) { dt.column(5).search(\'Laki-laki\').draw(); }'
                    ],
                    [
                        'text' => 'Perempuan',
                        'action' => 'function (e, dt, node, config) { dt.column(5).search(\'Perempuan\').draw(); }'
                        ]
                        ]
                    ],
                    [
                        'extend' => 'collection',
                        'text' => 'Filter Status Kepegawaian',
                        'className' => 'btn btn-secondary dropdown-toggle mt-2',
                        'buttons' => [
                            [
                                'text' => 'Semua',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'\').draw(); }'
                            ],
                            [
                                'text' => 'ASN',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'ASN\').draw(); }'
                            ],
                            [
                                'text' => 'PNS',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'PNS\').draw(); }'
                            ],
                            [
                                'text' => 'PPPK',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'PPPK\').draw(); }'
                            ],
                            [
                                'text' => 'Kontrak',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'Kontrak\').draw(); }'
                            ],
                            [
                                'text' => 'Honorer',
                                'action' => 'function (e, dt, node, config) { dt.column(6).search(\'Honorer\').draw(); }'
                                ]
                                ]
                            ],
                        ]);
                    }
                    
                    /**
                    * Get the dataTable columns definition.
                    */
                    public function getColumns(): array
                    {
                        return [
                            Column::make('id')->title('#'),
                            Column::computed('foto')
                            ->exportable(false)
                            ->printable(false)
                            ->width(70)
                            ->addClass('text-center'),
                            Column::make('nip'),
                            Column::make('nama_lengkap'),
                            Column::computed('tempat_tanggal_lahir')
                            ->title('Tempat, Tgl Lahir')
                            ->exportable(true)
                            ->printable(true),
                            Column::make('jenis_kelamin'),
                            Column::make('status_kepegawaian'),
                            Column::computed('action')
                            ->exportable(false)
                            ->printable(false)
                            ->width(150)
                            ->addClass('text-center'),
                        ];
                    }
                    
                    /**
                    * Get the filename for export.
                    */
                    protected function filename(): string
                    {
                        return 'Pegawai_' . date('YmdHis');
                    }
                }
                