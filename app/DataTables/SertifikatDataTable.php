<?php

namespace App\DataTables;

use App\Models\Sertifikat;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SertifikatDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            // 🔹 Nama Sertifikat (ID + EN)
            ->addColumn('sertifikat_name', function ($row) {
                return '<div>
                            <strong>'.$row->name_sertifikat_id.'</strong><br>
                            <small class="text-muted">'.$row->name_sertifikat_en.'</small>
                        </div>';
            })

            // 🔹 Image preview
            ->addColumn('image', function ($row) {
                return $row->image
                    ? '<img src="'.$row->image.'" 
                            class="rounded" 
                            style="width:60px;height:60px;object-fit:cover;">'
                    : '-';
            })

            // 🔹 Tanggal publish
            ->addColumn('published_at', function ($row) {
                return $row->published_at
                    ? \Carbon\Carbon::parse($row->published_at)->format('d M Y')
                    : '-';
            })

            // 🔹 Action button
            ->addColumn('action', function ($row) {
                $edit = '<a href="'.route('sertifikat.edit', $row->slug).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon" 
                            title="Edit">
                            <i class="ri-edit-line"></i>
                         </a>';

                $delete = '
                    <form action="'.route('sertifikat.destroy', $row->slug).'" method="POST" style="display:inline-block;" class="delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>';

                return $edit . ' ' . $delete;
            })

            ->rawColumns(['sertifikat_name','image','action']);
    }

    public function query(Sertifikat $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('sertifikat-table')
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
                    'searchPlaceholder' => 'Search sertifikat...',
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

            Column::computed('sertifikat_name')->title('Sertifikat'),

            Column::make('image')->title('Image')->orderable(false)->searchable(false),

            Column::make('published_at')->title('Published'),

            Column::make('created_at')->title('Created'),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Sertifikat_' . date('YmdHis');
    }
}