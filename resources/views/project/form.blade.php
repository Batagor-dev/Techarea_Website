@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($project_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $project_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Project | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ isset($project_data) ? Breadcrumbs::render(Request::route()->getName(), $project_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @csrf
            @isset($project_data) @method('PUT') @endisset

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="kategori_project_id">Kategori Project<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="kategori_project_id" name="kategori_project_id" class="form-select select2" data-allow-clear="true">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori_projects as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_project_id', $project_data->kategori_project_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_project_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="name_project">Nama Project<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="name_project" name="name_project"
                        class="form-control @error('name_project') is-invalid @enderror"
                        value="{{ old('name_project', $project_data->name_project ?? '') }}"
                        placeholder="Nama project">
                    @error('name_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="deskripsi_project">Deskripsi Project</label>
                <div class="col-sm-9">
                    <textarea id="deskripsi_project" name="deskripsi_project" rows="4"
                        class="form-control @error('deskripsi_project') is-invalid @enderror"
                        placeholder="Deskripsi project">{{ old('deskripsi_project', $project_data->deskripsi_project ?? '') }}</textarea>
                    @error('deskripsi_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="status_project">Status<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="status_project" name="status_project" class="form-select select2" data-allow-clear="true">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori_projects as $kategori)
                           <option value="pending" {{ old('status_project', $project_data->status_project ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dikerjakan" {{ old('status_project', $project_data->status_project ?? '') == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                            <option value="selesai" {{ old('status_project', $project_data->status_project ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status_project', $project_data->status_project ?? '') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        @endforeach
                    </select>
                    @error('status_project')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mt-4 row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ isset($breadcrumb_parent->url) ? $breadcrumb_parent->url : route('project.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: '-- Pilih --',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush