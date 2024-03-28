@extends('layout.main_layout')

@section('content')
@include('pages.mahasiswa.form_hapus_mahasiswa')
@include('pages.mahasiswa.form_detail_mahasiswa')
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                <h5>Daftar Mahasiswa</h5>
                <div class="d-flex flex-wrap align-items-center">
                    @csrf
                    <div class="btn-group mr-3" role="group">
                        <button id="btnGroupDrop1"  type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ri-printer-cloud-fill"></i>Cetak Data
                            <i class="ri-arrow-down-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="{{ route('mahasiswa.api-cetak-pdf') }}"><i class="ri-file-pdf-fill mr-1"></i>Format PDF</a>
                            <a class="dropdown-item" href="{{ route('mahasiswa.api-cetak-excel') }}"><i class="ri-file-excel-2-fill mr-1"></i>Format Excel</a>
                        </div>
                    </div>
                    <a type="button"  href="{{ route('mahasiswa.tambah') }}" class="btn btn-primary"><i class="ri-user-add-fill"></i>Tambah Data</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table data-table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Informasi Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $mahasiswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td width="30%">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            @if($mahasiswa->mhs_foto_path)
                                                <img class="rounded avatar-50" src="{{ asset($mahasiswa->mhs_foto_path) }}" alt="profile-pic">
                                            @else
                                                <img class="rounded avatar-50" src="{{ asset('/images/user/default-profile.jpg') }}" alt="profile-pic">
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="button" class="mt-2 btn @php echo $mahasiswa->mhs_prodi_id === 1 ? 'btn-primary' : ($mahasiswa->mhs_prodi_id === 2 ? 'btn-secondary' : ($mahasiswa->mhs_prodi_id === 3 ? 'btn-success' : ($mahasiswa->mhs_prodi_id === 4 ? 'btn-danger' : ($mahasiswa->mhs_prodi_id === 5 ? 'btn-warning' : ($mahasiswa->mhs_prodi_id === 6 ? 'btn-info' : 'btn-dark'))))) @endphp" disabled>{{ $mahasiswa->mhs_nbi }}</button>
                                            <br>
                                            {{ $mahasiswa->mhs_nama }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $mahasiswa->prodi_nama }}</td>
                                <td>{{ $mahasiswa->mhs_jenis_kelamin }}</td>
                                <td>{{ $mahasiswa->mhs_tgl_lahir }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important" onclick="detailMahasiswa('{{ $mahasiswa}}')"><i class="ri-search-eye-fill"></i></a>
                                    <a href="{{ url('mahasiswa/ubah/'.$mahasiswa->mhs_id) }}" class="btn btn-sm btn-success mr-1" style="text-align: center!important"><i class="ri-edit-2-fill"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning" style="text-align: center!important" onclick="konfirmasiHapusMahasiswa('{{ $mahasiswa }}')">
                                        <i class="ri-delete-bin-2-fill"></i>
                                    </a>

                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('pages.mahasiswa.alert_mahasiswa')
    </div>
</div>
<script>
    function konfirmasiHapusMahasiswa(mahasiswa) {
        let dataMahasiswa = JSON.parse(mahasiswa);
        // Memasukkan data mahasiswa ke dalam modal body
        var modalBody = `
            <b>Anda yakin ingin menghapus data mahasiswa dengan:</b>
            <table class="ml-3">
                <tr>
                    <td><b>Nama</b></td>
                    <td><b>: ${dataMahasiswa.mhs_nama}</b></td>
                </tr>
                <tr>
                    <td><b>NBI</b></td>
                    <td><b>: ${dataMahasiswa.mhs_nbi}</b></td>
                </tr>
            </table>
            <br>
            <p><b>Data yang dihapus tidak bisa dikembalikan!!</b></p>
        `;

        // Memasukkan isi modal body yang telah dibuat ke dalam elemen dengan id 'modal-body'
        $('#modal-body-hapus-mhs').html(modalBody);

        $('#button-hapus-mhs').attr('onclick', `window.location.href='/mahasiswa/api-hapus/${dataMahasiswa.mhs_id}'`);

        // Membuka modal
        $('#hapus-mahasiswa-modal').modal('show');
    }

    function detailMahasiswa(mahasiswa) {
        let dataMahasiswa = JSON.parse(mahasiswa);

        // Mengatur nilai dari elemen-elemen teks
        if (dataMahasiswa.mhs_foto_path != null) {
            document.querySelector('.mhs-detail-profile-pic').src = "../" + dataMahasiswa.mhs_foto_path;
        }else{
            document.querySelector('.mhs-detail-profile-pic').src = "../images/user/default-profile.jpg";
        }
        $('#txtProdi').val(dataMahasiswa.prodi_nama);
        $('#txtNbi').val(dataMahasiswa.mhs_nbi);
        $('#txtNama').val(dataMahasiswa.mhs_nama);
        $('#txtTglLahir').val(dataMahasiswa.mhs_tgl_lahir);
        if (dataMahasiswa.mhs_jenis_kelamin == 'L') {
            $('#txtKelamin').val('Laki-laki');
        }else{
            $('#txtKelamin').val('Perempuan');
        }
        $('#txtHp').val(dataMahasiswa.mhs_no_hp);
        $('#txtAlamat').text(dataMahasiswa.mhs_alamat);
        $('#txtPembimbing').val(dataMahasiswa.pembimbing_nama);

        // Membuka modal
        $('#detail-mahasiswa-modal').modal('show');
    }

</script>


@endsection
