<?php

use App\Http\Controllers\Api\DeXuatController;
use App\Http\Controllers\BaiVietChiaSeController;
use App\Http\Controllers\DeXuatDiaDanhController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TinhThanhController;
use App\Http\Controllers\DiaDanhController;
use App\Http\Controllers\DiaDanhNhuCauController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LuuTruController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\NhuCauController;
use App\Http\Controllers\QuanAnController;
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


Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('tinhThanh', TinhThanhController::class);

    Route::resource('diaDanh', DiaDanhController::class);

    Route::resource('nhuCau', NhuCauController::class);

    Route::resource('diaDanhNhuCau', DiaDanhNhuCauController::class);

    Route::resource('baiViet', BaiVietChiaSeController::class);

    Route::resource('luuTru', LuuTruController::class);

    Route::resource('quanAn', QuanAnController::class);

    Route::resource('monAn', MonAnController::class);

    Route::resource('deXuat', DeXuatDiaDanhController::class);

    Route::get('/register', [LoginController::class, 'showFormregister'])->name('show-register');

    Route::post('/register', [LoginController::class, 'register'])->name('register');

    Route::get('/user', [LoginController::class, 'index'])->name("lstUser");

    Route::delete('/user/delete/{user}', [LoginController::class, 'delete'])->name("deleteUser");

    Route::patch('/user/update/{user}', [LoginController::class, 'moKhoa'])->name("moKhoaUser");

    Route::get('/user/show/{id}', [LoginController::class, 'show'])->name("show");


    // Tìm kiếm
    Route::get('/user/search', [LoginController::class, 'timKiem'])->name("timKiemUser");

    Route::get('/user/locUser', [LoginController::class, 'locUser'])->name("locUser");

    Route::get('/diadanh/search', [DiaDanhController::class, 'timKiemDiaDanh'])->name("timKiemDiaDanh");

    Route::get('/tinhthanh/search', [TinhThanhController::class, 'timKiemTinhThanh'])->name("timKiemTinhThanh");

    Route::get('/baiviet/search', [BaiVietChiaSeController::class, 'timKiemBV'])->name("timKiemBaiViet");

    Route::get('/quanan/search', [QuanAnController::class, 'timKiemQuanAn'])->name("timKiemQuanAn");

    Route::get('/monan/search', [MonAnController::class, 'timKiemMonAn'])->name("timKiemMonAn");

    Route::get('/luutru/search', [LuuTruController::class, 'timKiemLuuTru'])->name("timKiemLuuTru");

    Route::get('/nhucau/search', [NhuCauController::class, 'timKiemNhuCau'])->name("timKiemNhuCau");

    Route::get('/diadanhnhucau/search', [DiaDanhNhuCauController::class, 'timKiem']);


    Route::get('/dexuat/fill', [DeXuatDiaDanhController::class, 'fillbv'])->name("locDeXuat");

    //Thống kê chart
    Route::get('/dashboard/thongke', [HomeController::class, 'ThongKeChart']);
});

Route::get('/login', [LoginController::class, 'showFormlogin'])->name('show-login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/forgot', [LoginController::class, 'showFormForgot'])->name('showforgot');
Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot');

Route::get('/reset-password/{token}', [LoginController::class, 'showFormReset'])->name('showReset');
Route::post('/reset-password', [LoginController::class, 'reset'])->name('reset');
