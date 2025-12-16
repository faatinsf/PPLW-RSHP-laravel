<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MineController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RasHewanController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JenisHewanController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\KategoriKlinisController;
use App\Http\Controllers\Perawat\PasienController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\Perawat\ProfileController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;
use App\Http\Controllers\DashboardPerawatController;
use App\Http\Controllers\DetailRekamMedisController;
use App\Http\Controllers\KodeTindakanTerapiController;

use App\Http\Controllers\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\TransaksiController;
use App\Http\Controllers\Dokter\PetController as DokterPet;
use App\Http\Controllers\Dokter\PemilikController as DokterPemilik;
use App\Http\Controllers\Dokter\ProfileController as DokterProfile;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedis;
use App\Http\Controllers\Resepsionis\PetController as ResepsionisPetController;
use App\Http\Controllers\Perawat\RekamMedisController as PerawatRekamMedisController;
use App\Http\Controllers\Resepsionis\PemilikController as ResepsionisPemilikController;
use App\Http\Controllers\Resepsionis\RekamMedisController as ResepsionisRekamMedisController;
use App\Http\Controllers\Pemilik\MedicalRecordController;
use App\Http\Controllers\Pemilik\ProfilePemilikController;
use App\Http\Controllers\Pemilik\PetWidgetController;
use App\Http\Controllers\Pemilik\AppointmentWidgetController;
use App\Http\Controllers\Pemilik\PetController as PetPemilik;


 


// Halaman umum
Route::get('/', [MineController::class, 'home'])->name('home');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/struktur', [MineController::class, 'struktur'])->name('struktur');
Route::get('/layanan', [MineController::class, 'layanan'])->name('layanan');
Route::get('/visi', [MineController::class, 'visi'])->name('visi');

Route::get('/CekKoneksi', [MineController::class, 'CekKoneksi'])->name('CekKoneksi');


// Route::get('/Auth/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
// Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Auth::routes();
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');





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
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class);

        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('user/{id}/edit-password', [UserController::class, 'editPassword'])->name('user.edit-password');
        Route::put('user/{id}/update-password', [UserController::class, 'updatePassword'])->name('update-password');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        
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
    ->prefix('dokter')->name('dokter.')->group(function () {

Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dashboard');
    
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



    // Profile Routes
    Route::get('/profile', [DokterProfile::class, 'index'])->name('profile');
    Route::get('/profile/edit', [DokterProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [DokterProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [DokterProfile::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/photo', [DokterProfile::class, 'deletePhoto'])->name('profile.photo.delete');
    
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

    // PEMILIK ROUTES
Route::middleware('isPemilik')->prefix('pemilik')->name('pemilik.')->group(function () {
     
     Route::get('/dashboard', [DashboardPemilikController::class, 'index'])->name('dashboard');
     Route::get('/profile', [ProfilePemilikController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfilePemilikController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfilePemilikController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/photo', [ProfilePemilikController::class, 'deletePhoto'])->name('profile.photo.delete');
    
    // Pet
    Route::get('/pet', [PetPemilik::class, 'index'])->name('pet');
    Route::get('/pet/create', [PetPemilik::class, 'create'])->name('pet.create');
    
   // Appointment Routes
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.show');
    Route::put('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    
    // Medical Record
    Route::get('/medical-record', [MedicalRecordController::class, 'index'])->name('medical-record');
    Route::get('/medical-record/{id}', [MedicalRecordController::class, 'show'])->name('medical-record.show');
    
    // Widget APIs (for AJAX requests)
    Route::prefix('api')->name('api.')->group(function() {
        Route::get('/pets-widget', [PetWidgetController::class, 'getPetsWidget'])->name('pets.widget');
        Route::get('/appointments-upcoming', [AppointmentWidgetController::class, 'getUpcomingAppointments'])->name('appointments.upcoming');
        Route::get('/appointments-stats', [AppointmentWidgetController::class, 'getAppointmentStats'])->name('appointments.stats');
    });
    
});




// PERAWAT ROUTES
Route::middleware('isPerawat')->prefix('perawat')->name('perawat.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])->name('dashboard');
    
    // Pasien (View Only)
    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', [PasienController::class, 'index'])->name('index');
        Route::get('/{id}', [PasienController::class, 'show'])->name('show');
    });
    
    // Rekam Medis (CRUD)
    Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
        Route::get('/', [PerawatRekamMedisController::class, 'index'])->name('index');
        Route::get('/create', [PerawatRekamMedisController::class, 'create'])->name('create');
        Route::post('/', [PerawatRekamMedisController::class, 'store'])->name('store');
        Route::get('/{id}', [PerawatRekamMedisController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PerawatRekamMedisController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PerawatRekamMedisController::class, 'update'])->name('update');
        Route::delete('/{id}', [PerawatRekamMedisController::class, 'destroy'])->name('destroy');
    });
    
    // Profil
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
});
