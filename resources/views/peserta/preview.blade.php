<h2>Data Hasil Import</h2>

@if(count($invalidData) > 0)
    <h3 style="color:red;">Sebanyak {{ count($invalidData) }} data gagal diimport:</h3>
    <table border="1">
        <tr>
            <th>Nomor Peserta</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Rombongan</th><th>Regu</th><th>Keterangan</th><th>Kloter</th><th>Keterangan Error</th>
        </tr>
        @foreach($invalidData as $item)
        <tr style="color:red;">
            <td>{{ $item['nomor_peserta'] }}</td>
            <td>{{ $item['nama_peserta'] }}</td>
            <td>{{ $item['alamat'] }}</td>
            <td>{{ $item['kecamatan'] }}</td>
            <td>{{ $item['rombongan'] }}</td>
            <td>{{ $item['regu'] }}</td>
            <td>{{ $item['keterangan'] }}</td>
            <td>{{ $item['kloter'] }}</td>
            <td>{{ $item['error'] }}</td>
        </tr>
        @endforeach
    </table>
@endif

@if(count($validData) > 0)
    <h3>Data Hasil Import Sebanyak {{ count($validData) }} Data</h3>
    <form action="{{ route('peserta.processImport') }}" method="POST">
        @csrf
        <table border="1">
            <tr>
                <th>Nomor Peserta</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Rombongan</th><th>Regu</th><th>Keterangan</th><th>Kloter</th>
            </tr>
            @foreach($validData as $item)
            <tr>
                <td>{{ $item['nomor_peserta'] }}</td>
                <td>{{ $item['nama_peserta'] }}</td>
                <td>{{ $item['alamat'] }}</td>
                <td>{{ $item['kecamatan'] }}</td>
                <td>{{ $item['rombongan'] }}</td>
                <td>{{ $item['regu'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
                <td>{{ $item['kloter'] }}</td>
            </tr>
            @endforeach
        </table>
        <button type="submit">Proses Import</button>
        <a href="{{ route('peserta.index') }}"><button type="button">Batal</button></a>
    </form>
@endif
