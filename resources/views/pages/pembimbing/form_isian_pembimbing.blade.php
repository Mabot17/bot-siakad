@extends('layout.main_layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                    <h5>
                        {{Request::segment(2) === 'ubah' ? 'Ubah' : 'Tambah'}} pembimbing {{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_npp : '' }}
                    </h5>
                    <div class="d-flex flex-wrap align-items-center">
                        @csrf
                        <a href="{{ route('pembimbing') }}" class="btn btn-secondary"><i class="ri-user-add-fill"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        @if(Request::segment(2) === 'tambah')
            <form method="POST" action="{{ url('pembimbing/api-tambah/') }}" enctype="multipart/form-data">
        @elseif(Request::segment(2) === 'ubah')
            <form method="POST" action="{{ url('pembimbing/api-ubah/') }}" enctype="multipart/form-data">
                <input value="{{$data_pembimbing->pembimbing_id}}" name="pembimbing_id" hidden>
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
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="txtNama" class="h5">Nama Lengkap</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="txtNama"
                                            placeholder="Masukkan Nama Lengkap"
                                            name="pembimbing_nama"
                                            value="{{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_nama : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtNpp" class="h5">NPP</label>
                                        <input type="text" class="form-control" id="txtNpp" placeholder="Masukkan No. NPP" name="pembimbing_npp" value="{{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_npp : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="selectKelamin" class="h5">Jenis Kelamin</label>
                                        <select class="selectpicker form-control" data-style="py-0" id="selectKelamin" value="{{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_jenis_kelamin : '' }}" name="pembimbing_jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="txtHp" class="h5">No. HP</label>
                                        <input type="number" class="form-control" id="txtHp" placeholder="Masukkan Nomor HP" value="{{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_no_hp : '' }}" name="pembimbing_no_hp" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="txtAlamat">Alamat</label>
                                        <textarea class="form-control" rows="3" id="txtAlamat" name="pembimbing_alamat" required>{{ isset($data_pembimbing) ? $data_pembimbing->pembimbing_alamat : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-3"><i class="ri-save-fill"></i>Simpan</button>
                                        <a href="{{ route('pembimbing') }}" class="btn btn-danger"><i class="ri-delete-bin-2-fill"></i>Batal</a>
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
