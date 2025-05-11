@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('title', 'Data Admin User')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data {{ ucwords($title) }}</h3>
            <div class="pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahUser">
                    Tambah User <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                @php $count = 1; @endphp
                <tbody>
                    @foreach ($adminUsers as $index => $user)
                    @if ($user->id != 1)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditUser{{ $user->id }}">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                Hapus
                            </button>

                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('admin-users.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit User</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control mb-2" value="{{ $user->name }}" required placeholder="Nama">
                                        <input type="email" name="email" class="form-control mb-2" value="{{ $user->email }}" required placeholder="Email">
                                        <input type="password" name="password" class="form-control" placeholder="Ganti Password (opsional)">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('admin-users.store') }}" class="w-100">
            @csrf
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahUserLabel">Tambah Admin User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-4">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan alamat email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<!-- Modal Hapus User -->
<div class="modal fade" id="modalHapusUser" tabindex="-1" role="dialog" aria-labelledby="modalHapusUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formHapusUser">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusUserLabel">Konfirmasi Hapus User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong id="userNameToDelete"></strong>?</p>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkSetujuHapusUser">
                        <label class="form-check-label" for="checkSetujuHapusUser">Saya yakin ingin menghapus user ini</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-danger" id="btnHapusUser" disabled>Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#datatable').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        // Modal Hapus
        $('.btn-delete-user').on('click', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');

            $('#userNameToDelete').text(userName);
            $('#formHapusUser').attr('action', '/admin-users/' + userId);
            $('#checkSetujuHapusUser').prop('checked', false);
            $('#btnHapusUser').prop('disabled', true);
            $('#modalHapusUser').modal('show');
        });

        $('#checkSetujuHapusUser').on('change', function() {
            $('#btnHapusUser').prop('disabled', !this.checked);
        });
    });
</script>

@endpush