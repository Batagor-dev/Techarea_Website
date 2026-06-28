<?php

namespace App\DataTables;

use App\Models\Paket;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaketDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('kategori', function ($row) {
                return $row->kategoriPaket?->name_kategori_paket_id ?? '-';
            })

            ->addColumn('kelas', function ($row) {
                return $row->kelasPaket?->name_kelas_paket_id ?? '-';
            })

            ->editColumn('price_paket', function ($row) {
                return 'Rp ' . number_format($row->price_paket, 0, ',', '.');
            })

            ->editColumn('is_popular', function ($row) {
                return $row->is_popular
                    ? '<span class="badge bg-label-success">Popular</span>'
                    : '<span class="badge bg-label-secondary">No</span>';
            })

            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-label-success">Active</span>'
                    : '<span class="badge bg-label-danger">Inactive</span>';
            })

            ->addColumn('action', function ($row) {

                $edit = '<a href="' . route('paket.edit', $row->slug) . '"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip"
                            title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="' . route('paket.destroy', $row->slug) . '" method="POST" style="display:inline-block;" class="delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="' . $row->slug . '"
                            data-bs-toggle="tooltip"
                            title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>';

                return $edit . ' ' . $delete;
            })

            ->rawColumns([
                'action',
                'is_popular',
                'is_active',
            ]);
    }

    public function query(Paket $model)
    {
        return $model->newQuery()
            ->with([
                'kategoriPaket',
                'kelasPaket',
            ]);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('paket-table')
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
                    'searchPlaceholder' => 'Search package...',
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

            Column::make('name_paket_id')
                ->title('Nama Paket'),

            Column::computed('kategori')
                ->title('Kategori'),

            Column::computed('kelas')
                ->title('Kelas'),

            Column::make('price_paket')
                ->title('Harga'),

            Column::make('is_popular')
                ->title('Popular'),

            Column::make('is_active')
                ->title('Status'),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Paket_' . date('YmdHis');
    }
}