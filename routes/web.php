<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\DUSeragamController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\LaporanController;
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

});

Route::get('/test', function () {
    // $jurusan = \App\Models\Jurusan::where('jurusan', 'akuntansi-dan-keuangan-lembaga')->latest()->limit(1)->get()->first()->toArray();
    // return \App\Metadata\Pendaftaran::getKode();
    // return view('pages.hasil-print');
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

    Route::controller(DUSeragamController::class)->group(function () {
        Route::get('/duseragam', 'index');
        Route::post('/duseragam', 'store');
    });
    
});


Route::prefix('/admin')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/peserta', 'peserta');
    });

    Route::controller(FormulirController::class)->group(function () {
        Route::get('/tambah-peserta', 'tambah');
        Route::post('/tambah-peserta', 'store');
    });

    Route::prefix('/verifikasi-pendaftaran')->controller(VerifikasiController::class)->group(function () {
        Route::get('/', 'pendaftaranIndex');
        Route::post('/biaya/{identitas:id}', 'pendaftaranBiaya');
        Route::post('/pembayaran/{identitas:id}', 'pendaftaranPembayaran');
        Route::post('/verifikasi/{identitas:id}', 'pendaftaranVerifikasi');
    });

    Route::prefix('/verifikasi-duseragam')->controller(VerifikasiController::class)->group(function () {
        Route::get('/', 'duSeragamIndex');
        Route::post('/biaya-duseragam/{identitas:id}', 'duSeragamBiaya');

        Route::post('/pembayaran-daftar-ulang/{identitas:id}', 'daftarUlangPembayaran');
        Route::post('/pembayaran-seragam/{identitas:id}', 'seragamPembayaran');
        
        Route::post('/verifikasi/{identitas:id}', 'duSeragamVerifikasi');
    });

    Route::get('/print/{identitas:id}', [PrintController::class, 'pendaftaran']);

    Route::controller(FormulirController::class)->group(function () {
        Route::get('/edit/{identitas:id}', 'edit');
        Route::post('/edit/{identitas:id}', 'update');
    });

    Route::controller(SponsorshipController::class)->group(function () {
        Route::get('/sponsorship', 'index');
        Route::post('/sponsorship', 'store');
        Route::get('/sponsorship/edit/{sponsorship:id}', 'edit');
        Route::post('/sponsorship/edit/{sponsorship:id}', 'update');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::get('/laporan-pendaftaran', 'indexPendaftaran')->name('laporan.pendaftaran');
        Route::post('/filter-pendaftaran', 'filterPendaftaran');
    });
    
});