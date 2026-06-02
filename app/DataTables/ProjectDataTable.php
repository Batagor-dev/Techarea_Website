<?php

namespace App\DataTables;

use App\Models\Project;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProjectDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            // 🔹 Project Name (ID + EN)
            ->addColumn('project_name', function ($row) {
                return '<div>
                            <strong>'.$row->name_project_id.'</strong><br>
                            <small class="text-muted">'.$row->name_project_en.'</small>
                        </div>';
            })

            // 🔹 Image preview
           ->addColumn('image', function ($row) {
                return $row->image
                    ? '<img src="'.$row->image.'" 
                            class="rounded-circle" 
                            style="width:50px;height:50px;object-fit:cover;">'
                    : '-';
            })

            // 🔹 Technology (JSON → badge)
            ->addColumn('technology', function ($row) {
                if (!$row->technology) return '-';

                $techs = is_array($row->technology)
                    ? $row->technology
                    : json_decode($row->technology, true);

                return collect($techs)->map(function ($tech) {
                    return '<span class="badge bg-primary me-1">'.$tech.'</span>';
                })->implode('');
            })

            // 🔹 Demo link
            ->addColumn('link_demo', function ($row) {
                return $row->link_demo
                    ? '<a href="'.$row->link_demo.'" target="_blank">Demo</a>'
                    : '-';
            })

            // 🔹 Action button
            ->addColumn('action', function ($row) {
                $edit = '<a href="'.route('project.edit', $row->slug).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon" 
                            title="Edit">
                            <i class="ri-edit-line"></i>
                         </a>';

                $delete = '
                    <form action="'.route('project.destroy', $row->slug).'" method="POST" style="display:inline-block;" class="delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>';

                return $edit . ' ' . $delete;
            })

            ->rawColumns(['project_name','image', 'technology', 'link_demo', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Project $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('project-table')
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
                    'searchPlaceholder' => 'Search project...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>'
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
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30),

            Column::computed('project_name')->title('Project Name'),

            Column::make('image')->title('Image')->orderable(false)->searchable(false),

            Column::make('technology')->title('Technology')->orderable(false)->searchable(false),

            Column::make('link_demo')->title('Demo'),

            Column::make('created_at')->title('Created'),

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
        return 'Projects_' . date('YmdHis');
    }
}