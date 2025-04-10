<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    UserController,
    KelasController,
    DashboardController,
    ListController,
};

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Halaman dashboard hanya bisa diakses jika login
Route::middleware('auth')->group(function () {
    // dashboard
    // Route::get('/dashboard', fn() => view('dashboard.dashboard'))->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // siswa
    Route::get('/siswa', [UserController::class, 'indexSiswa'])->name('siswa.index');
    Route::get('/siswa/create', [UserController::class, 'createSiswa'])->name('siswa.create');
    Route::post('/siswa/store', [UserController::class, 'storeSiswa'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [UserController::class, 'editSiswa'])->name('siswa.edit');
    Route::put('/siswa/{id}', [UserController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}', [UserController::class, 'destroySiswa'])->name('siswa.destroy');

    // guru
    Route::get('/guru', [UserController::class, 'indexGuru'])->name('guru.index');
    Route::get('/guru/create', [UserController::class, 'createGuru'])->name('guru.create');
    Route::post('/guru/store', [UserController::class, 'storeGuru'])->name('guru.store');
    Route::get('/guru/{id}/edit', [UserController::class, 'editGuru'])->name('guru.edit');
    Route::put('/guru/{id}', [UserController::class, 'updateGuru'])->name('guru.update');
    Route::delete('/guru/{id}', [UserController::class, 'destroyGuru'])->name('guru.destroy');
    // kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::get('/kelas/{id}', [KelasController::class, 'show'])->name('kelas.show');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::resource('kelas', KelasController::class);
    
    Route::get('/list', [ListController::class, 'index'])->name('list.index');

});
