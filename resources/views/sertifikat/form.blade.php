@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($sertifikat_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $sertifikat_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title'     => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{ isset($sertifikat_data) 
        ? Breadcrumbs::render(Request::route()->getName(), $sertifikat_data) 
        : Breadcrumbs::render(Request::route()->getName()) 
    }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @isset($sertifikat_data) @method('PUT') @endisset
            @csrf

            <!-- Name ID -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Nama Sertifikat</label>
                <div class="col-sm-9">
                    <input type="text"
                        name="name_sertifikat_id"
                        class="form-control @error('name_sertifikat_id') is-invalid @enderror"
                        value="{{ old('name_sertifikat_id', $sertifikat_data->name_sertifikat_id ?? '') }}">
                    <small class="text-muted">
                        Gunakan nama sertifikat dalam bahasa Indonesia yang jelas dan mudah dipahami.
                    </small>
                    @error('name_sertifikat_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-9">
                    <input type="file"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror">

                    @if(isset($sertifikat_data) && $sertifikat_data->image)
                        <div class="mt-2">
                            <div class="ratio ratio-16x9" style="max-width:200px;">
                                <img src="{{ asset('storage/' . $sertifikat_data->image) }}"
                                alt="Preview"
                                class="img-fluid rounded"
                                style="object-fit: cover;">
                            </div>
                        </div>
                    @endif

                    @if(isset($sertifikat_data) && $sertifikat_data->image)
                        <small class="text-muted d-block mt-2">
                            Current: {{ $sertifikat_data->image }}
                        </small>
                    @endif

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Published At -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Tanggal Sertifikat</label>
                <div class="col-sm-9">
                    <input type="date"
                        name="published_at"
                        class="form-control @error('published_at') is-invalid @enderror"
                        value="{{ old('published_at', isset($sertifikat_data->published_at) ? $sertifikat_data->published_at->format('Y-m-d') : '') }}">

                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea name="deskripsi_id"
                        class="form-control @error('deskripsi_id') is-invalid @enderror"
                        rows="3">{{ old('deskripsi_id', $sertifikat_data->deskripsi_id ?? '') }}</textarea>
                    <small class="text-muted">
                        Gunakan deskripsi sertifikat dalam bahasa Indonesia yang jelas dan mudah dipahami.
                    </small> 
                    @error('deskripsi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6">
                <div class="row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                        <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="window.location.href='{{ $breadcrumb_parent->url }}'">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection