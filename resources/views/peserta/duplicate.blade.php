<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Import</title>
</head>
<body>
    @if(count($insertedData) > 0)
        <h2 style="color:green;">Data Berhasil Diimport ({{ count($insertedData) }})</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nomor Peserta</th>
                    <th>Nama Peserta</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                    <th>Rombongan</th>
                    <th>Regu</th>
                    <th>Keterangan</th>
                    <th>Kloter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($insertedData as $row)
                    <tr>
                        <td>{{ $row['nomor_peserta'] }}</td>
                        <td>{{ $row['nama_peserta'] }}</td>
                        <td>{{ $row['alamat'] }}</td>
                        <td>{{ $row['kecamatan'] }}</td>
                        <td>{{ $row['rombongan'] }}</td>
                        <td>{{ $row['regu'] }}</td>
                        <td>{{ $row['keterangan'] }}</td>
                        <td>{{ $row['kloter'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endif

    @if(count($duplicateData) > 0)
        <h2 style="color:red;">Data Nomor Peserta Ini Sudah Digunakan ({{ count($duplicateData) }})</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nomor Peserta</th>
                    <th>Nama Peserta</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                    <th>Rombongan</th>
                    <th>Regu</th>
                    <th>Keterangan</th>
                    <th>Kloter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($duplicateData as $row)
                    <tr>
                        <td>{{ $row['nomor_peserta'] }}</td>
                        <td>{{ $row['nama_peserta'] }}</td>
                        <td>{{ $row['alamat'] }}</td>
                        <td>{{ $row['kecamatan'] }}</td>
                        <td>{{ $row['rombongan'] }}</td>
                        <td>{{ $row['regu'] }}</td>
                        <td>{{ $row['keterangan'] }}</td>
                        <td>{{ $row['kloter'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endif

    <a href="{{ route('peserta.index') }}">Kembali ke Halaman Awal</a>
</body>
</html>
