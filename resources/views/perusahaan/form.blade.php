@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($perusahaan_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $perusahaan_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        // dd('tes2');
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
        {{ isset($perusahaan_data) ? Breadcrumbs::render(Request::route()->getName(), $perusahaan_data) : Breadcrumbs::render(Request::route()->getName()) }}
        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @isset($perusahaan_data)
                    @method('PUT')
                @endisset
                @csrf

                {{-- Nama Perusahaan --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name_perusahaan">
                        Nama Perusahaan <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="name_perusahaan"
                            name="name_perusahaan"
                            class="form-control @error('name_perusahaan') is-invalid @enderror"
                            value="{{ old('name_perusahaan', $perusahaan_data->name_perusahaan ?? '') }}"
                            placeholder="Masukkan nama perusahaan">

                        @error('name_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nomor Telepon --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="no_telp">
                        Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="no_telp"
                            name="no_telp"
                            class="form-control @error('no_telp') is-invalid @enderror"
                            value="{{ old('no_telp', $perusahaan_data->no_telp ?? '') }}"
                            placeholder="081234567890">

                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="email">
                        Email <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $perusahaan_data->email ?? '') }}"
                            placeholder="company@example.com">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="alamat">
                        Alamat <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="4"
                            class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Masukkan alamat perusahaan">{{ old('alamat', $perusahaan_data->alamat ?? '') }}</textarea>

                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Logo --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="logo">
                        Logo
                    </label>
                    <div class="col-sm-9">

                        @if(isset($perusahaan_data) && $perusahaan_data->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $perusahaan_data->logo) }}"
                                    alt="Logo"
                                    class="rounded border"
                                    style="width:120px;max-height:120px;object-fit:contain;">
                            </div>
                        @endif

                        <input type="file"
                            id="logo"
                            name="logo"
                            class="form-control @error('logo') is-invalid @enderror"
                            accept="image/*">

                        <small class="text-muted">
                            Format: JPG, JPEG, PNG, WEBP, SVG. Maksimal 2 MB.
                        </small>

                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-4">
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-2">
                                Submit
                            </button>

                            <button type="reset"
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