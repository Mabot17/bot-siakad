@extends('layout.main_layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                    <h5>
                        {{Request::segment(2) === 'ubah' ? 'Ubah' : 'Tambah'}} prodi {{ isset($data_prodi) ? $data_prodi->prodi_kode : '' }}
                    </h5>
                    <div class="d-flex flex-wrap align-items-center">
                        @csrf
                        <a href="{{ route('prodi') }}" class="btn btn-secondary"><i class="ri-user-add-fill"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        @if(Request::segment(2) === 'tambah')
            <form method="POST" action="{{ url('prodi/api-tambah/') }}" enctype="multipart/form-data">
        @elseif(Request::segment(2) === 'ubah')
            <form method="POST" action="{{ url('prodi/api-ubah/') }}" enctype="multipart/form-data">
                <input value="{{$data_prodi->prodi_id}}" name="prodi_id" hidden>
        @endif
            @csrf
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Informasi Utama</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtKode" class="h5">Kode Prodi</label>
                                        <input type="text" class="form-control" id="txtKode" placeholder="Masukkan Kode Prodi" name="prodi_kode" value="{{ isset($data_prodi) ? $data_prodi->prodi_kode : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="txtNama" class="h5">Nama Prodi</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="txtNama"
                                            placeholder="Masukkan Nama Lengkap"
                                            name="prodi_nama"
                                            value="{{ isset($data_prodi) ? $data_prodi->prodi_nama : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-3"><i class="ri-save-fill"></i>Simpan</button>
                                        <a href="{{ route('prodi') }}" class="btn btn-danger"><i class="ri-delete-bin-2-fill"></i>Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
