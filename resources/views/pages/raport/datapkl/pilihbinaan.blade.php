
<div class="row">
  <div class="col-md"></div>
  <div class="col-md"></div>
  <div class="col-md text-right">
    <form action="{{ url()->current() }}">
        <div class='search-container'>
            <input type='text' class='form-control search-input' name="keyword2" onchange="submit()" placeholder='Search...' value="{{ $keyword2 }}">
            <i class='fas fa-search search-icon'></i>
        </div>
    </form>
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
                @foreach ($siswa as $item)
                  <tr>
                    <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pembimbing }}</td>
                    <td>{{ $item->tempatpkl }}</td>
                  </tr>
                    
                @endforeach
              </tbody>
          </table>
      </div>
  </div>
</div>