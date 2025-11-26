<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\pesertapklM;
use App\Models\kehadiranpklM;
use Livewire\WithFileUploads;
use App\Models\siswaM;
use App\Models\catatanpklM;
use GeminiAPI\Client;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;

use Auth;


class Binaan extends Component
{
    use WithPagination;
    
    //bagian livewire
    public $search = '';
    
    public function updateSearch()
    {
        $this->resetPage();
    }
    

    public function mount($idpkl)
    {
        $this->idpkl = $idpkl;
    }

    public function render()
    {
        $data = pesertapklM::when($this->search, function($query, $key) {
            $query->whereHas('siswa', function ($query2) use ($key) {
                $query2->where(function($query3) use ($key) {
                    $query3->where('nisn', 'like', $key.'%')
                    ->orWhere('nama', 'like', '%'.$key.'%');
                });
            });
            
        })->where("idpkl", $this->idpkl)
        ->where("iduser", Auth::user()->iduser)
        ->paginate(15);

        $data->appends(request()->only('keyword'));

        return view('livewire.binaan', [
            'data' => $data,
        ]);
    }

    public $showModal = false;
    public $dataEditor = [];
    
    public function openModal($idpesertapkl)
    {
        $this->showModal = true;
        $pesertapkl = pesertapklM::where("idpesertapkl", $idpesertapkl)->first();
        $catatanpkl = catatanpklM::where("idpesertapkl", $idpesertapkl)->first();
        $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $idpesertapkl)->first();

        
        $this->dataEditor = [
            "idpesertapkl" => $idpesertapkl ?? 'asd',
            "nisn" => $pesertapkl->nisn ?? 'asd',
            "nama" => $pesertapkl->siswa->nama ?? '',
            "pembimbingdudi" => $pesertapkl->pembimbingdudi ?? '',
            "jabatan" => $pesertapkl->jabatan ?? '',
            "sakit" => $kehadiranpkl->sakit ?? 0,
            "izin" => $kehadiranpkl->izin ?? 0,
            "alfa" => $kehadiranpkl->alfa ?? 0,
            "catatanpkl" => $catatanpkl->catatanpkl ?? '',
        ];

        
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->warna = false;
    }

    public $warna = false;

    public function gmini($idpesertapkl)
    {
        
        $catatanpkl = catatanpklM::where("idpesertapkl", $idpesertapkl)->first();

        $client = new Client('AIzaSyCmEDeBIuOo2wjMCkjpMHg7p_xkyuEPHjU');
        $response = $client->generativeModel("gemini-2.5-flash")
        ->generateContent(
            new TextPart("buatkan saya deskripsi ringkas sesuai dari pesan dibawah, namun jadikan deskripsi < dari 150 karakter"),
            new TextPart("tanpa perlu menuliskan jumlah karakternya, hanya deskripsinya saja: "),
            new TextPart("dan terdapat kata-kata motivasi di dalamnya."),
            new TextPart($catatanpkl->catatanpkl),
        );

        $this->dataEditor['catatanpkl'] = $response->text();
        $this->warna = true;
    }


    
    public function ubah()
    {
        $idpesertapkl = $this->dataEditor['idpesertapkl'];
        $pesertapkl = pesertapklM::where("idpesertapkl", $idpesertapkl)->first();
        $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $idpesertapkl)->first();
        $catatanpkl = catatanpklM::where("idpesertapkl", $idpesertapkl)->first();

        $pesertapkl->pembimbingdudi = $this->dataEditor['pembimbingdudi'] ?? $pesertapkl->pembimbingdudi;
        $pesertapkl->jabatan = $this->dataEditor['jabatan'] ?? $pesertapkl->jabatan;
        $pesertapkl->save();

        $kehadiranpkl->sakit = (int) ($this->dataEditor['sakit'] ?? $kehadiranpkl->sakit ?? 0);
        $kehadiranpkl->izin = (int) ($this->dataEditor['izin'] ?? $kehadiranpkl->izin ?? 0);
        $kehadiranpkl->alfa = (int) ($this->dataEditor['alfa'] ?? $kehadiranpkl->alfa ?? 0);
        $kehadiranpkl->save();

        $catatanpkl->catatanpkl = $this->dataEditor['catatanpkl'] ?? $catatanpkl->catatanpkl;
        $catatanpkl->save();

        if ($pesertapkl && $kehadiranpkl && $catatanpkl) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil!',
                'text'  => 'Data berhasil diubah.',
                'icon'  => 'success',
            ]);
        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal!',
                'text'  => 'Data gagal diubah.',
                'icon'  => 'error',
            ]);
        }
        $this->dataEditor = [];
        $this->warna = false;
        $this->closeModal();
    }
}
