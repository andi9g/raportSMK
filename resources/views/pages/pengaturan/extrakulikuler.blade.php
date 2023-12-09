@extends('layouts.master')

@section('warnapengaturan', 'active')
@section('warnapengaturanextrakulikuler', 'active')

@section("judul")
    PENGATURAN EXTRAKULIKULER
@endsection

@section('content')
<div id="tambahpembinaex" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Pembina</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengaturanextrakulikuler.store', []) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="identitas">Nama Pembina</label>
                        <select id="identitas" required class="form-control" name="iduser">
                            <option>Pilih Pembina</option>
                            @foreach ($identitas as $user)
                                <option value="{{ $user->iduser }}">{{ $user->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="namaex">Nama Extrakulikuler</label>
                        <input id="namaex" class="form-control" type="text" placeholder="Pramuka/Paskibra/Music" name="namaex">
                    </div>

                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <select id="ket" class="form-control" name="ket">
                            <option value="umum">Umum</option>
                            <option value="khusus">Khusus</option>
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
    <div class="col-md-3"></div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 py-0 text-uppercase text-bold">
                    Pembina 
                </h4>
            </div>

            <div class="card-body">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahpembinaex">
                    Tambah Pembina
                </button>
    
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembina</th>
                            <th>Extrakulikuler</th>
                            <th>Ket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pembina as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->namaex}}</td>
                            <td>{{ $item->ket}}</td>
                            <td>
                                <button class="badge py-1 border-0 badge-success" type="button" data-toggle="modal" data-target="#editidentitas{{ $item->idpembinaex }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <form action='{{ route('pengaturanextrakulikuler.destroy', [$item->idpembinaex]) }}' method='post' class='d-inline'>
                                    @csrf
                                    @method('DELETE')
                                    <button type='submit' class='badge py-1 badge-danger border-0' onclick="return confirm('Yakin ingin di hapus?')">
                                        <i class="fa fa-trash"></i> 
                                    </button>
                               </form>
                            </td>
                        </tr>
                            

                        <div id="editidentitas{{ $item->idpembinaex }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="my-modal-title">Edit Pembina </h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('pengaturanextrakulikuler.update', [$item->idpembinaex]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="identitas">Nama Pembina</label>
                                                <select id="identitas" required class="form-control select2identitas{{ $item->idpembinaex }}" name="iduser">
                                                    <option>Pilih Pembina</option>
                                                    @foreach ($identitas as $user)
                                                        <option value="{{ $user->iduser }}" @if ($item->iduser == $user->iduser)
                                                            selected
                                                        @endif>{{ $user->user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                        
                                            <div class="form-group">
                                                <label for="namaex">Nama Extrakulikuler</label>
                                                <input id="namaex" class="form-control" type="text" placeholder="Pramuka/Paskibra/Music" name="namaex" value="{{ $item->namaex }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="ket">Keterangan</label>
                                                <select id="ket" class="form-control" name="ket">
                                                    <option value="umum" @if ($item->ket == "umum")
                                                        selected
                                                    @endif>Umum</option>
                                                    <option value="khusus" @if ($item->ket == "khusus")
                                                        selected
                                                    @endif>Khusus</option>
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
            dropdownParent: $('#tambahpembinaex')
        });



        
    </script>
    @foreach ($identitas as $item)
    <script>
        $('.select2identitas{{ $item->idpembinaex }}').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#editidentitas{{ $item->idpembinaex }}')
        });

    </script>
    @endforeach

{{-- // $('.select2kelas{{ $loop->iteration }}').select2({
    //     theme: 'bootstrap4',
    //     dropdownParent: $('#tambahdetailraport{{ $item->idraport }}')
    // }); --}}
@endsection
