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
    return redirect('login');
});

// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    //ubah passsword
    Route::get('password', "identitasC@password");
    Route::post('password', "identitasC@ubahpassword")->name('password.ubah');

    //walikelas
    Route::get("walikelas", "walikelasC@index")->middleware("GerbangWalikelas");
    Route::post("walikelas/{ididentitas}", "walikelasC@update")->middleware("GerbangWalikelas")->name("walikelas.update");

Route::middleware(['GerbangIdentitas', 'GerbangCekWaliKelas'])->group(function () {
    Route::get('/home', "homeC@index")->name('home');


        Route::middleware(['GerbangAdmin'])->group(function () {
            //guru
            Route::resource('guru', 'guruC');
            Route::post('import/guru', 'guruC@import')->name("guru.import");
            Route::post('reset/guru/{iduser}', 'guruC@reset')->name("guru.reset");
            

            //mapel
            Route::resource('mapel', 'mapelC');
            Route::post('import/mapel', 'mapelC@import')->name("mapel.import");

            Route::post('import/siswa', 'siswaC@import')->name("siswa.import");

            //raport
            Route::post("open/raport/{idraport}", "raportC@open")->name("open.raport");
            Route::post('raport', "raportC@store")->name("raport.store");
            Route::delete('raport/delete/{idraport}', "raportC@store")->name("raport.destroy");
        });
        Route::get('raport', "raportC@index");
        //siswa
        Route::resource('siswa', 'siswaC');
        
        

        Route::post('tambah/detailraport/{idraport}', "raportC@tambahdetailraport")->name("tambah.detailraport");
        //detail raport
        Route::get("detailraport/{idraport}/kelola", "raportC@detailraport")->name("detailraport.view");
        Route::get("cetak/detailraport/{iddetailraport}", "raportC@cetak")->name("cetak.detailraport");
        //penilaian
        Route::get("nilairaport/{iddetailraport}", "nilaiC@index");
        Route::post("elemen/{iddetailraport}", "nilaiC@elemen")->name("elemen.tambah");
        Route::delete("elemen/{idelemen}/hapus", "nilaiC@hapuselemen")->name("elemen.hapus");
        Route::put("elemen/{idelemen}/edit", "nilaiC@ubahelemen")->name("elemen.edit");
        Route::post("nilaisiswa/{iddetailraport}", "nilaiC@nilai")->name("nilai.siswa");
        Route::post("catatan/{iddetailraport}", "nilaiC@catatan")->name("tambah.catatan");
        Route::post("ujian/{idraport}", "nilaiC@ujian")->name("nilai.ujian");
        


        //Menu_cetakraport
        Route::middleware(['GerbangWalikelas'])->group(function () {
            Route::get("cetakraport/{iddetailraport}", "cetakraportC@index")->name("raport.view");
            Route::get("cetak/{idsiswa}/cover", "cetakraportC@cover")->name("cetak.cover");
            Route::get("cetak/{idsiswa}/nilai/{iddetailraport}", "cetakraportC@nilai")->name("cetak.nilai");
            Route::get("cetak/{idsiswa}/identitas", "cetakraportC@identitas")->name("cetak.identitas");
            Route::post("kehadiran/{idraport}", "nilaiC@kehadiran")->name("tambah.kehadiran");
        });
        
        
        
    });

    Route::resource('identitas', "identitasC");
    
});

