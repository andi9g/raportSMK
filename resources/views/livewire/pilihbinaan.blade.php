<div>
  @if($showModal)
  <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal Livewire</h5>
          <button type="button" class="close" wire:click="closeModal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='form-group'>
              <label for='forfile' class='text-capitalize'>Masukan File (XLSX)</label>
              <input type='file' id='forfile' type="file" class="form-control" wire:model="file" placeholder='masukan namaplaceholder'>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" wire:click="closeModal">Close</button>
          <button class="btn btn-primary" wire:click="import">Import</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if($showModal2)
  <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">AMBIL PESERTA</h5>
          <button type="button" class="close" wire:click="closeModal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class='form-group'>
              <label for='foriduser' class='text-capitalize'>Nama Pembimbing Sekolah</label>
              <select id='foriduser' class='form-control' wire:model="idpembimbingsekolah">
                  @foreach ($guru as $item)
                      <option value="{{ $item->iduser }}" @if($item->iduser == $iduser) selected @endif>{{ $item->name }}</option>
                  @endforeach
              </select>
          </div>
          <div class='form-group'>
              <label for='forpembimbingdudi' class='text-capitalize'>Nama Pembimbing Dudi</label>
              <input type='text' name='pembimbingdudi' id='forpembimbingdudi' class='form-control' wire:model.defer="dataEdit.pembimbingdudi" placeholder='masukan namaplaceholder'>
          </div>
          <div class='form-group'>
              <label for='forsakit' class='text-capitalize'>Sakit</label>
              <input type='text' name='sakit' id='forsakit' class='form-control' wire:model.defer="dataEdit.sakit" placeholder='masukan namaplaceholder'>
          </div>
          <div class='form-group'>
              <label for='forizin' class='text-capitalize'>Izin</label>
              <input type='text' name='izin' id='forizin' class='form-control' wire:model.defer="dataEdit.izin" placeholder='masukan namaplaceholder'>
          </div>
          <div class='form-group'>
              <label for='foralfa' class='text-capitalize'>Alfa</label>
              <input type='text' name='alfa' id='foralfa' class='form-control' wire:model.defer="dataEdit.alfa" placeholder='masukan namaplaceholder'>
          </div>
          <div class="form-group">
            <label for="catatanpkl">Catatan</label>
            <textarea class="form-control" name="catatanpkl" id="catatanpkl" rows="3" wire:model.defer="dataEdit.catatanpkl"></textarea>
          </div>

          <p>Silahkan cek kebenaran data dan kesesuaian pembimbing</p>
        
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" wire:click="closeModal">Close</button>
          <button class="btn btn-primary" wire:click="ambil">Ambil Data</button>
        </div>
      </div>
    </div>
  </div>
  @endif


<div class="row">
  <div class="col-md pt-2">
   @if (Auth::user()->name="admin")
   <button class="btn btn-warning btn-lg" wire:click="openModal">IMPORT PESERTA</button>
   @endif  
  </div>
  <div class="col-md"></div>
  <div class="col-md text-right pt-2">
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
                    <th width="5px">NISN</th>
                    <th>Nama Siswa</th>
                    <th>Rombel</th>
                    <th>Tempat Magang</th>
                    <th>Aksi</th>
                  </tr>
              </thead>

              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>
                    <td>{{ $item->pesertapkl->tempatpkl }}</td>
                    <td><button class="btn btn-primary btn-block" wire:click="openmodaledit({{ $item->idsiswa }})">PILIH PESERTA</button></td>
                  </tr>
                    
                @endforeach
              </tbody>
          </table>
      </div>

      {{ $data->links("vendor.livewire.bootstrap") }}
  </div>
</div>
</div>
