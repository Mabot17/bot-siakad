<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/api-login/', [AuthenticationController::class, 'login'])->name('api-login');
Route::post('/api-register/', [AuthenticationController::class, 'register'])->name('api-register');

// Rute Wajib login dahulu
Route::middleware(['auth'])->group(function () {
    Route::get('/api-logout/', [AuthenticationController::class, 'logout'])->name('api-logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/pembimbing')->group(function () {
        // Route API Handle form pembimbing
        Route::get('/', [PembimbingController::class, 'index'])->name('pembimbing');
        Route::get('/tambah', [PembimbingController::class, 'formTambah'])->name('pembimbing.tambah');
        Route::get('/ubah/{mhs_id}', [PembimbingController::class, 'formUbah'])->name('pembimbing.ubah');

        // Route API CRUD
        Route::post('/api-tambah/', [PembimbingController::class, 'tambahDataPembimbing'])->name('pembimbing.api-tambah');
        Route::post('/api-ubah/', [PembimbingController::class, 'ubahDataPembimbing'])->name('pembimbing.api-ubah');
        Route::get('/api-hapus/{mhs_id}', [PembimbingController::class, 'hapusDataPembimbing'])->name('pembimbing.api-hapus');
        Route::get('/api-cetak-pembimbing-pdf', [PembimbingController::class, 'cetakDataPembimbingPdf'])->name('pembimbing.api-cetak-pdf');
        Route::get('/api-cetak-pembimbing-excel', [PembimbingController::class, 'cetakDataPembimbingExcel'])->name('pembimbing.api-cetak-excel');
    });

    Route::prefix('/prodi')->group(function () {
        // Route API Handle form prodi
        Route::get('/', [ProdiController::class, 'index'])->name('prodi');
        Route::get('/tambah', [ProdiController::class, 'formTambah'])->name('prodi.tambah');
        Route::get('/ubah/{mhs_id}', [ProdiController::class, 'formUbah'])->name('prodi.ubah');

        // Route API CRUD
        Route::post('/api-tambah/', [ProdiController::class, 'tambahDataProdi'])->name('prodi.api-tambah');
        Route::post('/api-ubah/', [ProdiController::class, 'ubahDataProdi'])->name('prodi.api-ubah');
        Route::get('/api-hapus/{mhs_id}', [ProdiController::class, 'hapusDataProdi'])->name('prodi.api-hapus');
        Route::get('/api-cetak-prodi-pdf', [ProdiController::class, 'cetakDataProdiPdf'])->name('prodi.api-cetak-pdf');
        Route::get('/api-cetak-prodi-excel', [ProdiController::class, 'cetakDataProdiExcel'])->name('prodi.api-cetak-excel');
    });

    Route::prefix('/mahasiswa')->group(function () {
        // Route API get data last NBI by prodi
        Route::get('/last-nbi/{prodiId}', [MahasiswaController::class, 'getLastNbiByProdiId']);

        // Route API Handle form mahasiswa
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa');
        Route::get('/tambah', [MahasiswaController::class, 'formTambah'])->name('mahasiswa.tambah');
        Route::get('/ubah/{mhs_id}', [MahasiswaController::class, 'formUbah'])->name('mahasiswa.ubah');

        // Route API CRUD
        Route::post('/api-tambah/', [MahasiswaController::class, 'tambahData'])->name('mahasiswa.api-tambah');
        Route::post('/api-ubah/', [MahasiswaController::class, 'ubahData'])->name('mahasiswa.api-ubah');
        Route::get('/api-hapus/{mhs_id}', [MahasiswaController::class, 'hapusData'])->name('mahasiswa.api-hapus');
        Route::get('/api-cetak-pdf', [MahasiswaController::class, 'cetakDataPdf'])->name('mahasiswa.api-cetak-pdf');
        Route::get('/api-cetak-excel', [MahasiswaController::class, 'cetakDataExcel'])->name('mahasiswa.api-cetak-excel');
    });
});
