<?php

namespace App\DataTables;

use App\Models\Testimoni;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TestimoniDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('rating', function ($row) {
                $stars = '';

                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row->rating) {
                        $stars .= '<i class="ri-star-fill text-warning"></i> ';
                    } else {
                        $stars .= '<i class="ri-star-line text-muted"></i> ';
                    }
                }

                return $stars;
            })

            ->addColumn('action', function ($row) {

                $edit = '<a href="' . route('testimoni.edit', $row->uuid) . '"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip"
                            title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="' . route('testimoni.destroy', $row->uuid) . '" method="POST" style="display:inline-block;" class="delete-form">
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

            ->rawColumns([
                'rating',
                'action',
            ]);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Testimoni $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('testimoni-table')
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
                    'searchPlaceholder' => 'Search testimonial...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>',
                    ],
                ],
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->searchable(false)
                ->orderable(false)
                ->width(30),

            Column::make('name_client')
                ->title('Nama Client'),

            Column::make('testimoni_client_id')
                ->title('Testimoni'),

            Column::computed('rating')
                ->title('Rating')
                ->searchable(false)
                ->orderable(false),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    /**
     * Export filename.
     */
    protected function filename(): string
    {
        return 'Testimoni_' . date('YmdHis');
    }
}