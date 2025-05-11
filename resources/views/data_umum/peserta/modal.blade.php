<!-- /Users/admin/Documents/absensinew/resources/views/data_umum/peserta/modal.blade.php -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Peserta</h4>
                </div>
                <div class="modal-body">
                    <!-- Tambahkan input form peserta di sini -->
                    <p>Form tambah peserta (belum diimplementasikan)</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('peserta.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Data Peserta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="file">Pilih File Excel:</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tampilkan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>


@foreach ($peserta as $data)
<!-- Modal Detail -->
<div class="modal fade" id="modalDetailPeserta{{ $data->id_peserta }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Peserta</h4>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $data->foto ? asset('storage/' . $data->foto) : asset('image/icon.png') }}" alt="Foto Peserta" class="img-thumbnail mb-3" width="150">
                <p><strong>Nomor Peserta:</strong> {{ $data->nomor_peserta }}</p>
                <p><strong>Nama Peserta:</strong> {{ $data->nama_peserta }}</p>
                <p><strong>Kecamatan:</strong> {{ $data->kecamatan ?? '-' }}</p>
                <p><strong>Rombongan:</strong> {{ $data->rombongan ?? '-' }}</p>
                <p><strong>Regu:</strong> {{ $data->regu ?? '-' }}</p>
                <p><strong>Kloter:</strong> {{ $data->kloter ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $data->alamat ?? '-' }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPeserta{{ $data->id_peserta }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('peserta.update', $data->id_peserta) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Peserta</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Peserta</label>
                        <input type="text" name="nomor_peserta" class="form-control" value="{{ $data->nomor_peserta }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Peserta</label>
                        <input type="text" name="nama_peserta" class="form-control" value="{{ $data->nama_peserta }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ $data->kecamatan }}">
                    </div>
                    <div class="form-group">
                        <label>Rombongan</label>
                        <input type="number" name="rombongan" class="form-control" value="{{ $data->rombongan }}">
                    </div>
                    <div class="form-group">
                        <label>Regu</label>
                        <input type="number" name="regu" class="form-control" value="{{ $data->regu }}">
                    </div>
                    <div class="form-group">
                        <label>Kloter</label>
                        <input type="text" name="kloter" class="form-control" value="{{ $data->kloter }}">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control">{{ $data->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto (optional)</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapusPeserta" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formHapusPeserta" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Hapus Peserta</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah Anda yakin ingin menghapus data peserta ini? <br>
                        <strong>Seluruh riwayat absensi terkait juga akan dihapus secara permanen.</strong>
                    </p>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="checkSetujuHapus"> Saya menyetujui penghapusan data ini.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" id="btnHapusPeserta" disabled>Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>