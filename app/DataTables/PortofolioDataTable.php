<?php

namespace App\DataTables;

use App\Models\Portofolio;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PortofolioDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('kategori', function ($row) {
                return $row->kategoriPortofolio->name_kategori_project_id ?? '-';
            })
            ->addColumn('image', function ($row) {
                return $row->image ? '<img src="' . $row->image . '" alt="" style="width: 100px; height: auto; object-fit: cover; border-radius: 6px;">' : '-';
            })
            ->addColumn('action', function ($row) {
                $edit = '<a href="'.route('portofolio.edit', $row->slug).'"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i></a>';

                $delete = '
                            <form action="'.route('portofolio.destroy', $row->slug).'" method="POST" style="display:inline-block;" class="delete-form">
                                '.csrf_field().method_field('DELETE').'
                                <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                                    data-id="'.$row->slug.'"
                                    data-bs-toggle="tooltip" title="Delete">
                                    <i class="ri ri-delete-bin-line icon-20px"></i>
                                </button>
                            </form>';

                return $edit.' '.$delete;
            })
            ->rawColumns(['image', 'action']);
    }

    public function query(Portofolio $model)
    {
        return $model->newQuery()->with('kategoriPortofolio');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('portofolio-table')
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
                    'searchPlaceholder' => 'Search portfolio...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>'
                    ],
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30),
            Column::make('name_project_id')->title('Nama Project'),
            Column::make('kategori')->title('Kategori')->searchable(false)->orderable(false),
            Column::make('image')->title('Image')->searchable(false)->orderable(false)->width(100),
            Column::make('link_demo')->title('Demo')->searchable(false)->orderable(false),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Portofolio_' . date('YmdHis');
    }
}
