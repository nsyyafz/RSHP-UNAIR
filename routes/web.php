<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\PerawatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RolesUserController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\TemuDokterController;
use App\Http\Controllers\Admin\KodeTindakanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\KategoriKlinisController;
// Dokter
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Dokter\PetController as DokterPetController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;
use App\Http\Controllers\Dokter\ProfileController;
// Perawat
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Perawat\PetController as PerawatPetController;
use App\Http\Controllers\Perawat\RekamMedisController as PerawatRekamMedisController;
use App\Http\Controllers\Perawat\ProfileController as PerawatProfileController;
// Resepsionis
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\PemilikController as ResepsionisPemilikController;
use App\Http\Controllers\Resepsionis\TemuDokterController as ResepsionisTemuDokterController;
use App\Http\Controllers\Resepsionis\PetController as ResepsionisPetController;
// Pemilik
use App\Http\Controllers\Pemilik\DashboardPemilikController;
use App\Http\Controllers\Pemilik\PetController as PemilikPetController;
use App\Http\Controllers\Pemilik\RekamMedisController as PemilikRekamMedisController;
use App\Http\Controllers\Pemilik\ProfileController as PemilikProfileController;
use App\Http\Controllers\Pemilik\TemuDokterController as PemilikTemuDokterController;


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
    // Dokter Routes
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
    Route::get('/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
    Route::post('/dokter', [DokterController::class, 'store'])->name('dokter.store');
    Route::get('/dokter/{id}/edit', [DokterController::class, 'edit'])->name('dokter.edit');
    Route::put('/dokter/{id}', [DokterController::class, 'update'])->name('dokter.update');
    Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');
    // Perawat Routes
    Route::get('/perawat', [PerawatController::class, 'index'])->name('perawat.index');
    Route::get('/perawat/create', [PerawatController::class, 'create'])->name('perawat.create');
    Route::post('/perawat', [PerawatController::class, 'store'])->name('perawat.store');
    Route::get('/perawat/{id}/edit', [PerawatController::class, 'edit'])->name('perawat.edit');
    Route::put('/perawat/{id}', [PerawatController::class, 'update'])->name('perawat.update');
    Route::delete('/perawat/{id}', [PerawatController::class, 'destroy'])->name('perawat.destroy');
    // Rekam Medis Routes
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{id}/edit', [RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam-medis.update');
    Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy'); 
    Route::post('/rekam-medis/{id}/detail', [RekamMedisController::class, 'storeDetail'])->name('rekam-medis.detail.store');
    Route::put('/rekam-medis/{id}/detail/{iddetail}', [RekamMedisController::class, 'updateDetail'])->name('rekam-medis.detail.update');
    Route::delete('/rekam-medis/{id}/detail/{iddetail}', [RekamMedisController::class, 'destroyDetail'])->name('rekam-medis.detail.destroy');
    // Temu Dokter Routes
    Route::get('/temu-dokter', [TemuDokterController::class, 'index'])->name('temu-dokter.index');
    Route::get('/temu-dokter/create', [TemuDokterController::class, 'create'])->name('temu-dokter.create');
    Route::post('/temu-dokter', [TemuDokterController::class, 'store'])->name('temu-dokter.store');
    Route::get('/temu-dokter/{id}/edit', [TemuDokterController::class, 'edit'])->name('temu-dokter.edit');
    Route::put('/temu-dokter/{id}', [TemuDokterController::class, 'update'])->name('temu-dokter.update');
    Route::delete('/temu-dokter/{id}', [TemuDokterController::class, 'destroy'])->name('temu-dokter.destroy');
    });
});

Route::middleware('isResepsionis')->group(function () {
    Route::prefix('resepsionis')->group(function () {
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])->name('resepsionis.dashboard');    
    // Temu Dokter Routes
    Route::get('/temu-dokter', [ResepsionisTemuDokterController::class, 'index'])->name('resepsionis.temu-dokter.index');
    Route::get('/temu-dokter/create', [ResepsionisTemuDokterController::class, 'create'])->name('resepsionis.temu-dokter.create');
    Route::post('/temu-dokter', [ResepsionisTemuDokterController::class, 'store'])->name('resepsionis.temu-dokter.store');
    Route::get('/temu-dokter/{id}/edit', [ResepsionisTemuDokterController::class, 'edit'])->name('resepsionis.temu-dokter.edit');
    Route::put('/temu-dokter/{id}', [ResepsionisTemuDokterController::class, 'update'])->name('resepsionis.temu-dokter.update');
    Route::delete('/temu-dokter/{id}', [ResepsionisTemuDokterController::class, 'destroy'])->name('resepsionis.temu-dokter.destroy');
    // Pemilik Routes
    Route::get('/pemilik', [ResepsionisPemilikController::class, 'index'])->name('resepsionis.pemilik.index');
    Route::get('/pemilik/create', [ResepsionisPemilikController::class, 'create'])->name('resepsionis.pemilik.create');
    Route::post('/pemilik', [ResepsionisPemilikController::class, 'store'])->name('resepsionis.pemilik.store');
    Route::get('/pemilik/{id}/edit', [ResepsionisPemilikController::class, 'edit'])->name('resepsionis.pemilik.edit');
    Route::put('/pemilik/{id}', [ResepsionisPemilikController::class, 'update'])->name('resepsionis.pemilik.update');
    Route::delete('/pemilik/{id}', [ResepsionisPemilikController::class, 'destroy'])->name('resepsionis.pemilik.destroy');
    // Pet Routes
    Route::get('/pet', [ResepsionisPetController::class, 'index'])->name('resepsionis.pet.index');
    Route::get('/pet/create', [ResepsionisPetController::class, 'create'])->name('resepsionis.pet.create');
    Route::post('/pet', [ResepsionisPetController::class, 'store'])->name('resepsionis.pet.store');
    Route::get('/pet/{id}/edit', [ResepsionisPetController::class, 'edit'])->name('resepsionis.pet.edit');
    Route::put('/pet/{id}', [ResepsionisPetController::class, 'update'])->name('resepsionis.pet.update');
    Route::delete('/pet/{id}', [ResepsionisPetController::class, 'destroy'])->name('resepsionis.pet.destroy'); 
    });
});

