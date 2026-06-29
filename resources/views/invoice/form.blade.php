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
                value="{{ old('name_client', $invoice_data->client->name_client ?? '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $invoice_data->client->email ?? '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-9">
            <input type="text"
                name="phone_number"
                class="form-control"
                value="{{ old('phone_number', $invoice_data->client->phone_number ?? '') }}">
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
            <input type="text"
                name="invoice_number"
                class="form-control"
                value="{{ old('invoice_number', $invoice_data->invoice_number ?? '') }}">
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
            <input type="date"
                name="invoice_date"
                class="form-control"
                value="{{ old('invoice_date', isset($invoice_data) ? $invoice_data->invoice_date->format('Y-m-d') : '') }}">
        </div>

        <label class="col-sm-1 col-form-label">Due</label>

        <div class="col-sm-4">
            <input type="date"
                name="due_date"
                class="form-control"
                value="{{ old('due_date', isset($invoice_data) ? $invoice_data->due_date->format('Y-m-d') : '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Project Amount</label>
        <div class="col-sm-9">
            <input type="number"
                name="project_amount"
                class="form-control"
                value="{{ old('project_amount', $invoice_data->project_amount ?? '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Status</label>

        <div class="col-sm-4">
            <select name="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <label class="col-sm-1 col-form-label">Payment</label>

        <div class="col-sm-4">
            <select name="payment_status" class="form-select">
                <option value="unpaid">Unpaid</option>
                <option value="partial">Partial</option>
                <option value="paid">Paid</option>
            </select>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-3 col-form-label">Notes</label>
        <div class="col-sm-9">
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $invoice_data->notes ?? '') }}</textarea>
        </div>
    </div>

    <hr>

    {{-- ================= ITEM ================= --}}
    <h5 class="my-4">Invoice Item</h5>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Item Name</label>
        <div class="col-sm-9">
            <input
    type="text"
    name="item_name"
    class="form-control"
    value="{{ old('item_name', isset($invoice_data) ? optional($invoice_data->items->first())->item_name : '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea name="item_description"
                class="form-control"
                rows="3">{{ old('item_description', isset($invoice_data) ? optional($invoice_data->items->first())->item_description : '') }}</textarea>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-3 col-form-label">Price</label>
        <div class="col-sm-9">
            <input
                type="number"
                name="item_price"
                class="form-control"
                value="{{ old('item_price', isset($invoice_data) ? optional($invoice_data->items->first())->item_price : '') }}">
        </div>
    </div>

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

        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('.prevent-double-submit').on('submit', function () {

            const $form = $(this);

            if ($form.data('submitted')) {
                return false;
            }

            $form.data('submitted', true);

            $form.find('button[type="submit"]')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
        });

    });
    </script>
@endpush