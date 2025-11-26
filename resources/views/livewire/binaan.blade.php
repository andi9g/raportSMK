<div>
    




@if($showModal)
<div class='modal fade show d-block' role='dialog' style='background: rgba(0,0,0,0.5);'>
<div class='modal-dialog' role='document'>
    <div class='modal-content'>
    <div class='modal-header'>
        <h5 class='modal-title'>Ubah Data</h5>
        <button type='button' class='close' wire:click='closeModal'>
        <span>&times;</span>
        </button>
    </div>
    <div class='modal-body'>
        <div class='form-group'>
            <label for='fornisn' class='text-capitalize'>NISN</label>
            <input type='text' name='nisn' id='fornisn' class='form-control' disabled wire:model.defer="dataEditor.nisn" placeholder='masukan namaplaceholder'>
        </div>

        <div class='form-group'>
            <label for='fornama' class='text-capitalize'>Nama Siswa</label>
            <input type='text' name='nama' id='fornama' class='form-control' disabled wire:model.defer='dataEditor.nama' placeholder='masukan namaplaceholder'>
        </div>
        <div class="row">
            <div class="col">
                <div class='form-group'>
                    <label for='forizin' class='text-capitalize'>izin</label>
                    <input type='text' name='izin' id='forizin' class='form-control' wire:model.defer='dataEditor.izin' placeholder='masukan namaplaceholder'>
                </div>
            </div>
            <div class="col">
                <div class='form-group'>
                    <label for='forsakit' class='text-capitalize'>sakit</label>
                    <input type='text' name='sakit' id='forsakit' class='form-control' wire:model.defer='dataEditor.sakit' placeholder='masukan namaplaceholder'>
                </div>
            </div>
            <div class="col">
                <div class='form-group'>
                    <label for='foralfa' class='text-capitalize'>alfa</label>
                    <input type='text' name='alfa' id='foralfa' class='form-control' wire:model.defer='dataEditor.alfa' placeholder='masukan namaplaceholder'>
                </div>
            </div>
        </div>

        <div class='form-group'>
            <label for='forpembimbingdudi' class='text-capitalize'>Pembimbing Dudi</label>
            <input type='text' name='pembimbingdudi' id='forpembimbingdudi' class='form-control' wire:model.defer="dataEditor.pembimbingdudi" placeholder='masukan namaplaceholder'>
        </div>
        <div class='form-group'>
            <label for='forjabatan' class='text-capitalize'>Jabatan</label>
            <input type='text' name='jabatan' id='forjabatan' class='form-control' wire:model.defer="dataEditor.jabatan" placeholder='masukan namaplaceholder'>
        </div>

        
        
        <div class="form-group">
            <label for="catatan">Catatan
                <div class="spinner-border mt-3"  wire:loading wire:target="gmini({{ $dataEditor['idpesertapkl'] }})">
            </div>
            </label>
            <textarea class="form-control  @if ($warna==true)
                bg-success text-white
            @endif" name="catatan" id="catatan" wire:model.defer='dataEditor.catatanpkl' rows="3"></textarea>
        </div>
        <button class="btn btn-success" wire:click="gmini({{ $dataEditor['idpesertapkl'] }})"  wire:loading.attr="disabled">Ubah Catatan dengan Bantuan-AI</button>
        
        

    </div>
    <div class='modal-footer'>
        <button class='btn btn-secondary' wire:click='closeModal'>Close</button>
        <button class='btn btn-primary' wire:click='ubah'>ubah</button>
    </div>
    </div>
</div>
</div>
@endif

<div class="row">
  <div class="col-md"><a href="{{ route('pesertapkl.index', [$idpkl]) }}" class="btn btn-primary">
    <i class="fa fa-refresh"></i>
    Refresh Data</a></div>
  <div class="col-md"></div>
  <div class="col-md text-right">
      <div class='search-container'>
          <input type='text' class='form-control search-input' wire:model.debounce.500ms="search" placeholder='Search...'>
          <i class='fas fa-search search-icon'></i>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mt-3">
      <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped">
              <thead class="thead-secondary">
                  <tr>
                    <th width="5px">No</th>
                    <th>NISN</th>
                    <th>Nama Peserta Binaan</th>
                    <th>Pembimbing</th>
                    <th>Tempat PKL</th>
                    <th>Aksi</th>
                    <th>Cetak</th>
                  </tr>
              </thead>

              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->siswa->nama }}</td>
                    <td>{{ $item->pembimbingdudi }}</td>
                    <td>{{ $item->tempatpkl }}</td>
                    <td>
                        <button class='btn btn-primary' wire:click='openModal({{ $item->idpesertapkl }})'><i class="fa fa-eye"></i></button>
                    </td>
                    <td>
                        <a href="{{ route('pesertapkl.cetak', [$item->idpesertapkl]) }}" target="_blank" class="btn btn-secondary btn-block">Cetak Rapor</a>
                    </td>
                  </tr>
                    
                @endforeach
              </tbody>
          </table>

          {{ $data->links("vendor.livewire.bootstrap") }}
      </div>
  </div>
</div>
</div>
