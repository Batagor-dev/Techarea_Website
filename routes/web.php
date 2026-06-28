<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Route untuk memicu login Google
Route::get('/auth/google', [App\Http\Controllers\SocialiteController::class, 'redirectToGoogle'])->name('google.login');

// Route callback tempat Google mengirim data kembali
Route::get('/auth/google/callback', [App\Http\Controllers\SocialiteController::class, 'handleGoogleCallback']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/user/role/{user}', [App\Http\Controllers\UserController::class, 'role'])->name('user.role');
    Route::post('/user/roleaction/{user}', [App\Http\Controllers\UserController::class, 'roleaction']);
    Route::resource('/user', App\Http\Controllers\UserController::class);

    Route::resource('/acount', App\Http\Controllers\AcountController::class)->only(['index', 'store']);
    Route::get('/acount/security', [App\Http\Controllers\AcountController::class, 'security'])->name('acount.security');
    Route::post('acount/password', [App\Http\Controllers\AcountController::class, 'updatePassword'])->name('acount.password');

    Route::post('/role/showaction/{role}', [App\Http\Controllers\RoleController::class, 'showaction']);
    Route::resource('/role', App\Http\Controllers\RoleController::class);


    Route::resource('/permissiongroup', App\Http\Controllers\PermissionGroupController::class)->except('show');

    Route::resource('/permission', App\Http\Controllers\PermissionController::class)->except('show');

    Route::resource('/menu', App\Http\Controllers\MenuController::class)->except('show');
    Route::resource('/setting', App\Http\Controllers\SettingController::class)->only(['index', 'store']);

    Route::resource('/article_categories', App\Http\Controllers\ArticleCategoryController::class, ['parameters' => [
        'article_categories' => 'articleCategory:slug'
    ]])->except('show');

    Route::resource('/article', App\Http\Controllers\ArticleController::class)->parameters([
        'article' => 'article:slug',
    ]);


    // Management Project
    Route::resource('/kategori_project', App\Http\Controllers\KategoriProjectController::class)->except('show');
    Route::resource('/project', App\Http\Controllers\ProjectController::class)->except('show');

    // Management Portofolio
    Route::resource('/kategori_portofolio', App\Http\Controllers\KategoriPortofolioController::class)->except('show');
    Route::resource('/portofolio', App\Http\Controllers\PortofolioController::class)->except('show');

    // Layana
    Route::resource('/kelas_paket', App\Http\Controllers\KelasPaketController::class)->except('show');
    Route::resource('/kategori_paket', App\Http\Controllers\KategoriPaketController::class)->except('show');
    Route::resource('/paket', App\Http\Controllers\PaketController::class)->except('show');

    // Testimoni
    Route::resource('/testimoni', App\Http\Controllers\TestimoniController::class)->except('show');

    // Perusahaan
    Route::resource('/perusahaan', App\Http\Controllers\PerusahaanController::class)->except('show');

    // Payment
    Route::resource('/payment', App\Http\Controllers\PaymentMethodController::class)->except('show');

    // Route::prefix('setting')->group(function () {
    //     Route::get('/',[App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    //     Route::get('/create',[App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
    //     Route::post('/store',[App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
    //     // Route::get('/edit/{setting}',[App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
    //     // Route::put('/update/{setting}',[App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
    //     Route::delete('/delete/{setting}',[App\Http\Controllers\SettingController::class, 'delete'])->name('setting.delete');
    // });
});
    