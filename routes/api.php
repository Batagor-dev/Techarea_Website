<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan route API untuk aplikasi Anda.
| Route ini dimuat oleh RouteServiceProvider dan semuanya akan memiliki
| prefix "api" secara otomatis.
|
*/

// Route untuk mengambil semua data (Project & Sertifikat)
Route::get('/all-data', [DataController::class, 'allData']);

// Grouping route Project
Route::prefix('projects')->group(function () {
    // Detail Project menggunakan slug
    // URL: domain.com/api/projects/{slug}
    Route::get('/{project}', [DataController::class, 'showProject']);
});