Route::middleware('isDokter')->group(function () {
    Route::prefix('dokter')->group(function () {
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dokter.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('dokter.profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('dokter.profile.edit'); // Tanpa {id}
    Route::put('/profile', [ProfileController::class, 'update'])->name('dokter.profile.update');
    Route::post('/profile/foto', [ProfileController::class, 'updateFoto'])->name('dokter.profile.foto');
    Route::get('/profile/statistik', [ProfileController::class, 'statistik'])->name('dokter.profile.statistik');
    // Rekam Medis Routes
    Route::get('/rekam-medis', [DokterRekamMedisController::class, 'index'])->name('dokter.rekam-medis.index');
    Route::get('/rekam-medis/{id}', [DokterRekamMedisController::class, 'show'])->name('dokter.rekam-medis.show');
    Route::post('/rekam-medis/{id}/detail', [DokterRekamMedisController::class, 'storeDetail'])->name('dokter.rekam-medis.detail.store');
    Route::put('/rekam-medis/{id}/detail/{iddetail}', [DokterRekamMedisController::class, 'updateDetail'])->name('dokter.rekam-medis.detail.update');
    Route::delete('/rekam-medis/{id}/detail/{iddetail}', [DokterRekamMedisController::class, 'destroyDetail'])->name('dokter.rekam-medis.detail.destroy');
    // Pet Routes
    Route::get('/pet', [DokterPetController::class, 'index'])->name('dokter.pet.index');
    Route::get('/pet/{id}', [DokterPetController::class, 'show'])->name('dokter.pet.show');
    });
});

Route::middleware('isPerawat')->group(function () {
    Route::prefix('perawat')->group(function () {
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])->name('perawat.dashboard');
    Route::get('/profile', [PerawatProfileController::class, 'index'])->name('perawat.profile.index');
    Route::get('/profile/edit', [PerawatProfileController::class, 'edit'])->name('perawat.profile.edit');
    Route::put('/profile', [PerawatProfileController::class, 'update'])->name('perawat.profile.update');

    //Rekam Medis Routes
    Route::get('/rekam-medis', [PerawatRekamMedisController::class, 'index'])->name('perawat.rekam-medis.index');
    Route::get('/rekam-medis/{id}', [PerawatRekamMedisController::class, 'show'])->name('perawat.rekam-medis.show');
    Route::get('/rekam-medis/create', [PerawatRekamMedisController::class, 'create'])->name('perawat.rekam-medis.create');
    Route::post('/rekam-medis', [PerawatRekamMedisController::class, 'store'])->name('perawat.rekam-medis.store');
    Route::get('/rekam-medis/{id}/edit', [PerawatRekamMedisController::class, 'edit'])->name('perawat.rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [PerawatRekamMedisController::class, 'update'])->name('perawat.rekam-medis.update');
    Route::delete('/rekam-medis/{id}', [PerawatRekamMedisController::class, 'destroy'])->name('perawat.rekam-medis.destroy'); 
    // Pet Routes
    Route::get('/pet', [PerawatPetController::class, 'index'])->name('perawat.pet.index');
    Route::get('/pet/{id}', [PerawatPetController::class, 'show'])->name('perawat.pet.show');
    });
});

Route::middleware(['auth', 'isPemilik'])->group(function () {
    Route::prefix('pemilik')->group(function () {
    Route::get('/dashboard', [DashboardPemilikController::class, 'index'])->name('pemilik.dashboard');
    Route::get('/profile', [PemilikProfileController::class, 'index'])->name('pemilik.profile.index');
    Route::get('/profile/edit', [PemilikProfileController::class, 'edit'])->name('pemilik.profile.edit');
    Route::put('/profile', [PemilikProfileController::class, 'update'])->name('pemilik.profile.update');
    // Rekam Medis Routes
    Route::get('/rekam-medis', [PemilikRekamMedisController::class, 'index'])->name('pemilik.rekam-medis.index');
    Route::get('/rekam-medis/{id}', [PemilikRekamMedisController::class, 'show'])->name('pemilik.rekam-medis.show');
     // Pet Routes
    Route::get('/pet', [PemilikPetController::class, 'index'])->name('pemilik.pet.index');
    // Temu Dokter Routes
    Route::get('/temu-dokter', [PemilikTemuDokterController::class, 'index'])->name('pemilik.temu-dokter.index');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
