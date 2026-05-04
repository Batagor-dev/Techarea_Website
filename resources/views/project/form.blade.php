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

     $selectedTech = old('technology', isset($project_data) 
        ? (is_array($project_data->technology) 
            ? $project_data->technology 
            : json_decode($project_data->technology, true)) 
        : []);
@endphp

@extends('layout.backend.main', [
    'title'     => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    {{ isset($project_data) 
        ? Breadcrumbs::render(Request::route()->getName(), $project_data) 
        : Breadcrumbs::render(Request::route()->getName()) 
    }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @isset($project_data) @method('PUT') @endisset
            @csrf

            <!-- Name ID -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Name Project</label>
                <div class="col-sm-9">
                    <input type="text"
                        name="name_project_id"
                        class="form-control @error('name_project_id') is-invalid @enderror"
                        value="{{ old('name_project_id', $project_data->name_project_id ?? '') }}"
                        placeholder="Nama project (Indonesia)">
                     
                    <small class="text-muted">
                        Gunakan nama project dalam bahasa Indonesia yang jelas dan mudah dipahami.
                    </small>    
                    @error('name_project_id')
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
                        
                    @if(isset($project_data) && $project_data->image)
                        <div class="mt-2">
                            <div class="ratio ratio-16x9" style="max-width:200px;">
                                <img src="{{ asset('storage/' . $project_data->image) }}"
                                    alt="Preview"
                                    class="img-fluid rounded"
                                    style="object-fit: cover;">
                            </div>
                        </div>
                    @endif

                    @if(isset($project_data) && $project_data->image)
                        <small class="text-muted d-block mt-2">
                            Current: {{ $project_data->image }}
                        </small>
                    @endif

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Technology -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Technology</label>
                <div class="col-sm-9">
                    <div class="form-floating form-floating-outline select2-primary">
                        <select id="technology" name="technology[]" class="select2 form-select" multiple>
                            <option value="Laravel" {{ in_array('Laravel', $selectedTech ?? []) ? 'selected' : '' }}>Laravel</option>
                            <option value="React" {{ in_array('React', $selectedTech ?? []) ? 'selected' : '' }}>React</option>
                            <option value="Next.js" {{ in_array('Next.js', $selectedTech ?? []) ? 'selected' : '' }}>Next.js</option>
                            <option value="Vue" {{ in_array('Vue', $selectedTech ?? []) ? 'selected' : '' }}>Vue</option>
                            <option value="Tailwind" {{ in_array('Tailwind', $selectedTech ?? []) ? 'selected' : '' }}>Tailwind</option>
                            <option value="Node.js" {{ in_array('Node.js', $selectedTech ?? []) ? 'selected' : '' }}>Node.js</option>
                        </select>

                        <label for="technology">Technology</label>
                    </div>
                </div>
            </div>

            <!-- Link Demo -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Link Demo</label>
                <div class="col-sm-9">
                    <input type="text"
                        name="link_demo"
                        class="form-control @error('link_demo') is-invalid @enderror"
                        value="{{ old('link_demo', $project_data->link_demo ?? '') }}"
                        placeholder="https://...">
                    @error('link_demo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi ID -->
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Deskripsi Project</label>
                <div class="col-sm-9">
                    <textarea name="deskripsi_id"
                        class="form-control @error('deskripsi_id') is-invalid @enderror"
                        rows="3">{{ old('deskripsi_id', $project_data->deskripsi_id ?? '') }}</textarea>
                    
                    <small class="text-muted">
                        Gunakan deskripsi project dalam bahasa Indonesia yang jelas dan mudah dipahami.
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

@push('scripts')
<script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "-- Select Tech Stack --",
                allowClear: true,
                width: '100%'
            });
        });
</script>
@endpush