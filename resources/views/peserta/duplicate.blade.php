<!-- /Users/admin/Documents/absensinew/resources/views/peserta/duplicate.blade.php -->
@extends('layouts.app')
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('title', 'Hasil Import')

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Hasil Import Data Peserta</h3>
        </div>

        @if(count($insertedData) > 0)
        <div class="box-body">
            <div class="alert alert-success">
                <h4><i class="icon fa fa-check"></i> Data Berhasil Diimport ({{ count($insertedData) }})</h4>
                <p>Data berikut telah berhasil ditambahkan ke sistem.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
            </div>
        </div>
        @endif

        @if(count($duplicateData) > 0)
        <div class="box-body">
            <div class="alert alert-danger">
                <h4><i class="icon fa fa-ban"></i> Data Gagal Diimport ({{ count($duplicateData) }})</h4>
                <p>Nomor peserta berikut sudah digunakan dalam sistem.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
            </div>
        </div>
        @endif

        <div class="box-footer">
            <a href="{{ route('peserta.index') }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali ke Halaman Awal
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script>
@endpush