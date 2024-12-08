<?php

use Illuminate\Support\Facades\Auth;
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




// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');

Route::get('/', function(){
    return redirect('login');
});

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

        //kenaikan kelas
        Route::resource("kenaikankelas", "kenaikankelasC");

        //walikelas
        Route::resource('walikelasAdmin', "walikelasAC");

        //pengaturan p5
        Route::resource('pengaturanp5', "pengaturanp5C");
        Route::resource('kordinator', "kordinatorp5C");


        //pengaturan Extrakulikuler
        Route::resource("pengaturanextrakulikuler", "pengaturanexC");
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
        Route::delete('raport/delete/{idraport}', "raportC@destroy")->name("raport.destroy");
        Route::put('raport/update/{idraport}', "raportC@update")->name("raport.update");

        Route::post("p5/tambah", "raportp5C@tambah")->name("tambah.raportp5");
        Route::get("p5/temap5/{idraportp5}", "raportp5C@temap5")->name("open.temap5");
        //tema
        Route::post("p5/temap5/{idraportp5}", "raportp5C@tambahtemap5")->name("tambah.temap5");
        Route::put("p5/temap5/{idtemap5}/ubah", "raportp5C@ubahtemap5")->name("ubah.temap5");
        Route::delete("p5/temap5/{idraportp5}/hapus", "raportp5C@hapustemap5")->name("hapus.temap5");

        //dimensi
        Route::post("p5/dimensip5", "raportp5C@tambahdimensip5")->name("tambah.dimensip5");
        Route::put("p5/dimensip5/{iddimensip5}/ubah", "raportp5C@ubahdimensip5")->name("ubah.dimensip5");
        Route::delete("p5/dimensip5/{iddimensip5}/hapus", "raportp5C@hapusdimensip5")->name("hapus.dimensip5");

        //subdimensi
        Route::post("p5/subdimensip5", "raportp5C@tambahsubdimensip5")->name("tambah.subdimensip5");
        Route::put("p5/subdimensip5/{idsubdimensip5}/ubah", "raportp5C@ubahsubdimensip5")->name("ubah.subdimensip5");
        Route::delete("p5/subdimensip5/{idsubdimensip5}/hapus", "raportp5C@hapussubdimensip5")->name("hapus.subdimensip5");


    });

    Route::middleware(['GerbangKordinator'])->group(function () {
        //raport p5
        Route::get("raportp5", "raportp5C@index");
        Route::get("raportp5/{idraportp5}", "raportp5C@siswa")->name("penilaian.raportp5");
        Route::post("raportp5/{idraportp5}/project", "raportp5C@tambahprojectp5")->name("tambah.project.p5");
        Route::put("raportp5/{idraportp5}/ubahproject", "raportp5C@ubahprojectp5")->name("ubah.project.p5");

        //NILAI
        Route::get("raportp5/{idraportp5}/nilai/{nisn}/{pages}", "raportp5C@formnilai")->name("nilai.raport.p5");
        Route::post("raportp5/{nisn}/nilai/{idketeranganp5}", "raportp5C@nilai")->name("kirim.nilai.p5");


        //cetak
        Route::get("raportp5/{idraportp5}/cetak/{nisn}", "raportp5C@cetak")->name("cetak.raport.p5");
    });

    //rapor
    Route::get('raport', "raportC@index");
    Route::post('sinkron/{idraport}/raport', "raportC@sinkron")->name("sinkron.raport");

    //siswa
    Route::resource('siswa', 'siswaC');


    //extrakulikuler
    Route::get("extrakulikuler/{idraport}", "extrakulikulerC@index")->name("extrakulikuler.open");
    Route::get("extrakulikuler/{idraport}/kelola/{idpembinaex}", "extrakulikulerC@kelola")->name("extrakulikuler.kelola");

    Route::post("kirim/{idsiswa}/extrakulikuler", "extrakulikulerC@kirim")->name("extrakulikuler.kirim.nilai");
    Route::delete("extrakulikulerHapus/{idpenilaianex}", "extrakulikulerC@destroy")->name("hapus.extrakulikuler");

    Route::post('tambah/detailraport/{idraport}', "raportC@tambahdetailraport")->name("tambah.detailraport");
    //detail raport
    Route::get("detailraport/{idraport}/kelola", "raportC@detailraport")->name("detailraport.view");
    Route::post("detailraport/{iddetailraport}/hapus", "raportC@hapus")->name("hapus.detailraport");
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
        //kelola siswa
        Route::resource('kelolasiswa', "kelolasiswaC");

        Route::get("cetakraport/{iddetailraport}", "cetakraportC@index")->name("raport.view");
        Route::get("cetak/{idsiswa}/cover", "cetakraportC@cover")->name("cetak.cover");
        Route::get("cetak/{idsiswa}/nilai/{iddetailraport}", "cetakraportC@nilai")->name("cetak.nilai");
        Route::get("cetak/{idsiswa}/identitas", "cetakraportC@identitas")->name("cetak.identitas");
        Route::post("kehadiran/{idraport}", "nilaiC@kehadiran")->name("tambah.kehadiran");


        Route::get("ranking/{idraport}/cetak", "raportC@ranking")->name("ranking.raport");
        Route::get("leger/{idraport}/cetak", "raportC@leger")->name("leger.raport");

    });



    });

    Route::resource('identitas', "identitasC");

});

