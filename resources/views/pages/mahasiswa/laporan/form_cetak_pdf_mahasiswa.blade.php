<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
                <th>Prodi</th>
                <th>Pembimbing</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_mahasiswa as $mahasiswa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mahasiswa->mhs_nbi }}</td>
                    <td>{{ $mahasiswa->mhs_nama }}</td>
                    <td>{{ $mahasiswa->mhs_jenis_kelamin }}</td>
                    <td>{{ $mahasiswa->mhs_tgl_lahir }}</td>
                    <td>{{ $mahasiswa->mhs_alamat }}</td>
                    <td>{{ $mahasiswa->prodi_nama }}</td>
                    <td>{{ $mahasiswa->pembimbing_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
