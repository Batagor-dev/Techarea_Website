@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($payment_method_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $payment_method_data)
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
    {{ isset($payment_method_data) ? Breadcrumbs::render(Request::route()->getName(), $payment_method_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @isset($payment_method_data)
                @method('PUT')
            @endisset
            @csrf

            {{-- Nama Payment Method --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name_payment_method">
                    Nama Payment Method
                </label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        id="name_payment_method"
                        name="name_payment_method"
                        class="form-control @error('name_payment_method') is-invalid @enderror"
                        value="{{ old('name_payment_method', $payment_method_data->name_payment_method ?? '') }}"
                        placeholder="Contoh: BCA, DANA, GoPay">

                    @error('name_payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tipe Payment Method --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="type_payment_method">
                    Tipe
                </label>
                <div class="col-sm-9">
                    <select
                        id="type_payment_method"
                        name="type_payment_method"
                        class="form-select select2 @error('type_payment_method') is-invalid @enderror" data-allow-clear="true">

                        <option value="">-- Pilih Tipe --</option>
                        <option value="bank"
                            {{ old('type_payment_method', $payment_method_data->type_payment_method ?? '') == 'bank' ? 'selected' : '' }}>
                            Bank
                        </option>

                        <option value="ewallet"
                            {{ old('type_payment_method', $payment_method_data->type_payment_method ?? '') == 'ewallet' ? 'selected' : '' }}>
                            E-Wallet
                        </option>

                        <option value="qris"
                            {{ old('type_payment_method', $payment_method_data->type_payment_method ?? '') == 'qris' ? 'selected' : '' }}>
                            QRIS
                        </option>
                    </select>

                    @error('type_payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Nama Pemilik Rekening --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="account_name">
                    Atas Nama
                </label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        id="account_name"
                        name="account_name"
                        class="form-control @error('account_name') is-invalid @enderror"
                        value="{{ old('account_name', $payment_method_data->account_name ?? '') }}"
                        placeholder="Nama Pemilik Rekening">

                    @error('account_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Nomor Rekening --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="account_number">
                    Nomor Rekening / Nomor Akun
                </label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        id="account_number"
                        name="account_number"
                        class="form-control @error('account_number') is-invalid @enderror"
                        value="{{ old('account_number', $payment_method_data->account_number ?? '') }}"
                        placeholder="Contoh: 1234567890">

                    @error('account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="is_active">Status Aktif</label>
                <div class="col-sm-9">
                    <input type="hidden" name="is_active" value="0">

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $payment_method_data->is_active ?? true) ? 'checked' : '' }}>
                    </div>

                    @error('is_active')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="pt-6">
                <div class="row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-4 prevent-double-submi">
                            Submit
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="window.location.href='{{ $breadcrumb_parent->url }}'">Cancel</button>
                    </div>
                </div>
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