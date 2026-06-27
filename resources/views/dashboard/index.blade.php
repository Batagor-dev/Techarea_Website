@php
    $sub_title = ($breadcrumb = Breadcrumbs::current())
        ? $breadcrumb->title
        : 'Dashboard';
@endphp

@extends('layout.backend.main', [
    'title'     => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{ Breadcrumbs::render(Request::route()->getName()) }}

    {{-- ===================== STAT CARDS ===================== --}}
    <div class="row g-4 mb-4">
        @foreach ($stats as $item)
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-2">{{ $item['title'] }}</h6>
                            <h3 class="mb-0">{{ number_format($item['value']) }}</h3>
                        </div>
                        <div class="avatar avatar-sm rounded bg-label-{{ $item['color'] }} d-flex align-items-center justify-content-center">
                            <i class="{{ $item['icon'] }} ri-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===================== CHARTS ===================== --}}
    <div class="row g-4">

        {{-- Line Chart --}}
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Aktivitas Bulanan</h5>
                        <small class="text-muted">Perkembangan performa selama 7 bulan terakhir</small>
                    </div>
                    <span class="badge bg-label-primary">Live</span>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Doughnut Chart --}}
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Status Project</h5>
                    <small class="text-muted">Distribusi proyek saat ini</small>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="220"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== BOTTOM ROW ===================== --}}
    <div class="row g-4 mt-1">

        {{-- Update Terbaru --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Terbaru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Menambahkan 3 project baru</span>
                            <span class="text-muted small">2 jam lalu</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Artikel edukasi berhasil diterbitkan</span>
                            <span class="text-muted small">5 jam lalu</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Portofolio terbaru diperbarui</span>
                            <span class="text-muted small">1 hari lalu</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Catatan Singkat --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Catatan Singkat</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary mb-3">
                        Fokus minggu ini: tingkatkan kualitas landing page dan bantu klien yang sedang dalam tahap review.
                    </div>
                    <div class="alert alert-success mb-0">
                        Target bulan ini: capai 15 project selesai dan 10 artikel publikasi.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.9.4/dist/chart.umd.min.js"></script>
<script>
    (function () {
        'use strict';

        // ── Activity Line Chart ──────────────────────────────────────
        const activityCtx = document.getElementById('activityChart');

        if (activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($activityLabels),
                    datasets: [{
                        label: 'Aktivitas',
                        data: @json($activityData),
                        borderColor: '#696cff',
                        backgroundColor: 'rgba(105, 108, 255, 0.15)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 5,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true },
                    },
                },
            });
        }

        // ── Status Doughnut Chart ────────────────────────────────────
        const statusCtx = document.getElementById('statusChart');

        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#71dd37', '#ffab00', '#ff3e1d'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                },
            });
        }

    })();
</script>
@endpush