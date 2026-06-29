@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($invoice_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $invoice_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ isset($invoice_data) ? Breadcrumbs::render(Request::route()->getName(), $invoice_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
<form class="card-body prevent-double-submit" method="POST" action="{{ $action }}">
    @csrf
    @isset($invoice_data)
        @method('PUT')
    @endisset

    {{-- ================= CLIENT ================= --}}
    <h5 class="mb-4">Client Information</h5>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Company</label>
        <div class="col-sm-9">
            <input type="text"
                name="company_client"
                class="form-control @error('company_client') is-invalid @enderror"
                value="{{ old('company_client', $invoice_data->client->company_client ?? '') }}"
                placeholder="Company Name">

            @error('company_client')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">PIC Name</label>
        <div class="col-sm-9">
            <input type="text"
                name="name_client"
                class="form-control @error('name_client') is-invalid @enderror"
                value="{{ old('name_client', $invoice_data->client->name_client ?? '') }}"
                placeholder="PIC Name">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $invoice_data->client->email ?? '') }}"
                placeholder="Email">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-9">
            <input type="text"
                name="phone_number"
                class="form-control"
                value="{{ old('phone_number', $invoice_data->client->phone_number ?? '') }}"
                placeholder="Phone Number">
        </div>
    </div>

    <div class="row mb-5">
        <label class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-9">
            <textarea class="form-control"
                name="address"
                rows="3">{{ old('address', $invoice_data->client->address ?? '') }}</textarea>
        </div>
    </div>

    <hr>

    {{-- ================= INVOICE ================= --}}
    <h5 class="my-4">Invoice Information</h5>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Invoice Number</label>
        <div class="col-sm-9">
            <input
                type="text"
                class="form-control"
                value="{{ old('invoice_number', $invoice_data->invoice_number ?? $invoice_number) }}"
                readonly>

            <input
                type="hidden"
                name="invoice_number"
                value="{{ old('invoice_number', $invoice_data->invoice_number ?? $invoice_number) }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Payment Method</label>
        <div class="col-sm-9">
            <select name="payment_method_id" class="form-select select2">
                <option value="">Choose Payment Method</option>

                @foreach ($payment_methods as $item)
                    <option value="{{ $item->id }}"
                        {{ old('payment_method_id', $invoice_data->payment_method_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->name_payment_method }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Invoice Date</label>
        <div class="col-sm-4">
            <input
                type="date"
                id="invoice_date"
                name="invoice_date"
                class="form-control"
                value="{{ old('invoice_date', isset($invoice_data) ? $invoice_data->invoice_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
        </div>

        <label class="col-sm-1 col-form-label">Due</label>

        <div class="col-sm-4">
            <input
                type="date"
                id="due_date"
                name="due_date"
                class="form-control"
                value="{{ old('due_date', isset($invoice_data) ? $invoice_data->due_date->format('Y-m-d') : '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Project Amount</label>
        <div class="col-sm-9">
            <input
                type="text"
                id="project_amount"
                name="project_amount"
                class="form-control"
                value="{{ old('project_amount', isset($invoice_data) ? number_format($invoice_data->project_amount,0,',','.') : '') }}"
                readonly>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Status</label>

        <div class="col-sm-4">
            <select name="status" class="form-select select2">
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <label class="col-sm-1 col-form-label">Payment</label>

        <div class="col-sm-4">
            <select name="payment_status" class="form-select select2">

                <option value="unpaid" {{ old('payment_status', $invoice_data->payment_status ?? '') == 'unpaid' ? 'selected' : '' }}>
                    Unpaid
                </option>

                <option value="partial" {{ old('payment_status', $invoice_data->payment_status ?? '') == 'partial' ? 'selected' : '' }}>
                    Partial
                </option>

                <option value="paid" {{ old('payment_status', $invoice_data->payment_status ?? '') == 'paid' ? 'selected' : '' }}>
                    Paid
                </option>

            </select>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-3 col-form-label">Notes</label>
        <div class="col-sm-9">
            <textarea name="notes" class="form-control" rows="3" >{{ old('notes', $invoice_data->notes ?? '') }}</textarea>
        </div>
    </div>

    <hr>

    {{-- ================= ITEM ================= --}}
    <h5 class="my-4">Invoice Item</h5>

    <div id="invoice-items">

    @php
        $items = old('item_name')
            ? collect(old('item_name'))->map(function ($item, $i) {
                return (object)[
                    'item_name' => old('item_name')[$i],
                    'item_description' => old('item_description')[$i],
                    'item_price' => old('item_price')[$i],
                ];
            })
            : (isset($invoice_data)
                ? $invoice_data->invoiceItems
                : collect([(object)[
                    'item_name' => '',
                    'item_description' => '',
                    'item_price' => '',
                ]]));
    @endphp

    @foreach($items as $item)

    <div class="item-row border rounded p-3 mb-3">

        <div class="row">

            <div class="col-md-4">
                <label>Item</label>
                <input
                    type="text"
                    name="item_name[]"
                    class="form-control"
                    value="{{ $item->item_name }}"
                    required>
            </div>

            <div class="col-md-5">
                <label>Description</label>
                <input
                    type="text"
                    name="item_description[]"
                    class="form-control"
                    value="{{ $item->item_description }}"
                    required>
            </div>

            <div class="col-md-2">
                <label>Price</label>
                <input
                    type="text"
                    name="item_price[]"
                    class="form-control item-price"
                    value="{{ $item->item_price ? number_format($item->item_price,0,',','.') : '' }}"
                    required>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button
                    type="button"
                    class="btn btn-danger remove-item">
                    ×
                </button>
            </div>

        </div>

    </div>

    @endforeach

    </div>

    <button
        type="button"
        id="add-item"
        class="btn btn-success">
        + Add Item
    </button>

    <div class="text-end">
        <button class="btn btn-primary">Save Invoice</button>

        <a href="{{ $breadcrumb_parent->url }}"
            class="btn btn-outline-secondary">
            Cancel
        </a>
    </div>
</form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    initSelect2();
    initDueDate();
    initCurrencyFormatter();
    initInvoiceItems();
    initFormSubmit();

    // ================= SELECT2 =================

    function initSelect2() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    }

    // ================= DUE DATE =================

    function initDueDate() {

        updateDueDate();

        $('#invoice_date').on('change', updateDueDate);

        function updateDueDate() {

            const invoiceDate = $('#invoice_date').val();

            if (!invoiceDate) return;

            $('#due_date').attr('min', invoiceDate);

            if ($('#due_date').val() < invoiceDate) {
                $('#due_date').val(invoiceDate);
            }
        }

    }

    // ================= FORMAT RUPIAH =================

    function initCurrencyFormatter() {

        $(document).on('input', '.item-price', function () {

            let value = $(this).val().replace(/\D/g, '');

            $(this).val(
                new Intl.NumberFormat('id-ID').format(value)
            );

            calculateProjectAmount();

        });

        calculateProjectAmount();
    }

    // ================= HITUNG TOTAL =================

    function calculateProjectAmount() {

        let total = 0;

        $('.item-price').each(function () {

            let value = $(this).val()
                .replace(/\./g, '')
                .replace(/,/g, '');

            total += Number(value) || 0;

        });

        $('#project_amount').val(
            new Intl.NumberFormat('id-ID').format(total)
        );

    }

    // ================= ADD / REMOVE ITEM =================

    function initInvoiceItems() {

        $('#add-item').click(function () {

            let clone = $('.item-row:first').clone();

            clone.find('input').val('');

            $('#invoice-items').append(clone);

            calculateProjectAmount();

        });

        $(document).on('click', '.remove-item', function () {

            if ($('.item-row').length === 1) {
                alert('Minimal harus ada 1 item.');
                return;
            }

            $(this).closest('.item-row').remove();

            calculateProjectAmount();

        });

    }

    // ================= SUBMIT =================

    function initFormSubmit() {

        $('.prevent-double-submit').submit(function () {

            const form = $(this);

            if (form.data('submitted')) {
                return false;
            }

            form.data('submitted', true);

            form.find('button[type="submit"]')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

            $('#project_amount').val(
                $('#project_amount').val().replace(/\./g, '')
            );

            $('.item-price').each(function () {

                $(this).val(
                    $(this).val().replace(/\./g, '')
                );

            });

        });

    }

});
</script>
@endpush