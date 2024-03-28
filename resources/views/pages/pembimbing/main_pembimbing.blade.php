@extends('layout.main_layout')

@section('content')
@include('pages.pembimbing.form_hapus_pembimbing')
@include('pages.pembimbing.form_detail_pembimbing')
@include('pages.pembimbing.alert_pembimbing')
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                <h5>Daftar Pembimbing</h5>
                <div class="d-flex flex-wrap align-items-center">
                    @csrf
                    <div class="btn-group mr-3" role="group">
                        <button id="btnGroupDrop1"  type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ri-printer-cloud-fill"></i>Cetak Data
                            <i class="ri-arrow-down-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="{{ route('pembimbing.api-cetak-pdf') }}"><i class="ri-file-pdf-fill mr-1"></i>Format PDF</a>
                            <a class="dropdown-item" href="{{ route('pembimbing.api-cetak-excel') }}"><i class="ri-file-excel-2-fill mr-1"></i>Format Excel</a>
                        </div>
                    </div>
                    <a href="{{ route('pembimbing.tambah') }}" class="btn btn-primary"><i class="ri-user-add-fill"></i>Tambah Data</a>
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
                            <th>NPP</th>
                            <th>Nama Pembimbing</th>
                            <th>Alamat</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_pembimbing as $row_pembimbing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row_pembimbing->pembimbing_npp }}</td>
                                <td>{{ $row_pembimbing->pembimbing_nama }}</td>
                                <td>{{ $row_pembimbing->pembimbing_alamat }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important" onclick="detailPembimbing('{{ $row_pembimbing}}')"><i class="ri-search-eye-fill"></i></a>
                                    <a href="{{ url('pembimbing/ubah/'.$row_pembimbing->pembimbing_id) }}" class="btn btn-sm btn-success mr-1" style="text-align: center!important"><i class="ri-edit-2-fill"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning" style="text-align: center!important" onclick="konfirmasiHapusPembimbing('{{ $row_pembimbing }}')">
                                        <i class="ri-delete-bin-2-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function konfirmasiHapusPembimbing(pembimbing) {
        let dataPembimbing = JSON.parse(pembimbing);
        // Memasukkan data pembimbing ke dalam modal body
        var modalBody = `
            <b>Anda yakin ingin menghapus data pembimbing dengan:</b>
            <table class="ml-3">
                <tr>
                    <td><b>Nama</b></td>
                    <td><b>: ${dataPembimbing.pembimbing_nama}</b></td>
                </tr>
                <tr>
                    <td><b>NPP</b></td>
                    <td><b>: ${dataPembimbing.pembimbing_npp}</b></td>
                </tr>
            </table>
            <br>
            <p><b>Data yang dihapus tidak bisa dikembalikan!!</b></p>
        `;

        // Memasukkan isi modal body yang telah dibuat ke dalam elemen dengan id 'modal-body'
        $('#modal-body-hapus-pembimbing').html(modalBody);

        $('#button-hapus-pembimbing').attr('onclick', `window.location.href='/pembimbing/api-hapus/${dataPembimbing.pembimbing_id}'`);

        // Membuka modal
        $('#hapus-pembimbing-modal').modal('show');
    }

    function detailPembimbing(pembimbing) {
        let dataPembimbing = JSON.parse(pembimbing);

        // Mengatur nilai dari elemen-elemen teks
        $('#txtPembimbingNpp').val(dataPembimbing.pembimbing_npp);
        $('#txtPembimbingNama').val(dataPembimbing.pembimbing_nama);
        $('#txtPembimbingAlamat').val(dataPembimbing.pembimbing_alamat);
        $('#txtPembimbingJenisKelamin').val(dataPembimbing.pembimbing_jenis_kelamin);
        $('#txtPembimbingNoHp').val(dataPembimbing.pembimbing_no_hp);

        // Membuka modal
        $('#detail-pembimbing-modal').modal('show');
    }

</script>


@endsection
