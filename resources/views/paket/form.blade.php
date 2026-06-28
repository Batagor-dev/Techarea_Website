@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($paket_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $paket_data)
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
    {{ isset($paket_data) ? Breadcrumbs::render(Request::route()->getName(), $paket_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @isset($paket_data)
                @method('PUT')
            @endisset
            @csrf

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Kategori Paket</label>
                <div class="col-sm-9">
                    <select
                        name="kategori_paket_id"
                        class="form-select select2 @error('kategori_paket_id') is-invalid @enderror"  data-allow-clear="true">
                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($kategori_pakets as $item)
                            <option value="{{ $item->id }}"
                                {{ old('kategori_paket_id', $paket_data->kategori_paket_id ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->name_kategori_paket_id }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori_paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Kelas Paket</label>
                <div class="col-sm-9">
                    <select
                        name="kelas_paket_id"
                        class="form-select select2 @error('kelas_paket_id') is-invalid @enderror"  data-allow-clear="true">

                        <option value="">-- Pilih Kelas --</option>

                        @foreach ($kelas_pakets as $item)
                            <option value="{{ $item->id }}"
                                {{ old('kelas_paket_id', $paket_data->kelas_paket_id ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->name_kelas_paket_id }}
                            </option>
                        @endforeach
                    </select>

                    @error('kelas_paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name_paket_id">Nama Paket</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        id="name_paket_id"
                        name="name_paket_id"
                        class="form-control @error('name_paket_id') is-invalid @enderror"
                        value="{{ old('name_paket_id', $paket_data->name_paket_id ?? '') }}"
                        placeholder="Nama Paket">

                    @error('name_paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="description_paket_id">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea
                        id="description_paket_id"
                        name="description_paket_id"
                        rows="5"
                        class="form-control @error('description_paket_id') is-invalid @enderror"
                        placeholder="Deskripsi Paket">{{ old('description_paket_id', $paket_data->description_paket_id ?? '') }}</textarea>

                    @error('description_paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="price_paket">Harga</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        id="price_paket"
                        name="price_paket"
                        class="form-control @error('price_paket') is-invalid @enderror"
                        value="{{ old('price_paket', isset($paket_data) ? number_format($paket_data->price_paket, 0, ',', '.') : '') }}"
                        placeholder="Contoh: 1.500.000">

                    @error('price_paket')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="is_popular">Paket Populer</label>
                <div class="col-sm-9">
                    <input type="hidden" name="is_popular" value="0">

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_popular"
                            name="is_popular"
                            value="1"
                            {{ old('is_popular', $paket_data->is_popular ?? false) ? 'checked' : '' }}>
                    </div>

                    @error('is_popular')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                            {{ old('is_active', $paket_data->is_active ?? true) ? 'checked' : '' }}>
                    </div>

                    @error('is_active')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="pt-6">
                <div class="row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-4">Submit</button>
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

            const input = document.getElementById('price_paket');

            if (input) {

                input.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '');
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                });

                input.form.addEventListener('submit', function () {
                    input.value = input.value.replace(/\./g, '');
                });

            }

        });
    </script>
@endpush