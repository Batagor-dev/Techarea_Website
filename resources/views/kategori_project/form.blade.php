@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($kategori_project_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $kategori_project_data)
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
    {{ isset($kategori_project_data) ? Breadcrumbs::render(Request::route()->getName(), $kategori_project_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @isset($kategori_project_data)
                @method('PUT')
            @endisset
            @csrf

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="nama_kategori">Nama Kategori</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="nama_kategori"
                        name="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        value="{{ old('nama_kategori', $kategori_project_data->nama_kategori ?? '') }}"
                        placeholder="Nama Kategori" />
                    @error('nama_kategori')
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