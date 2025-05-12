<!-- /Users/admin/Documents/absensinew/resources/views/data_umum/peserta/modal.blade.php -->
<!-- Modal Tambah Peserta -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('peserta.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Peserta</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Peserta</label>
                        <input type="text" name="nomor_peserta" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Peserta</label>
                        <input type="text" name="nama_peserta" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Rombongan</label>
                        <input type="number" name="rombongan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Regu</label>
                        <input type="number" name="regu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Embarkasi</label>
                        <input type="text" name="embarkasi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kloter</label>
                        <input type="text" name="kloter" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto Peserta</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Max 2MB)</small>
                    </div>
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
                    </br>
                    <p class="mt-2">
                        <strong>Gunakan Format Yang Sudah Disediakan.</strong>
                    </p>
                    <a href="{{ asset('import/Format Import Peserta.xlsx') }}" class="btn btn-sm btn-success" download>
                        Download Format Import
                    </a>
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
<div class="modal fade" id="modalDetailPeserta{{ $data->id_peserta }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title font-weight-bold" id="modalDetailLabel">Detail Peserta</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="mb-4">
                            <img src="{{ $data->foto ? asset('image/'.$data->foto) : asset('image/icon.png') }}"
                                alt="Foto Peserta" class="img-thumbnail rounded-circle shadow" width="180">
                        </div>
                        <h3 class="h5 font-weight-bold text-primary">{{ $data->nama_peserta }}</h3>
                        <h4 class="h6 text-muted">{{ $data->nomor_peserta }}</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Kecamatan</h5>
                                    <p class="detail-value">{{ $data->kecamatan ?? '-' }}</p>
                                </div>
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Rombongan</h5>
                                    <p class="detail-value">{{ $data->rombongan ?? '-' }}</p>
                                </div>
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Regu</h5>
                                    <p class="detail-value">{{ $data->regu ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Kloter</h5>
                                    <p class="detail-value">{{ $data->kloter ?? '-' }}</p>
                                </div>
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Embarkasi</h5>
                                    <p class="detail-value">{{ $data->embarkasi ?? '-' }}</p>
                                </div>
                                <div class="detail-item mb-3">
                                    <h5 class="detail-label text-secondary">Keterangan</h5>
                                    <p class="detail-value">{{ $data->keterangan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <h5 class="detail-label text-secondary">Alamat</h5>
                            <p class="detail-value">{{ $data->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
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
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ $data->keterangan }}">
                    </div>
                    <div class="form-group">
                        <label>Embarkasi</label>
                        <input type="text" name="embarkasi" class="form-control" value="{{ $data->embarkasi }}">
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
                        @if($data->foto)
                        <div class="mb-2">
                            <img src="{{ asset('image/' . $data->foto) }}" width="100" class="img-thumbnail">
                        </div>
                        @endif
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
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Konfirmasi Hapus Peserta</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <!-- Teks akan diupdate via JavaScript -->
                    </p>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkSetujuHapus">
                        <label class="form-check-label" for="checkSetujuHapus">
                            Saya menyetujui penghapusan data ini.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" id="btnHapusPeserta" disabled>Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Terpilih -->
<div class="modal fade" id="modalBulkHapusPeserta" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formBulkHapusPeserta">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Hapus Terpilih</h4>
                </div>
                <div class="modal-body">
                    <p id="modalBulkHapusText">Anda akan menghapus beberapa peserta.</p>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="checkSetujuBulkHapus">
                            Saya mengerti dan ingin melanjutkan
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btnBulkHapusPeserta" class="btn btn-danger" disabled>Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>