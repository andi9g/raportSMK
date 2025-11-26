@extends('layouts.master')

@section('warnaraportpkl', 'active')

@section("judul", "Data Raport")
@section('content')
@section("header")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@livewireStyles
@endsection

<div class="container-fluid">

    <div class="card">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active text-lg" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Peserta Binaan PKL</a>
                <a class="nav-item nav-link text-lg" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Pilih Peserta Binaan PKL</a>
            </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="container-fluid table-responsive p-3">
                    <livewire:binaan :idpkl="$idpkl"/>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="container-fluid">
                    <livewire:pilihbinaan :idpkl="$idpkl"/>
                </div>

            </div>
        </div>
    </div>

</div>




@endsection

@section('footer')
<script>
window.addEventListener('swal', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.icon,
    });
});
</script>
@livewireScripts
@endsection
