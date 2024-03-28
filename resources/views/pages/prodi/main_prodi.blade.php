@extends('layout.main_layout')

@section('content')
@include('pages.prodi.form_hapus_prodi')
@include('pages.prodi.form_detail_prodi')
@include('pages.prodi.alert_prodi')
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                <h5>Daftar Prodi</h5>
                <div class="d-flex flex-wrap align-items-center">
                    @csrf
                    <div class="btn-group mr-3" role="group">
                        <button id="btnGroupDrop1"  type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ri-printer-cloud-fill"></i>Cetak Data
                            <i class="ri-arrow-down-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="{{ route('prodi.api-cetak-pdf') }}"><i class="ri-file-pdf-fill mr-1"></i>Format PDF</a>
                            <a class="dropdown-item" href="{{ route('prodi.api-cetak-excel') }}"><i class="ri-file-excel-2-fill mr-1"></i>Format Excel</a>
                        </div>
                    </div>
                    <a href="{{ route('prodi.tambah') }}" class="btn btn-primary"><i class="ri-user-add-fill"></i>Tambah Data</a>
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
                            <th>Kode Prodi</th>
                            <th>Nama Prodi</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_prodi as $row_prodi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row_prodi->prodi_kode }}</td>
                                <td>{{ $row_prodi->prodi_nama }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary mr-1" style="text-align: center!important" onclick="detailProdi('{{ $row_prodi}}')"><i class="ri-search-eye-fill"></i></a>
                                    <a href="{{ url('prodi/ubah/'.$row_prodi->prodi_id) }}" class="btn btn-sm btn-success mr-1" style="text-align: center!important"><i class="ri-edit-2-fill"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning" style="text-align: center!important" onclick="konfirmasiHapusProdi('{{ $row_prodi }}')">
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
    function konfirmasiHapusProdi(prodi) {
        let dataProdi = JSON.parse(prodi);
        // Memasukkan data prodi ke dalam modal body
        var modalBody = `
            <b>Anda yakin ingin menghapus data prodi dengan:</b>
            <table class="ml-3">
                <tr>
                    <td><b>Nama</b></td>
                    <td><b>: ${dataProdi.prodi_nama}</b></td>
                </tr>
                <tr>
                    <td><b>Kode</b></td>
                    <td><b>: ${dataProdi.prodi_kode}</b></td>
                </tr>
            </table>
            <br>
            <p><b>Data yang dihapus tidak bisa dikembalikan!!</b></p>
        `;

        // Memasukkan isi modal body yang telah dibuat ke dalam elemen dengan id 'modal-body'
        $('#modal-body-hapus-prodi').html(modalBody);

        $('#button-hapus-prodi').attr('onclick', `window.location.href='/prodi/api-hapus/${dataProdi.prodi_id}'`);

        // Membuka modal
        $('#hapus-prodi-modal').modal('show');
    }

    function detailProdi(prodi) {
        let dataProdi = JSON.parse(prodi);

        // Mengatur nilai dari elemen-elemen teks
        $('#txtProdiKode').val(dataProdi.prodi_kode);
        $('#txtProdiNama').val(dataProdi.prodi_nama);

        // Membuka modal
        $('#detail-prodi-modal').modal('show');
    }

</script>


@endsection
