<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('login');
})->name('login');
Route::get('registrasi', function () {
    return view('registrasi');
})->name('registrasi');
Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('halamanprofil', function () {
    return view('halamanprofil');
})->name('halamanprofil');
Route::get('editprofil', function () {
    return view('editprofil');
})->name('editprofil');
Route::get('halamanpencatatan', function () {
    return view('halamanpencatatan');
})->name('halamanpencatatan');
Route::get('halamanlaporan', function () {
    return view('halamanlaporan');
})->name('halamanlaporan');
Route::get('halamanpenjualan', function () {
    return view('halamanpenjualan');
})->name('halamanpenjualan');
Route::get('laporanpenjualan', function () {
    return view('laporanpenjualan');
})->name('laporanpenjualan');