<?php

namespace App\DataTables;

use App\Models\Perusahaan;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PerusahaanDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('logo', function ($row) {
                return $row->logo
                    ? '<img src="' . asset('storage/' . $row->logo) . '" alt="Logo" style="width: 70px; height: 70px; object-fit: contain; border-radius: 6px;">'
                    : '-';
            })
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('perusahaan.edit', $row->uuid) . '"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="' . route('perusahaan.destroy', $row->uuid) . '" method="POST" style="display:inline-block;" class="delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="' . $row->uuid . '"
                            data-bs-toggle="tooltip"
                            title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['logo', 'action']);
    }

    public function query(Perusahaan $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('perusahaan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->responsive(true)
            ->addTableClass('table table-bordered table-hover align-middle bg-white')
            ->parameters([
                'dom' => '<"row mb-3"
                            <"col-md-6 d-flex align-items-center"l>
                            <"col-md-6 d-flex justify-content-end"f>
                          >
                          <"table-responsive"tr>
                          <"row mt-3"
                            <"col-md-6"i>
                            <"col-md-6 d-flex justify-content-end"p>
                          >',
                'language' => [
                    'search' => 'Search',
                    'searchPlaceholder' => 'Search perusahaan...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>',
                    ],
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->searchable(false)
                ->orderable(false)
                ->width(30),

            Column::make('name_perusahaan')
                ->title('Nama Perusahaan'),

            Column::make('no_telp')
                ->title('No. Telepon'),

            Column::make('email')
                ->title('Email'),

            Column::make('alamat')
                ->title('Alamat'),

            Column::make('logo')
                ->title('Logo')
                ->searchable(false)
                ->orderable(false)
                ->width(100),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Perusahaan_' . date('YmdHis');
    }
}