<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RolesUserController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KodeTindakanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\KategoriKlinisController;

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek-koneksi');
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/struktur', [SiteController::class, 'struktur'])->name('struktur');
Route::get('/layanan-umum', [SiteController::class, 'layananUmum'])->name('layanan-umum');
Route::get('/visi-misi', [SiteController::class, 'visiMisi'])->name('visi-misi');
Route::get('/login', [SiteController::class, 'login'])->name('login');

Auth::routes();

Route::middleware('isAdministrator')->group(function () {
    Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan');
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori-klinis');
    Route::get('/kode-tindakan', [KodeTindakanController::class, 'index'])->name('kode-tindakan');
    Route::get('/pet', [PetController::class, 'index'])->name('pet')->name('pet');
    Route::get('/role', [RoleController::class, 'index'])->name('role')->name('role');
    Route::get('/user', [RolesUserController::class, 'index'])->name('user')->name('user');
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
