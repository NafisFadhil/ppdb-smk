<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\VerifikasiController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('pages.index', [
        'page' => ['title' => 'PPDB SMK Muhammadiyah Bligo'],
    ]);
});

Route::controller(FormulirController::class)->group(function () {

    Route::get('/formulir', 'index');
    Route::post('/formulir', 'store');
    // Route::get('/pendaftaran/print', 'print');
    // Route::get('/pendaftaran/print/cetak', 'cetak');

});

Route::get('/test', function () {
    // $jurusan = \App\Models\Jurusan::where('jurusan', 'akuntansi-dan-keuangan-lembaga')->latest()->limit(1)->get()->first()->toArray();
    // return \App\Metadata\Pendaftaran::getKode();
    return view('pages.hasil-print');
});

Route::controller(LoginController::class)->group(function () {

    Route::get('/login', 'index');
    Route::post('/login', 'login');
    Route::get('/login/admin', 'admindex');
    Route::post('/login/admin', 'admlogin');
    Route::get('/logout', 'logout');
    
});

Route::prefix('/siswa')->controller(SiswaController::class)->group(function () {

    Route::get('/', 'index');
    Route::get('/profil', 'profil');
    Route::post('/profil', 'update');
    
});

Route::prefix('/admin')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        
        Route::get('/', 'index');
        Route::get('/peserta', 'peserta');

    });

    Route::prefix('/verifikasi')->controller(VerifikasiController::class)->group(function () {
        Route::get('/pendaftaran', 'pendaftaranIndex');
        Route::post('/pendaftaran/pembayaran/{pendaftarans:id}', 'pendaftaranPembayaran');
        Route::post('/pendaftaran/verifikasi/{pendaftarans:id}', 'pendaftaranVerifikasi');
        Route::get('/daftar-ulang', 'daftarUlangIndex');
        Route::post('/daftar-ulang/pembayaran/{pendaftarans:id}', 'daftarUlangPembayaran');
        Route::post('/daftar-ulang/verifikasi/{pendaftarans:id}', 'daftarUlangVerifikasi');
    });

    Route::get('/print/{pendaftarans:id}', [PrintController::class, 'pendaftaran']);

    Route::controller(FormulirController::class)->group(function () {
        Route::get('/edit/{pendaftarans:id}', 'edit');
        Route::post('/edit/{pendaftarans:id}', 'update');
    });

    Route::controller(SponsorshipController::class)->group(function () {
        Route::get('/sponsorship', 'index');
        Route::post('/sponsorship', 'store');
    });
    
});