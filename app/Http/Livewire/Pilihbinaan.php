<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\pesertapklM;
use App\Models\kehadiranpklM;
use Livewire\WithFileUploads;
use App\Models\siswaM;
use App\Models\catatanpklM;
use Auth;
use Excel;

class Pilihbinaan extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $guru = [];

    public $file;
    use WithFileUploads;
    
    public $idpkl, $iduser;
    public $idpembimbingsekolah;

    //modal
    public $showModal = false; // kontrol tampil/tidak modal
    public $message = '';
     //modal edit
    public $showModal2 = false;
    public $dataEdit = [];
    public $selectedId;



    public function mount($idpkl)
    {
        $this->idpkl = $idpkl;
        $this->iduser = Auth::user()->iduser;
        $this->guru = Auth::user()->select("iduser", "name")->get();
        $this->idpembimbingsekolah = $this->iduser;
    }

    public function updateSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {   
        

        $pesertapkl = pesertapklM::where("idpkl", $this->idpkl)
        ->where("iduser", null)->select("nisn")->get()->toArray();

        $data = siswaM::when($this->search, function($query, $key) {
            $query->where(function($query2) use ($key) {
                $query2->where('nisn', 'like', "$key%")
                ->orWhere('nama', 'like', '%'.$key.'%');
            });
        })
        ->whereHas("kelas", function($query) {
            $query->where("namakelas", "XII");
        })
        ->whereIn("nisn", $pesertapkl)
        ->paginate(15);

        $data->appends(['search' => $this->search, "limit"]);

        return view('livewire.pilihbinaan', [
            'data' => $data,
        ]);
    }


    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $this->file;

        Excel::import(new \App\Imports\pesertaPkl($this->idpkl), $this->file);

        $this->showModal = false;
        $this->resetPage();
    }




    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->dataEdit = [];
        $this->selectedId = '';
        $this->showModal = false;
        $this->showModal2 = false;
    }



    public function ambil()
    {
        $pesertapkl = pesertapklM::where("idpesertapkl", $this->selectedId)->first()->update([
            "iduser" => $this->idpembimbingsekolah,
        ]);

        $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $this->selectedId)->first()->update([
            "sakit" => $this->dataEdit['sakit'],
            "izin" => $this->dataEdit['izin'],
            "alfa" => $this->dataEdit['alfa'],
        ]);
        $kehadiranpkl = catatanpklM::where("idpesertapkl", $this->selectedId)->first()->update([
            "catatanpkl" => $this->dataEdit['catatanpkl'],
        ]);

        if($pesertapkl && $kehadiranpkl){
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil!',
                'text'  => 'Data berhasil dipindahkan pada menu Peserta Binaan',
                'icon'  => 'success',
            ]);
        } else {
            $this->message = "Data Gagal Diambil";

        }
        
        $this->showModal2 = false;
        $this->closeModal();
    }

   
    public function openmodaledit($idsiswa)
    {
        $this->showModal2 = true;

        $nisn = siswaM::where("idsiswa", $idsiswa)->first()->nisn;
        
        $nisn = sprintf("%010s", (string)$nisn);
        $pesertapkl = pesertapklM::where("nisn", $nisn)->first();

        $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $pesertapkl->idpesertapkl)->first();
        $catatanpkl = catatanpklM::where("idpesertapkl", $pesertapkl->idpesertapkl)->first();

        $this->selectedId = $pesertapkl->idpesertapkl;

        $this->dataEdit = [
            "pembimbingdudi" => $pesertapkl->pembimbingdudi ?? '',
            "sakit" => $kehadiranpkl->sakit ?? 0,
            "izin" => $kehadiranpkl->izin ?? 0,
            "alfa" => $kehadiranpkl->alfa ?? 0,
            "catatanpkl" => $catatanpkl->catatanpkl ?? '',
        ];

        // $pesertapkl = pesertapklM::where("idpesertapkl", $idpesertapkl)->first();
        // $iduser = Auth::user()->iduser;

        // $pesertapkl->iduser = $iduser;
        // $pesertapkl->save();

        $this->resetPage();
    }
    
}
