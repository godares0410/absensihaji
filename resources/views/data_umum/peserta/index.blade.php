<!-- /Users/admin/Documents/absensinew/resources/views/data_umum/peserta/index.blade.php -->
@extends('layouts.app')
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('title', 'Dashboard')

@section('content')
<section class="content">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data {{ ucwords($title) }}</h3>
            <div class="pull-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                    Import Data <i class="fa fa-upload"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSiswa">
                    Tambah <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 20px">No</th>
                        <th>Nomor Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Kecamatan</th>
                        <th>Rombongan</th>
                        <th>Regu</th>
                        <th>Kloter</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nomor_peserta }}</td>
                        <td>{{ $data->nama_peserta }}</td>
                        <td>{{ $data->kecamatan ?? '-' }}</td>
                        <td>{{ $data->rombongan ?? '-' }}</td>
                        <td>{{ $data->regu ?? '-' }}</td>
                        <td>{{ $data->kloter ?? '-' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditPeserta{{ $data->id_peserta }}">Edit</button>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetailPeserta{{ $data->id_peserta }}">Detail</button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete-peserta" data-id="{{ $data->id_peserta }}">
                                Hapus
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@includeIf('data_umum.peserta.modal')
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('.table').DataTable();
        
        // Event handler untuk tombol delete yang menggunakan event delegation
        $(document).on('click', '.btn-delete-peserta', function() {
            const id = $(this).data('id');
            const nama = $(this).closest('tr').find('td:eq(2)').text(); // Ambil nama peserta dari kolom ke-3
            
            $('#formHapusPeserta').attr('action', '/peserta/' + id);
            $('#checkSetujuHapus').prop('checked', false);
            $('#btnHapusPeserta').prop('disabled', true);
            
            // Update teks konfirmasi dengan nama peserta
            $('#modalHapusPeserta .modal-body p').html(
                `Apakah Anda yakin ingin menghapus data peserta <strong>${nama}</strong>?<br>
                <strong>Seluruh riwayat absensi terkait juga akan dihapus secara permanen.</strong>`
            );
            
            $('#modalHapusPeserta').modal('show');
        });

        // Handler untuk checkbox konfirmasi
        $('#checkSetujuHapus').on('change', function() {
            $('#btnHapusPeserta').prop('disabled', !this.checked);
        });

        // Fungsi untuk modal tambah/edit (jika diperlukan)
        function openModal(title) {
            $('.modal-title').text(title);
        }

        $('button[data-target="#modalTambahSiswa"]').on('click', function() {
            openModal("Tambah Peserta");
        });

        $('button[data-target="#importModal"]').on('click', function() {
            openModal("Import Data Peserta");
        });
    });
</script>


@endpush