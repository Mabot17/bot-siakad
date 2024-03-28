<!DOCTYPE html>
<html>
<head>
    <title>Data Pembimbing</title>
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
    <h1>Data Pembimbing</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>NPP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_pembimbing as $pembimbing)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pembimbing->pembimbing_npp }}</td>
                    <td>{{ $pembimbing->pembimbing_nama }}</td>
                    <td>{{ $pembimbing->pembimbing_jenis_kelamin }}</td>
                    <td>{{ $pembimbing->pembimbing_no_hp }}</td>
                    <td>{{ $pembimbing->pembimbing_alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
