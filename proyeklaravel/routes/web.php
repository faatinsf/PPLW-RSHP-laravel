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
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\KategoriKlinisController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedis;
use App\Http\Controllers\Dokter\PetController as DokterPet;
use App\Http\Controllers\Dokter\PemilikController as DokterPemilik;
use App\Http\Controllers\DashboardPerawatController;
use App\Http\Controllers\DetailRekamMedisController;
use App\Http\Controllers\KodeTindakanTerapiController;
use App\Http\Controllers\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\AppointmentController;
use App\Http\Controllers\Resepsionis\TransaksiController;
use App\Http\Controllers\Resepsionis\PetController as ResepsionisPetController;
use App\Http\Controllers\Resepsionis\PemilikController as ResepsionisPemilikController;
use App\Http\Controllers\Resepsionis\RekamMedisController as ResepsionisRekamMedisController;

// Routes untuk Resepsionis
Route::prefix('resepsionis')->middleware(['auth', 'isResepsionis'])->group(function () {
 
});

// Halaman umum
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/CekKoneksi', [HomeController::class, 'CekKoneksi'])->name('CekKoneksi');
Route::get('/struktur', [HomeController::class, 'struktur'])->name('struktur');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/visi', [HomeController::class, 'visi'])->name('visi');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginProcess'])->name('login.process');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ADMIN ROUTES
Route::middleware('isAdministrator')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
        
        // Jenis Hewan - CRUD Lengkap
        Route::resource('jenis-hewan', JenisHewanController::class);
        
        // Pemilik
        Route::resource('pemilik', PemilikController::class);
        
        // Ras Hewan
        Route::resource('rashewan', RasHewanController::class);

         // Pet
        Route::resource('pet', PetController::class);

         // Rekam Medis
        Route::resource('rekammedis', RekamMedisController::class);
        
        // Detail Rekam Medis
        Route::resource('detailrekammedis', DetailRekamMedisController::class);
        
        // Kategori Klinis
        Route::resource('kategoriklinis', KategoriKlinisController::class);

        // Kategori - CRUD Lengkap
        Route::resource('kategori', KategoriController::class);

        // Kode Tindakan Terapi - CRUD Lengkap
        Route::resource('kodetindakanterapi', KodeTindakanTerapiController::class);
        
        // Routes lainnya
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kodetindakanterapi', [KodeTindakanTerapiController::class, 'index'])->name('kodetindakanterapi.index');
        Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
        Route::get('/rekammedis', [RekamMedisController::class, 'index'])->name('rekammedis.index');
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::get('/roleuser', [RoleUserController::class, 'index'])->name('roleuser.index');
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
    });
});

// DOKTER ROUTES
Route::middleware('isDokter')
    ->prefix('dokter')
    ->as('dokter.')
    ->group(function () {

        Route::get('/dashboard', [DashboardDokterController::class, 'index'])
            ->name('dashboard');
    
    // Rekam Medis Management (Full CRUD)
    Route::get('/rekam-medis', [App\Http\Controllers\Dokter\RekamMedisController::class, 'index'])
        ->name('rekam-medis.index');
    Route::get('/rekam-medis/{id}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'show'])
        ->name('rekam-medis.show');
    Route::get('/rekam-medis/{id}/edit', [App\Http\Controllers\Dokter\RekamMedisController::class, 'edit'])
        ->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'update'])
        ->name('rekam-medis.update');
    
    // Pet Management (READ ONLY)
    Route::get('/pet', [App\Http\Controllers\Dokter\PetController::class, 'index'])
        ->name('pet.index');
    Route::get('/pet/{id}', [App\Http\Controllers\Dokter\PetController::class, 'show'])
        ->name('pet.show');
    
    // Pemilik Management (READ ONLY)
    Route::get('/pemilik', [App\Http\Controllers\Dokter\PemilikController::class, 'index'])
        ->name('pemilik.index');
    Route::get('/pemilik/{id}', [App\Http\Controllers\Dokter\PemilikController::class, 'show'])
        ->name('pemilik.show');
});

// RESEPSIONIS ROUTES
Route::middleware('isResepsionis')->prefix('resepsionis')->name('resepsionis.')->group(function () {
   

       // Dashboard
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])->name('dashboard');
    
    // Pet Management
    Route::resource('pet', ResepsionisPetController::class)->names([
        'index' => 'pet.index',
        'create' => 'pet.create',
        'store' => 'pet.store',
        'show' => 'pet.show',
        'edit' => 'pet.edit',
        'update' => 'pet.update',
        'destroy' => 'pet.destroy',
    ]);
    
    // Pemilik Management
    Route::resource('pemilik', ResepsionisPemilikController::class)->names([
        'index' => 'pemilik.index',
        'create' => 'pemilik.create',
        'store' => 'pemilik.store',
        'show' => 'pemilik.show',
        'edit' => 'pemilik.edit',
        'update' => 'pemilik.update',
        'destroy' => 'pemilik.destroy',
    ]);

    // Appointment Management
    Route::resource('appointment', AppointmentController::class);
    
    // Quick Registration from Appointment
    Route::post('/appointment/quick-register', [AppointmentController::class, 'quickRegister'])
        ->name('appointment.quickRegister');
    

    
    // Appointment Management
    Route::resource('appointment', AppointmentController::class)->names([
        'index' => 'appointment.index',
        'create' => 'appointment.create',
        'store' => 'appointment.store',
        'show' => 'appointment.show',
        'edit' => 'appointment.edit',
        'update' => 'appointment.update',
        'destroy' => 'appointment.destroy',
    ]);
    
    // Rekam Medis (READ ONLY)
    Route::resource('rekammedis', ResepsionisRekamMedisController::class);
    Route::get('rekam-medis', [ResepsionisRekamMedisController::class, 'index'])
        ->name('rekam-medis.index');
    Route::get('rekam-medis/{id}', [ResepsionisRekamMedisController::class, 'show'])
        ->name('rekam-medis.show');
        
    // Transaksi Management
    Route::resource('transaksi', TransaksiController::class)->names([
        'index' => 'transaksi.index',
        'create' => 'transaksi.create',
        'store' => 'transaksi.store',
        'show' => 'transaksi.show',
        'edit' => 'transaksi.edit',
        'update' => 'transaksi.update',
        'destroy' => 'transaksi.destroy',
    ]);
});
