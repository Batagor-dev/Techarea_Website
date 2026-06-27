@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($kategori_portofolio_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $kategori_portofolio_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Kategori Portofolio | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ isset($kategori_portofolio_data) ? Breadcrumbs::render(Request::route()->getName(), $kategori_portofolio_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @isset($kategori_portofolio_data)
                @method('PUT')
            @endisset
            @csrf

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name_kategori_project_id">Nama Kategori (ID)</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="name_kategori_project_id"
                        name="name_kategori_project_id"
                        class="form-control @error('name_kategori_project_id') is-invalid @enderror"
                        value="{{ old('name_kategori_project_id', $kategori_portofolio_data->name_kategori_project_id ?? '') }}"
                        placeholder="Nama Kategori (ID)" />
                    @error('name_kategori_project_id')
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
