<?php

namespace App\DataTables;

use App\Models\Invoice;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('client', function ($row) {
                return $row->client?->company_client ?? '-';
            })

            ->addColumn('payment_method', function ($row) {
                return $row->paymentMethod?->name_payment_method ?? '-';
            })

            ->editColumn('project_amount', function ($row) {
                return 'Rp '.number_format($row->project_amount, 0, ',', '.');
            })

            ->editColumn('invoice_date', function ($row) {
                return $row->invoice_date->format('d M Y');
            })

            ->editColumn('due_date', function ($row) {
                return $row->due_date->format('d M Y');
            })

            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('invoice.edit',$row->uuid).'"
                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                        data-bs-toggle="tooltip"
                        title="Edit">
                        <i class="ri ri-edit-line icon-20px"></i>
                    </a>';

                $delete = '
                    <form action="'.route('invoice.destroy',$row->uuid).'"
                        method="POST"
                        class="delete-form"
                        style="display:inline-block;">
                        '.csrf_field().'
                        '.method_field('DELETE').'

                        <button type="button"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="'.$row->uuid.'"
                            data-bs-toggle="tooltip"
                            title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>';

                return $edit.' '.$delete;
            })

            ->rawColumns(['action']);
    }

    public function query(Invoice $model)
    {
        return $model->newQuery()
            ->with([
                'client',
                'paymentMethod',
            ]);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('invoice-table')
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
                    'searchPlaceholder' => 'Search invoice...',
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

            Column::make('invoice_number')
                ->title('Invoice'),

            Column::computed('client')
                ->title('Client'),

            Column::computed('payment_method')
                ->title('Payment'),

            Column::make('invoice_date')
                ->title('Invoice Date'),

            Column::make('due_date')
                ->title('Due Date'),

            Column::make('project_amount')
                ->title('Amount'),

            Column::make('payment_status')
                ->title('Payment'),

            Column::make('status')
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
        return 'Invoice_' . date('YmdHis');
    }
}