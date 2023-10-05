<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;

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

Route::get('/',[JurusanController::class, 'index']);

Route::resource('jurusans', JurusanController::class);
Route::get('jurusan-dosen/{jurusan_id}', [JurusanController::class,
            'jurusanDosen'])->name('jurusan-dosen');
Route::get('jurusan-mahasiswa/{jurusan_id}', [JurusanController::class,
            'jurusanMahasiswa'])->name('jurusan-mahasiswa');
Route::resource('dosens', DosenController::class);
Route::resource('mahasiswas', MahasiswaController::class);
Route::resource('matakuliahs', MatakuliahController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
