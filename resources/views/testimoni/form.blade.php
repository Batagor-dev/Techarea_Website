@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($testimoni_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $testimoni_data)
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
    {{ isset($testimoni_data) ? Breadcrumbs::render(Request::route()->getName(), $testimoni_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @csrf
            @isset($testimoni_data) @method('PUT') @endisset

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="name_client">Nama Klien<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="name_client" name="name_client"
                        class="form-control @error('name_client') is-invalid @enderror"
                        value="{{ old('name_client', $testimoni_data->name_client ?? '') }}"
                        placeholder="Nama Client">
                    @error('name_client')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="testimoni_client_id">Testimoni Client</label>
                <div class="col-sm-9">
                    <textarea id="testimoni_client_id" name="testimoni_client_id" rows="4"
                        class="form-control @error('testimoni_client_id') is-invalid @enderror"
                        placeholder="Deskripsi Project">{{ old('testimoni_client_id', $testimoni_data->testimoni_client_id ?? '') }}</textarea>
                    @error('testimoni_client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">
                    Rating <span class="text-danger">*</span>
                </label>

                <div class="col-sm-9">
                    <input type="hidden" name="rating" id="rating"
                        value="{{ old('rating', $testimoni_data->rating ?? 5) }}">

                    <div id="rating-stars" class="fs-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="ri-star-line star"
                                data-value="{{ $i }}"
                                style="cursor:pointer;"></i>
                        @endfor
                    </div>

                    @error('rating')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-4 row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ isset($breadcrumb_parent->url) ? $breadcrumb_parent->url : route('testimoni.index') }}" class="btn btn-outline-secondary">Cancel</a>
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

    document.addEventListener('DOMContentLoaded', function () {

        const stars = document.querySelectorAll('#rating-stars .star');
        const input = document.getElementById('rating');

        function renderStars(rating) {
            stars.forEach((star, index) => {

                if (index < rating) {
                    star.classList.remove('ri-star-line');
                    star.classList.add('ri-star-fill', 'text-warning');
                } else {
                    star.classList.remove('ri-star-fill', 'text-warning');
                    star.classList.add('ri-star-line');
                }

            });
        }

        renderStars(parseInt(input.value));

        stars.forEach((star) => {

            star.addEventListener('click', function () {

                input.value = this.dataset.value;

                renderStars(parseInt(input.value));

            });

        });

    });
</script>
@endpush