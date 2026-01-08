<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\StructureController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\KaderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/structure', [StructureController::class, 'index'])->name('structure');
Route::get('/structure/dpc/{slug}', [StructureController::class, 'dpcDetail'])->name('structure.dpc.detail');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Berita routes
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/berita/kategori/{slug}', [NewsController::class, 'byCategory'])->name('news.category');
Route::get('/structure/dpc/{slug}', [StructureController::class, 'dpcDetail'])->name('structure.dpc.detail');
// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');
// Kader routes
Route::get('/kader/register', [KaderController::class, 'create'])->name('kader.register');
Route::post('/kader/register', [KaderController::class, 'store'])->name('kader.store');
Route::get('/kader/status', [MembershipController::class, 'check'])->name('membership.check');
Route::post('/kader/verify', [MembershipController::class, 'verify'])->name('membership.verify');

Route::get('/api/dprt-by-dpc/{dpcId}', function ($dpcId) {
    $dprts = \App\Models\DPRT\Dprt::where('dpc_id', $dpcId)
        ->where('is_active', true)
        ->get();

    return response()->json($dprts);
})->name('api.dprt.by.dpc');

Route::prefix('kader')->name('kader.')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Front\KaderController::class, 'create'])
        ->name('register');
    Route::post('/register', [\App\Http\Controllers\Front\KaderController::class, 'store'])
        ->name('store');
});
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['role:super-admin,dpd-admin'])->prefix('berita/categories')->name('berita.categories.')->group(function () {
        Route::get('/', [BeritaCategoryController::class, 'index'])->name('index');
        Route::get('/create', [BeritaCategoryController::class, 'create'])->name('create');
        Route::post('/', [BeritaCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [BeritaCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [BeritaCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [BeritaCategoryController::class, 'destroy'])->name('destroy');
    });
});


// Route untuk logout paksa dengan view
Route::get('/force-logout', function () {
    return view('auth.force-logout');
})->name('force-logout-page');

Route::post('/force-logout', function () {
    Auth::logout();
    session()->flush();
    session()->regenerate();

    return redirect('/login')->with('success', 'Anda telah berhasil logout dari semua sesi.');
})->name('force-logout');
// Auth routes (Breeze)
require __DIR__ . '/auth.php';

// Admin routes
require __DIR__ . '/admin.php';
