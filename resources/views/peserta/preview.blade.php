<!-- /Users/admin/Documents/absensinew/resources/views/peserta/preview.blade.php -->
@extends('layouts.app')
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('title', 'Preview Import')

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Preview Data Import</h3>
        </div>

        @if(count($invalidData) > 0)
        <div class="box-body">
            <div class="alert alert-danger">
                <h4><i class="icon fa fa-ban"></i> Sebanyak {{ count($invalidData) }} data gagal diimport!</h4>
                <p>Data berikut mengandung kesalahan dan tidak dapat diproses.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Peserta</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Rombongan</th>
                            <th>Regu</th>
                            <th>Keterangan</th>
                            <th>Embarkasi</th>
                            <th>Kloter</th>
                            <th>Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invalidData as $item)
                        <tr>
                            <td>{{ $item['nomor_peserta'] }}</td>
                            <td>{{ $item['nama_peserta'] }}</td>
                            <td>{{ $item['alamat'] }}</td>
                            <td>{{ $item['kecamatan'] }}</td>
                            <td>{{ $item['rombongan'] }}</td>
                            <td>{{ $item['regu'] }}</td>
                            <td>{{ $item['keterangan'] }}</td>
                            <td>{{ $item['embarkasi'] }}</td>
                            <td>{{ $item['kloter'] }}</td>
                            <td class="text-danger">{{ $item['error'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(count($validData) > 0)
        <div class="box-body">
            <div class="alert alert-success">
                <h4><i class="icon fa fa-check"></i> Data Valid Siap Import ({{ count($validData) }})</h4>
                <p>Data berikut akan diimport ke sistem.</p>
            </div>
            
            <form action="{{ route('peserta.processImport') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Peserta</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Rombongan</th>
                                <th>Regu</th>
                                <th>Keterangan</th>
                                <th>Embarkasi</th>
                                <th>Kloter</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($validData as $item)
                            <tr>
                                <td>{{ $item['nomor_peserta'] }}</td>
                                <td>{{ $item['nama_peserta'] }}</td>
                                <td>{{ $item['alamat'] }}</td>
                                <td>{{ $item['kecamatan'] }}</td>
                                <td>{{ $item['rombongan'] }}</td>
                                <td>{{ $item['regu'] }}</td>
                                <td>{{ $item['keterangan'] }}</td>
                                <td>{{ $item['embarkasi'] }}</td>
                                <td>{{ $item['kloter'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Proses Import
                    </button>
                    <a href="{{ route('peserta.index') }}" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
        @endif
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