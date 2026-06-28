@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($kategori_paket_data)) {
        // dd('1');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $kategori_paket_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        // dd('2');
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
    {{ isset($kategori_paket_data) ? Breadcrumbs::render(Request::route()->getName(), $kategori_paket_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @isset($kategori_paket_data)
                @method('PUT')
            @endisset
            @csrf

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name_kategori_paket_id">Nama Kategori</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="name_kategori_paket_id"
                        name="name_kategori_paket_id"
                        class="form-control @error('name_kategori_paket_id') is-invalid @enderror"
                        value="{{ old('name_kategori_paket_id', $kategori_paket_data->name_kategori_paket_id ?? '') }}"
                        placeholder="Nama Kategori" />
                    @error('name_kategori_paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
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