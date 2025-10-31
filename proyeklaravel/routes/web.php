<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RasHewanController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\JenisHewanController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\KategoriKlinisController;
use App\Http\Controllers\DetailRekamMedisController;
use App\Http\Controllers\KodeTindakanTerapiController;
use App\Http\Controllers\DashboardAdminController;

// Halaman umum
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/CekKoneksi', [HomeController::class, 'CekKoneksi'])->name('CekKoneksi');
Route::get('/struktur', [HomeController::class, 'struktur'])->name('struktur');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/visi', [HomeController::class, 'visi'])->name('visi');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginProcess'])->name('login.process');

// ADMIN ROUTES
   
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('isAdministrator')->group(function () {
    Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
  
    Route::get('/jenishewan', [JenisHewanController::class, 'index'])->name('jenishewan.index');
  
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/rashewan', [RasHewanController::class, 'index'])->name('rashewan.index');
    Route::get('/detailrekammedis', [DetailRekamMedisController::class, 'index'])->name('detailrekammedis.index');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategoriklinis', [KategoriKlinisController::class, 'index'])->name('kategoriklinis.index');
    Route::get('/kodetindakanterapi', [KodeTindakanTerapiController::class, 'index'])->name('kodetindakanterapi.index');
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/rekammedis', [RekamMedisController::class, 'index'])->name('rekammedis.index');
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roleuser', [RoleUserController::class, 'index'])->name('roleuser.index');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');

  
    });
});
