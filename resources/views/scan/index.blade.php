@php
use Illuminate\Support\Facades\DB;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Peserta</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- HTML5 QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .form-container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
            border-radius: 10px 10px 0 0;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            background: #007bff;
            color: #fff;
        }

        .tab-content {
            background: #fff;
            padding: 20px;
            border-radius: 0 10px 10px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .list-group-item {
            border: none;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .media img {
            border-radius: 50%;
            border: 2px solid #007bff;
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .badge-rombongan {
            background-color: #17a2b8;
            color: white;
        }

        .badge-regu {
            background-color: #6c757d;
            color: white;
        }

        .detail-rombongan {
            cursor: pointer;
            transition: all 0.3s;
        }

        .detail-rombongan:hover {
            background-color: #f8f9fa;
        }

        .detail-regu {
            padding-left: 30px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .collapse-icon {
            transition: transform 0.3s;
        }

        .collapsed .collapse-icon {
            transform: rotate(-90deg);
        }

        .search-box {
            position: relative;
            margin-bottom: 15px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 20px;
        }

        #qr-reader {
            width: 100%;
            display: none;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 15px;
            }

            .form-container {
                padding: 15px;
            }
        }

        .peserta-list {
            display: grid;
            gap: 8px;
        }

        .peserta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .peserta-item:hover {
            background-color: #e9ecef;
            transform: translateX(2px);
        }

        .peserta-nama {
            font-weight: 500;
            color: #343a40;
        }

        .peserta-nomor {
            font-size: 0.8rem;
            background-color: white;
            padding: 3px 6px;
        }

        .detail-regu {
            transition: all 0.3s;
        }

        .detail-regu:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Form Input Kode -->
            <div class="col-md-6 mb-4">
                <div class="form-container">
                    <h2 class="mb-4" style="color: #343a40; font-weight: 600;">Masukkan Kode</h2>
                    <form action="{{ route('scan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Peserta</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode peserta" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="openCamera">
                                <i class="fas fa-camera"></i> Scan QR
                            </button>
                        </div>
                    </form>
                    <div id="qr-reader"></div>
                </div>
            </div>

            <!-- Daftar Scan -->
            <div class="col-md-6 mb-4">
                <div class="form-container">
                    <h2 class="mb-4" style="color: #343a40; font-weight: 600;">Status Scan</h2>

                    <div class="info-box">
                        <h5>Informasi Scan</h5>
                        <div class="d-flex justify-content-between">
                            <p><strong>Total:</strong> {{ $totalPeserta }}</p>
                            <p><strong>Sudah Scan:</strong> {{ $totalSudahScan }}</p>
                            <p><strong>Belum Scan:</strong> {{ $totalBelumScan }}</p>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="overflow-x: auto; white-space: nowrap; flex-wrap: nowrap;">
                        <li class="nav-item">
                            <a class="nav-link active" id="sudah-scan-tab" data-toggle="tab" href="#sudah-scan" role="tab">Sudah Scan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="belum-scan-tab" data-toggle="tab" href="#belum-scan" role="tab">Belum Scan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="detail-scan-tab" data-toggle="tab" href="#detail-scan" role="tab">Detail Belum Scan</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Sudah Scan -->
                        <div class="tab-pane fade show active" id="sudah-scan" role="tabpanel">
                            <div class="list-group mt-3" style="max-height: 400px; overflow-y: auto;">
                                @foreach($sudahScan as $scan)
                                <div class="list-group-item">
                                    <div class="media">
                                        <img src="{{ asset('image/' . ($scan->foto ?? 'icon.png')) }}" class="mr-3">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">{{ $scan->nama_peserta }}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="badge badge-rombongan">Rombongan {{ $scan->rombongan }}</span>
                                                    <span class="badge badge-regu">Regu {{ $scan->regu }}</span>
                                                </div>
                                                <div class="text-muted small">{{ $scan->waktu_scan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Belum Scan -->
                        <div class="tab-pane fade" id="belum-scan" role="tabpanel">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" id="searchBelumScan" placeholder="Cari nama peserta...">
                            </div>
                            <div class="list-group mt-2" id="belumScanList" style="max-height: 400px; overflow-y: auto;">
                                @foreach($belumScan as $peserta)
                                <div class="list-group-item" data-name="{{ strtolower($peserta->nama_peserta) }}">
                                    <div class="media">
                                        <img src="{{ asset('image/' . ($peserta->foto ?? 'icon.png')) }}" class="mr-3">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1">{{ $peserta->nama_peserta }}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="badge badge-rombongan">Rombongan {{ $peserta->rombongan }}</span>
                                                    <span class="badge badge-regu">Regu {{ $peserta->regu }}</span>
                                                </div>
                                                <button class="btn btn-primary btn-sm" onclick="scanPeserta('{{ $peserta->nomor_peserta }}')">
                                                    <i class="fas fa-check"></i> Scan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Detail Belum Scan -->
                        <div class="tab-pane fade" id="detail-scan" role="tabpanel">
                            <div class="mt-3" style="max-height: 500px; overflow-y: auto;">
                                @foreach($rombonganStats as $rombongan)
                                <div class="card mb-2">
                                    <div class="card-header detail-rombongan" data-toggle="collapse" href="#collapseRombongan{{ $rombongan->rombongan }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Rombongan {{ $rombongan->rombongan }} ({{ $rombongan->total }} peserta)</h5>
                                            <i class="fas fa-chevron-down collapse-icon"></i>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseRombongan{{ $rombongan->rombongan }}">
                                        <div class="card-body p-0">
                                            @php
                                            $regus = DB::table('peserta')
                                            ->whereNotIn('id_peserta', function($query) {
                                            $query->select('id_peserta')->from('scan');
                                            })
                                            ->where('rombongan', $rombongan->rombongan)
                                            ->select('regu', DB::raw('count(*) as total'))
                                            ->groupBy('regu')
                                            ->get();
                                            @endphp

                                            @foreach($regus as $regu)
                                            <div class="p-3 detail-regu border-bottom">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Regu {{ $regu->regu }} ({{ $regu->total }} peserta)</h6>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="showPesertaBelumScan({{ $rombongan->rombongan }}, {{ $regu->regu }})">
                                                        <i class="fas fa-list"></i> Lihat Lengkap
                                                    </button>
                                                </div>

                                                @php
                                                $pesertas = DB::table('peserta')
                                                ->whereNotIn('id_peserta', function($query) {
                                                $query->select('id_peserta')->from('scan');
                                                })
                                                ->where('rombongan', $rombongan->rombongan)
                                                ->where('regu', $regu->regu)
                                                ->select('nama_peserta', 'nomor_peserta')
                                                ->limit(5)
                                                ->get();
                                                $counter = 1;
                                                @endphp

                                                <div class="peserta-list">
                                                    @foreach($pesertas as $peserta)
                                                    <div class="peserta-item" onclick="scanPeserta('{{ $peserta->nomor_peserta }}')">
                                                        <span class="peserta-no mr-2">{{ $counter++ }}.</span>
                                                        <span class="peserta-nama">{{ $peserta->nama_peserta }}</span>
                                                        <span class="peserta-nomor badge badge-light">No. {{ $peserta->nomor_peserta }}</span>
                                                    </div>
                                                    @endforeach
                                                    @if($regu->total > 5)
                                                    <div class="text-center mt-2">
                                                        <span class="badge badge-secondary">
                                                            +{{ $regu->total - 5 }} peserta lainnya
                                                        </span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pesertaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Peserta Belum Scan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group" id="modalPesertaList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Form submission
        $('form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalBtnText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: `Scan berhasil untuk <b>${response.data.nama_peserta}</b><br>Waktu: ${response.data.waktu_scan}`,
                            timer: 3000,
                            willClose: () => location.reload()
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            timer: 3000
                        });
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses scan';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: message
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // QR Scanner
        document.getElementById("openCamera").addEventListener("click", function() {
            const qrReader = document.getElementById("qr-reader");
            qrReader.style.display = "block";

            const html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                qrCodeMessage => {
                    document.getElementById("kode").value = qrCodeMessage;
                    html5QrCode.stop();
                    qrReader.style.display = "none";
                    $('form').submit();
                },
                errorMessage => console.log(`QR error: ${errorMessage}`)
            ).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Error',
                    text: 'Gagal mengakses kamera: ' + err.message
                });
            });
        });

        // Search functionality
        $('#searchBelumScan').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('#belumScanList .list-group-item').each(function() {
                const participantName = $(this).data('name');
                $(this).toggle(participantName.includes(searchTerm));
            });
        });

        // Scan participant
        function scanPeserta(nomorPeserta) {
            Swal.fire({
                title: 'Konfirmasi Scan',
                text: `Scan peserta ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Scan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("scan.store") }}',
                        method: 'POST',
                        data: {
                            kode: nomorPeserta,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    html: `Scan berhasil untuk <b>${response.data.nama_peserta}</b><br>Waktu: ${response.data.waktu_scan}`,
                                    timer: 3000,
                                    willClose: () => location.reload()
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses scan';
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: message
                            });
                        }
                    });
                }
            });
        }

        // Show peserta belum scan in modal
        function showPesertaBelumScan(rombongan, regu) {
            // console.log('Requesting data for rombongan:', rombongan, 'regu:', regu);

            $.ajax({
                url: '/scan/belum-scan',
                type: 'GET',
                data: {
                    rombongan: rombongan,
                    regu: regu
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response);
                    if (response.success) {
                        let html = '';
                        if (response.data.length > 0) {
                            response.data.forEach(peserta => {
                                html += `
                        <div class="list-group-item">
                            <div class="media">
                                <img src="{{ asset('image') }}/${peserta.foto || 'icon.png'}" 
                                     class="mr-3" width="50" height="50">
                                <div class="media-body">
                                    <h5>${peserta.nama_peserta}</h5>
                                    <div>
                                        <span class="badge bg-info" style="color: white;">Rombongan ${peserta.rombongan}</span>
                                        <span class="badge bg-secondary" style="color: white;">Regu ${peserta.regu}</span>
                                        <span class="badge bg-primary" style="color: white;">No. ${peserta.nomor_peserta}</span>
                                    </div>
                                    <button class="btn btn-sm btn-primary mt-2" 
                                            onclick="scanPeserta('${peserta.nomor_peserta}')">
                                        <i class="fas fa-check"></i> Scan
                                    </button>
                                </div>
                            </div>
                        </div>`;
                            });
                        } else {
                            html = '<div class="alert alert-info">Tidak ada peserta yang ditemukan</div>';
                        }
                        $('#modalPesertaList').html(html);
                        $('#pesertaModal').modal('show');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    let errorMsg = 'Gagal memuat data peserta';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            errorMsg += ': ' + response.error;
                        }
                    } catch (e) {}
                    Swal.fire('Error', errorMsg, 'error');
                }
            });
        }

        // Flash messages
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('
            success ') }}',
            timer: 3000
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('
            error ') }}',
            timer: 3000
        });
        @endif
    </script>
</body>

</html>