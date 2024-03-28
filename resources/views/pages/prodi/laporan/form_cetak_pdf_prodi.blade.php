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
                <th>Kode Prodi</th>
                <th>Nama Prodi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_prodi as $prodi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $prodi->prodi_kode }}</td>
                    <td>{{ $prodi->prodi_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
