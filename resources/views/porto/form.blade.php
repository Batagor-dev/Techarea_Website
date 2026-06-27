@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($portofolio_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $portofolio_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Portofolio | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ isset($portofolio_data) ? Breadcrumbs::render(Request::route()->getName(), $portofolio_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @isset($portofolio_data)
                @method('PUT')
            @endisset
            @csrf

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="kategori_portofolio_id">Kategori</label>
                <div class="col-sm-9">
                    <select name="kategori_portofolio_id" id="kategori_portofolio_id" class="form-select select2 @error('kategori_portofolio_id') is-invalid @enderror" data-allow-clear="true" >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori_portofolios ?? [] as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_portofolio_id', $portofolio_data->kategori_portofolio_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name_kategori_project_id }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_portofolio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name_project_id">Nama Project (ID)</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="name_project_id"
                        name="name_project_id"
                        class="form-control @error('name_project_id') is-invalid @enderror"
                        value="{{ old('name_project_id', $portofolio_data->name_project_id ?? '') }}"
                        placeholder="Nama project (Indonesia)">
                    @error('name_project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="image">Image</label>
                <div class="col-sm-9">
                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                    @if(isset($portofolio_data) && $portofolio_data->image)
                        <div class="mt-2">
                            <img src="{{ $portofolio_data->image }}" alt="Preview" class="img-fluid rounded" style="max-width: 220px;">
                        </div>
                    @endif
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="link_demo">Link Demo</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="link_demo"
                        name="link_demo"
                        class="form-control @error('link_demo') is-invalid @enderror"
                        value="{{ old('link_demo', $portofolio_data->link_demo ?? '') }}"
                        placeholder="https://...">
                    @error('link_demo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="deskripsi_id">Deskripsi (ID)</label>
                <div class="col-sm-9">
                    <textarea id="deskripsi_id" name="deskripsi_id" rows="3" class="form-control @error('deskripsi_id') is-invalid @enderror">{{ old('deskripsi_id', $portofolio_data->deskripsi_id ?? '') }}</textarea>
                    @error('deskripsi_id')
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


@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
@endpush