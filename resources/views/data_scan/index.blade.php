<!-- /Users/admin/Documents/absensinew/resources/views/data_scan/index.blade.php -->
@extends('layouts.app')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('title', 'Data Scan Absensi')

@section('content')
<section class="content">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
        {{ session('error') }}
    </div>
    @endif

    <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title">Data Scan Absensi</h3>
                </div>
                <div class="col-md-6">
                    <div class="pull-right" style="display: flex; align-items: center; gap: 10px;">
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalRekapAbsensi" style="white-space: nowrap;">
                            <i class="fa fa-file-excel-o"></i> Rekap Absensi
                        </button>

                        <div style="display: flex; align-items: center;">
                            <form action="{{ route('datascan.index') }}" method="GET" class="form-inline">
                                <div class="form-group">
                                    <label class="control-label">Status: </label>
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="1" {{ request('status', 1) == 1 ? 'selected' : '' }}>Sudah Scan</option>
                                        <option value="0" {{ request('status', 1) == 0 ? 'selected' : '' }}>Belum Scan</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="scanTable">
                <thead>
                    <tr>
                        <th style="width: 20px">No</th>
                        <th>Nomor Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Kecamatan</th>
                        <th>Rombongan</th>
                        <th>Regu</th>
                        <th>Kloter</th>
                        @if(request('status', 1) == 1)
                        <th>Waktu Scan</th>
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scans as $index => $scan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $scan->nomor_peserta ?? '-' }}</td>
                        <td>{{ $scan->nama_peserta ?? '-' }}</td>
                        <td>{{ $scan->kecamatan ?? '-' }}</td>
                        <td>{{ $scan->rombongan ?? '-' }}</td>
                        <td>{{ $scan->regu ?? '-' }}</td>
                        <td>{{ $scan->kloter ?? '-' }}</td>
                        @if(request('status', 1) == 1)
                        <td>{{ $scan->waktu_scan }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-delete-scan"
                                data-id="{{ $scan->id_scan }}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapusScan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formHapusScan" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Hapus Data Scan</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah Anda yakin ingin menghapus data scan ini?
                        <strong>Data yang dihapus tidak dapat dikembalikan.</strong>
                    </p>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="checkSetujuHapusScan"> Saya menyetujui penghapusan data ini.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" id="btnHapusScan" disabled>Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rekap Absensi -->
<div class="modal fade" id="modalRekapAbsensi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('datascan.rekap') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Rekap Absensi</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Beri Nama Absensi:</label>
                        <input type="text" name="nama_absensi" class="form-control" required placeholder="Contoh: Absensi Upacara 10 Mei">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Rekap</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan ID tabel
        $('#scanTable').DataTable();

        // Modal Hapus Scan
        $('#checkSetujuHapusScan').on('change', function() {
            $('#btnHapusScan').prop('disabled', !this.checked);
        });

        $('button.btn-delete-scan').on('click', function() {
            const id = $(this).data('id');
            $('#formHapusScan').attr('action', '/data-scan/' + id);
            $('#checkSetujuHapusScan').prop('checked', false);
            $('#btnHapusScan').prop('disabled', true);
            $('#modalHapusScan').modal('show');
        });
    });
</script>
@endpush