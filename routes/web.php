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
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;

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
    // Jenis Hewan Routes
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
    Route::get('/jenis-hewan/create', [JenisHewanController::class, 'create'])->name('jenis-hewan.create');
    Route::post('/jenis-hewan', [JenisHewanController::class, 'store'])->name('jenis-hewan.store');
    Route::get('/jenis-hewan/{id}/edit', [JenisHewanController::class, 'edit'])->name('jenis-hewan.edit');
    Route::put('/jenis-hewan/{id}', [JenisHewanController::class, 'update'])->name('jenis-hewan.update');
    Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroy'])->name('jenis-hewan.destroy');
    // Ras Hewan Routes
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan.index');
    Route::get('/ras-hewan/create', [RasHewanController::class, 'create'])->name('ras-hewan.create');
    Route::post('/ras-hewan', [RasHewanController::class, 'store'])->name('ras-hewan.store');
    Route::get('/ras-hewan/{id}/edit', [RasHewanController::class, 'edit'])->name('ras-hewan.edit');
    Route::put('/ras-hewan/{id}', [RasHewanController::class, 'update'])->name('ras-hewan.update');
    Route::delete('/ras-hewan/{id}', [RasHewanController::class, 'destroy'])->name('ras-hewan.destroy');
    // Kategori Routes
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    // Kategori Klinis Routes
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori-klinis.index');
    Route::get('/kategori-klinis/create', [KategoriKlinisController::class, 'create'])->name('kategori-klinis.create');
    Route::post('/kategori-klinis', [KategoriKlinisController::class, 'store'])->name('kategori-klinis.store');
    Route::get('/kategori-klinis/{id}/edit', [KategoriKlinisController::class, 'edit'])->name('kategori-klinis.edit');
    Route::put('/kategori-klinis/{id}', [KategoriKlinisController::class, 'update'])->name('kategori-klinis.update');
    Route::delete('/kategori-klinis/{id}', [KategoriKlinisController::class, 'destroy'])->name('kategori-klinis.destroy');
    // Kode Tindakan Routes
    Route::get('/kode-tindakan', [KodeTindakanController::class, 'index'])->name('kode-tindakan.index');
    Route::get('/kode-tindakan/create', [KodeTindakanController::class, 'create'])->name('kode-tindakan.create');
    Route::post('/kode-tindakan', [KodeTindakanController::class, 'store'])->name('kode-tindakan.store');
    Route::get('/kode-tindakan/{id}/edit', [KodeTindakanController::class, 'edit'])->name('kode-tindakan.edit');
    Route::put('/kode-tindakan/{id}', [KodeTindakanController::class, 'update'])->name('kode-tindakan.update'); 
    Route::delete('/kode-tindakan/{id}', [KodeTindakanController::class, 'destroy'])->name('kode-tindakan.destroy');
    // Pet Routes
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('/pet', [PetController::class, 'store'])->name('pet.store');
    Route::get('/pet/{id}/edit', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('/pet/{id}', [PetController::class, 'update'])->name('pet.update');
    Route::delete('/pet/{id}', [PetController::class, 'destroy'])->name('pet.destroy');
    // Role Routes
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    // User Routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    // Pemilik Routes
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/pemilik/create', [PemilikController::class, 'create'])->name('pemilik.create');
    Route::post('/pemilik', [PemilikController::class, 'store'])->name('pemilik.store');
    Route::get('/pemilik/{id}/edit', [PemilikController::class, 'edit'])->name('pemilik.edit');
    Route::put('/pemilik/{id}', [PemilikController::class, 'update'])->name('pemilik.update');
    Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])->name('pemilik.destroy');
    });
});

Route::middleware('isResepsionis')->group(function () {
    Route::prefix('resepsionis')->group(function () {
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])->name('resepsionis.dashboard');
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('resepsionis.jenis-hewan');
    Route::get('/pet', [PetController::class, 'index'])->name('resepsionis.pet');
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('resepsionis.pemilik');
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('resepsionis.ras-hewan');
    });
});

Route::middleware('isDokter')->group(function () {
    Route::prefix('dokter')->group(function () {
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dokter.dashboard');
    });
});

Route::middleware('isPerawat')->group(function () {
    Route::prefix('perawat')->group(function () {
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])->name('perawat.dashboard');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('perawat.kategori');
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('perawat.kategori-klinis');
    Route::get('/kode-tindakan', [KodeTindakanController::class, 'index'])->name('perawat.kode-tindakan');
    });
});

Route::middleware('isPemilik')->group(function () {
    Route::prefix('pemilik')->group(function () {
    Route::get('/dashboard', [DashboardPemilikController::class, 'index'])->name('pemilik.dashboard');
    
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
