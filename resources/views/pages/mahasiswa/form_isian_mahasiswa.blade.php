@extends('layout.main_layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                    <h5>{{Request::segment(2) === 'ubah' ? 'Ubah' : 'Tambah'}} Mahasiswa {{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_nbi : '' }}                    </h5>
                    <div class="d-flex flex-wrap align-items-center">
                        @csrf
                        <a href="{{ route('mahasiswa') }}" class="btn btn-secondary"><i class="ri-user-add-fill"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        @if(Request::segment(2) === 'tambah')
            <form method="POST" action="{{ url('mahasiswa/api-tambah/') }}" enctype="multipart/form-data">
        @elseif(Request::segment(2) === 'ubah')
            <form method="POST" action="{{ url('mahasiswa/api-ubah/') }}" enctype="multipart/form-data">
                <input value="{{$data_mahasiswa->mhs_id}}" name="mhs_id" hidden>
        @endif
            @csrf
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="card d-flex justify-content-end">
                        <div class="card-header d-flex justify-content-center">
                            <div class="header-title">
                                <h4 class="card-title">Foto Profil</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="form-group" class="custom-file-small">
                                    <div class="crm-profile-img-edit position-relative text-center mb-2">
                                        <img
                                            class="mhs-profile-pic rounded avatar-100"
                                            src="{{
                                                asset(isset($data_mahasiswa) && $data_mahasiswa->mhs_foto_path !== null ? $data_mahasiswa->mhs_foto_path : '/images/user/default-profile.jpg')
                                            }}"
                                            alt="profile-pic">
                                        <div class="crm-p-image bg-primary position-absolute bottom-0 right-0">
                                            <i class="las la-pen upload-button"></i>
                                            <input value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_foto_path : '' }}" class="file-upload" type="file" accept="image/*" name="mhs_foto_path">
                                        </div>
                                    </div>
                                    <div class="img-extension position-relative text-center">
                                        <div class="d-inline-block align-items-center">
                                            <span>Format file yang di izinkan.</span>
                                            <a href="javascript:void();">.jpg</a>
                                            <a href="javascript:void();">.png</a>
                                            <a href="javascript:void();">.jpeg</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
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
                                            name="mhs_nama"
                                            value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_nama : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="selectProdi" class="h5">Prodi</label>
                                        <select class="selectpicker form-control" id="selectProdi" data-style="py-0" name="mhs_prodi_id" required>
                                            <option value="" selected disabled>- Pilih Prodi -</option> <!-- Defaultnya - -->
                                            @foreach($data_prodi as $row_prodi)
                                                @if(isset($data_mahasiswa) && $data_mahasiswa->mhs_prodi_id == $row_prodi->prodi_id)
                                                    <option value="{{ $row_prodi->prodi_id }}" selected>{{ $row_prodi->prodi_nama }}</option>
                                                @else
                                                    <option value="{{ $row_prodi->prodi_id }}">{{ $row_prodi->prodi_nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtNbi" class="h5">NBI</label>
                                        <input type="text" class="form-control" id="txtNbi" placeholder="(Otomatis)" name="mhs_nbi" value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_nbi : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="dateLahir" class="h5">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="dateLahir" value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_tgl_lahir : '' }}" name="mhs_tgl_lahir">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="selectKelamin" class="h5">Jenis Kelamin</label>
                                        <select class="selectpicker form-control" data-style="py-0" id="selectKelamin" value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_jenis_kelamin : '' }}" name="mhs_jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="txtHp" class="h5">No. HP</label>
                                        <input type="number" class="form-control" id="txtHp" placeholder="Masukkan Nomor HP" value="{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_no_hp : '' }}" name="mhs_no_hp" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="txtAlamat">Alamat</label>
                                        <textarea class="form-control" rows="3" id="txtAlamat" name="mhs_alamat" required>{{ isset($data_mahasiswa) ? $data_mahasiswa->mhs_alamat : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="selectPembimbing" class="h5">Dosen Pembimbing</label>
                                        <select class="selectpicker form-control" id="selectPembimbing" data-style="py-0" name="mhs_pembimbing_id" required>
                                            <option value="" selected disabled>- Pilih Pembimbing -</option> <!-- Defaultnya - -->
                                            @foreach($data_pembimbing as $row_pembimbing)
                                                @if(isset($data_mahasiswa) && $data_mahasiswa->mhs_pembimbing_id == $row_pembimbing->pembimbing_id)
                                                    <option value="{{ $row_pembimbing->pembimbing_id }}" selected>{{ $row_pembimbing->pembimbing_nama }}</option>
                                                @else
                                                    <option value="{{ $row_pembimbing->pembimbing_id }}">{{ $row_pembimbing->pembimbing_nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-3"><i class="ri-save-fill"></i>Simpan</button>
                                        <a href="{{ route('mahasiswa') }}" class="btn btn-danger"><i class="ri-delete-bin-2-fill"></i>Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Mendapatkan elemen select
        var selectProdi = document.getElementById('selectProdi');

        // Menambahkan event listener untuk perubahan pada elemen select
        selectProdi.addEventListener('change', function() {
            var prodiId = this.value; // Mendapatkan nilai prodi_id yang dipilih
            fetchLastNbiByProdi(prodiId); // Panggil fungsi untuk mengambil NBI terakhir
        });


        // Fungsi untuk mengambil NBI terakhir dari database berdasarkan prodi_id
        function fetchLastNbiByProdi(prodiId) {
            // Lakukan permintaan AJAX ke backend untuk mengambil NBI terakhir
            // Ganti URL sesuai dengan rute yang Anda buat
            $.get(`/mahasiswa/last-nbi/${prodiId}`, function(response) {
                lastNbi = response.lastNbi; // Simpan NBI terakhir ke dalam variabel
                // Atur ulang nilai txtNbi berdasarkan NBI terakhir yang diperoleh dari database
                txtNbi.value = lastNbi;
            });
        }

        document.querySelector('input[name="mhs_foto_path"]').addEventListener('change', function() {
            const file = this.files[0]; // Mengambil file gambar yang dipilih
            const reader = new FileReader(); // Membuat pembaca file

            reader.onload = function(e) {
                // Mengubah sumber gambar menjadi data URL dari file yang dipilih
                document.querySelector('.mhs-profile-pic').src = e.target.result;
            }

            // Membaca file sebagai URL data
            reader.readAsDataURL(file);
        });

    </script>
@endsection
