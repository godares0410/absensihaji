@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('title', 'Data Scan')

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Scan</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah Scan</th>
                        <th>Jumlah Tidak Scan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($dataGrouped as $nama => $items)
                    @if(!empty($nama)) <!-- Hanya tampilkan jika nama tidak null/kosong -->
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $nama }}</td>
                        <td>{{ $items->where('status', 1)->where('scan', 1)->count() }}</td>
                        <td>{{ $items->where('status', 1)->where('scan', 0)->count() }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Export <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('dataexport.export', ['nama' => $nama, 'format' => 'pdf']) }}">PDF</a></li>
                                    <li><a href="{{ route('dataexport.export', ['nama' => $nama, 'format' => 'excel']) }}">Excel</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-nama="{{ $nama }}">Hapus</button>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapusGrup" tabindex="-1" role="dialog" aria-labelledby="hapusLabel">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formHapusGrup">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus semua data dengan nama <strong id="namaToDelete"></strong>?</p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#datatable').DataTable();

        $('.btn-delete').on('click', function() {
            let nama = $(this).data('nama');
            $('#namaToDelete').text(nama);
            $('#formHapusGrup').attr('action', '/data-export/' + encodeURIComponent(nama));
            $('#modalHapusGrup').modal('show');
        });
    });
</script>
@endpush