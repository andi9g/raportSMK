<?php

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


Route::get('/', function(){
    return view('layout.app');
});

// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['GerbangIdentitas'])->group(function () {
        //guru
        Route::resource('guru', 'guruC');
        Route::post('import/guru', 'guruC@import')->name("guru.import");
        Route::post('reset/guru/{iduser}', 'guruC@reset')->name("guru.reset");
        
        //mapel
        Route::resource('mapel', 'mapelC');
        Route::post('import/mapel', 'mapelC@import')->name("mapel.import");
        
        //siswa
        Route::resource('siswa', 'siswaC');
        Route::post('import/siswa', 'siswaC@import')->name("siswa.import");

        
        //raport
        Route::resource('raport', "raportC");
        Route::post('tambah/detailraport/{idraport}', "raportC@tambahdetailraport")->name("tambah.detailraport");
        //detail raport
        Route::get("detailraport/{idraport}/kelola", "raportC@detailraport")->name("detailraport.view");
        //penilaian
        Route::get("nilairaport/{iddetailraport}", "nilaiC@index");
        Route::post("elemen/{iddetailraport}", "nilaiC@elemen")->name("elemen.tambah");
        Route::delete("elemen/{idelemen}/hapus", "nilaiC@hapuselemen")->name("elemen.hapus");
        Route::put("elemen/{idelemen}/edit", "nilaiC@ubahelemen")->name("elemen.edit");
        Route::post("nilaisiswa/{iddetailraport}", "nilaiC@nilai")->name("nilai.siswa");


        //Menu_cetakraport
        Route::middleware(['GerbangWalikelas'])->group(function () {
            Route::get("cetakraport/{iddetailraport}", "cetakraportC@index")->name("raport.view");
            Route::get("cetak/{idsiswa}/cover", "cetakraportC@cover")->name("cetak.cover");
            Route::get("cetak/{idsiswa}/nilai/{iddetailraport}", "cetakraportC@nilai")->name("cetak.nilai");
            Route::get("cetak/{idsiswa}/identitas", "cetakraportC@identitas")->name("cetak.identitas");
        });
        
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
    });

    Route::resource('identitas', "identitasC");
});

