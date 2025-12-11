@extends('layouts.master')

@section('warnapengaturan', 'active')
@section('warnapengaturanp5', 'active')

@section("judul")
    PENGATURAN RAPOR P5
@endsection

@section('content')
<div id="tambahketerangan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Keterangan P5</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengaturanp5.store', []) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-capitalize" for="inisial">Inisial Keterangan</label>
                        <input id="inisial" placeholder="MB" class="form-control" type="text" name="inisialp5">
                    </div>

                    <div class="form-group">
                        <label class="text-capitalize" for="keterangan">keterangan P5</label>
                        <input id="keterangan" placeholder="Mulai Berkembang" class="form-control" type="text" name="keteranganp5">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3" placeholder="Peserta didik mulai mengembangkan kemampuan namun masih belum ajek"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="text-capitalize" for="index">Urutan</label>
                        <input id="index" class="form-control" type="number" value="{{ $index }}"  name="index">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah Data Keterangan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="tambahkordinatorp5" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Kordinator P5</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kordinator.store', []) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="identitas">Nama Kordinator</label>
                        <select id="identitas" required class="form-control select2identitas" name="iduser">
                            <option>Pilih Kordinator</option>
                            @foreach ($identitas as $user)
                                <option value="{{ $user->iduser }}">{{ $user->user->name ?? 'none' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" required class="form-control" name="idkelas">
                            <option>Pilih Kelas</option>
                            @foreach ($kelas as $kel)
                                <option value="{{ $kel->idkelas }}">{{ $kel->namakelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jurusan">jurusan</label>
                        <select id="jurusan" required class="form-control" name="idjurusan">
                            <option>Pilih jurusan</option>
                            @foreach ($jurusan as $jur)
                                <option value="{{ $jur->idjurusan }}">{{ $jur->jurusan." - ".$jur->namajurusan }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah Data Keterangan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 py-0 text-uppercase text-bold">
                    Keterangan Penilaian
                </h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahketerangan">
                    Tambah Keterangan Penilaian
                </button>

                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan P5</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($keterangan as $item)
                        <tr>
                            <td>{{ $item->index }}</td>
                            <td>{{ $item->keteranganp5." (".$item->inisialp5.")" }}</td>
                            <td>
                                <button class="badge py-1 border-0 badge-success" type="button" data-toggle="modal" data-target="#editketeranganp5{{ $item->idketeranganp5 }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <form action='{{ route('pengaturanp5.destroy', [$item->idketeranganp5]) }}' method='post' class='d-inline'>
                                     @csrf
                                     @method('DELETE')
                                     <button type='submit' class='badge py-1 badge-danger border-0' onclick="return confirm('Yakin ingin di hapus?')">
                                         <i class="fa fa-trash"></i>
                                     </button>
                                </form>
                            </td>
                        </tr>


                        <div id="editketeranganp5{{ $item->idketeranganp5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="my-modal-title">Edit Keterangan P5</h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('pengaturanp5.update', [$item->idketeranganp5]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="text-capitalize" for="inisial">Inisial Keterangan</label>
                                                <input id="inisial" placeholder="MB" class="form-control" type="text" name="inisialp5" value="{{ $item->inisialp5 }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="text-capitalize" for="keterangan">keterangan P5</label>
                                                <input id="keterangan" placeholder="Mulai Berkembang" class="form-control" type="text" name="keteranganp5" value="{{ $item->keteranganp5 }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3" placeholder="Peserta didik mulai mengembangkan kemampuan namun masih belum ajek">{{ $item->deskripsi }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-capitalize" for="index">Urutan</label>
                                                <input id="index" class="form-control" type="number" value="{{ $item->index }}"  name="index">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Update Data Keterangan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 py-0 text-uppercase text-bold">
                    Koordinator P5
                </h4>
            </div>

            <div class="card-body">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahkordinatorp5">
                    Tambah Kordinator P5
                </button>

                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kordinator</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($identitasp5 as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name ?? "" }}</td>
                            <td>{{ ($item->kelas->namakelas??"")." ".($item->jurusan->jurusan??"") }}</td>
                            <td>
                                <button class="badge py-1 border-0 badge-success" type="button" data-toggle="modal" data-target="#editidentitasp5{{ $item->ididentitasp5 }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <form action='{{ route('kordinator.destroy', [$item->ididentitasp5]) }}' method='post' class='d-inline'>
                                    @csrf
                                    @method('DELETE')
                                    <button type='submit' class='badge py-1 badge-danger border-0' onclick="return confirm('Yakin ingin di hapus?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                               </form>
                            </td>
                        </tr>


                        <div id="editidentitasp5{{ $item->ididentitasp5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="my-modal-title">Edit Kordinator P5</h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('kordinator.update', [$item->ididentitasp5]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="identitas">Nama Kordinator</label>
                                                <select id="identitas" required class="form-control select2identitas{{ $item->ididentitasp5 }}" name="iduser">
                                                    <option>Pilih Kordinator</option>
                                                    @foreach ($identitas as $user)
                                                        <option value="{{ $user->iduser }}" @if ($item->iduser == $user->iduser)
                                                            selected
                                                        @endif>{{ $user->user->name ?? 'none' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="kelas">Kelas</label>
                                                <select id="kelas" required class="form-control" name="idkelas">
                                                    <option>Pilih Kelas</option>
                                                    @foreach ($kelas as $kel)
                                                        <option value="{{ $kel->idkelas }}" @if ($item->idkelas == $kel->idkelas)
                                                            selected
                                                        @endif>{{ $kel->namakelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="jurusan">jurusan</label>
                                                <select id="jurusan" required class="form-control" name="idjurusan">
                                                    <option>Pilih jurusan</option>
                                                    @foreach ($jurusan as $jur)
                                                        <option value="{{ $jur->idjurusan }}" @if ($item->idjurusan == $jur->idjurusan)
                                                            selected
                                                        @endif>{{ $jur->jurusan." - ".$jur->namajurusan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Update Data Keterangan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('script')
    <script>
        $('.select2identitas').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahkordinatorp5')
        });




    </script>
    @foreach ($identitasp5 as $item)
    <script>
        $('.select2identitas{{ $item->ididentitasp5 }}').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#editidentitasp5{{ $item->ididentitasp5 }}')
        });

    </script>
    @endforeach

{{-- // $('.select2kelas{{ $loop->iteration }}').select2({
    //     theme: 'bootstrap4',
    //     dropdownParent: $('#tambahdetailraport{{ $item->idraport }}')
    // }); --}}
@endsection
