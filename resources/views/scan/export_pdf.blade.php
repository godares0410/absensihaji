<!-- /Users/admin/Documents/absensinew/resources/views/scan/export_pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Scan - {{ $nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid black; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Scan - {{ $nama }}</h2>

    <h3>Sudah Scan {{ $countSudahScan }} Peserta</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <!-- <th>ID Scan</th> -->
                <th>Nama Peserta</th>
                <th>Nomor Peserta</th>
                <th>Kecamatan</th>
                <th>Regu</th>
                <th>Rombongan</th>
                <th>Kloter</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sudahScan as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <!-- <td>{{ $row->id_scan }}</td> -->
                <td>{{ $row->nama_peserta }}</td>
                <td>{{ $row->nomor_peserta }}</td>
                <td>{{ $row->kecamatan }}</td>
                <td>{{ $row->regu }}</td>
                <td>{{ $row->rombongan }}</td>
                <td>{{ $row->kloter }}</td>
                <td>{{ $row->waktu_scan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Belum Scan {{ $countBelumScan }} Peserta</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Nomor Peserta</th>
                <th>Kecamatan</th>
                <th>Regu</th>
                <th>Rombongan</th>
                <th>Kloter</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($belumScan as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->nama_peserta }}</td>
                <td>{{ $row->nomor_peserta }}</td>
                <td>{{ $row->kecamatan }}</td>
                <td>{{ $row->regu }}</td>
                <td>{{ $row->rombongan }}</td>
                <td>{{ $row->kloter }}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
