<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form dengan List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
            height: 100%;
        }

        .list-group-item {
            border: none;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .list-group-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .media img {
            border-radius: 50%;
            border: 2px solid #007bff;
            width: 50px;
            height: 50px;
            object-fit: cover;
            /* Add blur effect while loading */
            filter: blur(2px);
            transition: filter 0.3s ease;
        }

        .media img.loaded {
            filter: blur(0);
        }

        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
            border-radius: 10px 10px 0 0;
            transition: background 0.3s, color 0.3s;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            background: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            background: #e9ecef;
        }

        .tab-content {
            background: #fff;
            padding: 20px;
            border-radius: 0 10px 10px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .scan-time {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
        }

        .info-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .info-box h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #343a40;
        }

        .info-box p {
            font-size: 16px;
            margin: 0;
            color: #6c757d;
            font-weight: 500;
        }

        .info-box p strong {
            color: #343a40;
        }

        .form-group label {
            font-weight: 500;
            color: #343a40;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .fa-spin {
            animation: fa-spin 1s infinite linear;
        }

        @keyframes fa-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Participant number styling */
        .participant-number {
            display: inline-block;
            background: #e9ecef;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 12px;
            color: #495057;
            margin-right: 8px;
            white-space: nowrap;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Scrollable container for participant numbers */
        .scrollable-number {
            display: flex;
            overflow-x: auto;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .scrollable-number::-webkit-scrollbar {
            height: 5px;
        }

        .scrollable-number::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollable-number::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .scrollable-number::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Search box styling */
        .search-box {
            margin-bottom: 15px;
            position: relative;
        }

        .search-box .form-control {
            padding-left: 40px;
            border-radius: 20px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
            z-index: 10;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                margin-top: 15px;
            }
            
            .form-container {
                padding: 15px;
            }
            
            .info-box {
                padding: 15px;
            }
            
            .tab-content {
                padding: 15px;
            }
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
                            <!-- <div class="scrollable-number mb-2">
                                @foreach($belumScan as $peserta)
                                <span class="participant-number" title="{{ $peserta->nomor_peserta }}" onclick="document.getElementById('kode').value = '{{ $peserta->nomor_peserta }}'">
                                    {{ $peserta->nomor_peserta }}
                                </span>
                                @endforeach
                            </div> -->
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
                    <div id="qr-reader" style="width:100%; display:none;" class="mt-3"></div>
                </div>
            </div>

            <!-- Daftar Sudah Scan dan Belum Scan -->
            <div class="col-md-6 mb-4">
                <div class="form-container">
                    <h2 class="mb-4" style="color: #343a40; font-weight: 600;">Status Scan</h2>

                    <!-- Informasi Tambahan -->
                    <div class="info-box">
                        <h5>Informasi Scan</h5>
                        <div class="d-flex justify-content-between">
                            <p><strong>Total Peserta:</strong> {{ $totalPeserta }}</p>
                            <p><strong>Sudah Scan:</strong> {{ $totalSudahScan }}</p>
                            <p><strong>Belum Scan:</strong> {{ $totalBelumScan }}</p>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sudah-scan-tab" data-toggle="tab" href="#sudah-scan" role="tab" aria-controls="sudah-scan" aria-selected="true">Sudah Scan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="belum-scan-tab" data-toggle="tab" href="#belum-scan" role="tab" aria-controls="belum-scan" aria-selected="false">Belum Scan</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Sudah Scan -->
                        <div class="tab-pane fade show active" id="sudah-scan" role="tabpanel" aria-labelledby="sudah-scan-tab">
                            <div class="list-group mt-3" style="max-height: 400px; overflow-y: auto;">
                                @foreach($sudahScan as $scan)
                                <div class="list-group-item">
                                    <div class="media">
                                        <img src="{{ asset('image/' . ($scan->foto ?? 'icon.png')) }}"
                                            class="mr-3 lazy"
                                            alt="Foto"
                                            loading="lazy"
                                            onload="this.classList.add('loaded')"
                                            width="50"
                                            height="50">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1" style="color: #343a40; font-weight: 600;">{{ $scan->nama_peserta }}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- <span class="participant-number">{{ $scan->nomor_peserta }}</span> -->
                                                <div class="scan-time">{{ $scan->waktu_scan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Belum Scan -->
                        <div class="tab-pane fade" id="belum-scan" role="tabpanel" aria-labelledby="belum-scan-tab">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" id="searchBelumScan" placeholder="Cari nama peserta...">
                            </div>
                            <div class="list-group mt-2" id="belumScanList" style="max-height: 400px; overflow-y: auto;">
                                @foreach($belumScan as $peserta)
                                <div class="list-group-item" data-name="{{ strtolower($peserta->nama_peserta) }}">
                                    <div class="media">
                                        <img src="{{ asset('image/' . ($scan->foto ?? 'icon.png')) }}"
                                            class="mr-3 lazy"
                                            alt="Foto"
                                            loading="lazy"
                                            onload="this.classList.add('loaded')"
                                            width="50"
                                            height="50">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1" style="color: #343a40; font-weight: 600;">{{ $peserta->nama_peserta }}</h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- <span class="participant-number">{{ $peserta->nomor_peserta }}</span> -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Lazysizes for lazy loading images -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

    <script>
        // Handle form submission
        $('form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalBtnText = submitBtn.html();

            // Show loading state
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
                            timerProgressBar: true,
                            willClose: () => {
                                location.reload(); // Refresh to update the lists
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                },
                error: function(xhr) {
                    let message = 'Terjadi kesalahan saat memproses scan';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

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

        // QR Scanner functionality
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
                    // QR code terdeteksi
                    document.getElementById("kode").value = qrCodeMessage;
                    html5QrCode.stop();
                    qrReader.style.display = "none";

                    // Submit form after QR detected
                    $('form').submit();
                },
                errorMessage => {
                    console.log(`QR error: ${errorMessage}`);
                }
            ).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Error',
                    text: 'Gagal mengakses kamera: ' + err.message
                });
                console.log("Error memulai kamera:", err);
            });
        });

        // Search functionality for Belum Scan tab
        $('#searchBelumScan').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('#belumScanList .list-group-item').each(function() {
                const participantName = $(this).data('name');
                if (participantName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Function to scan participant
        function scanPeserta(nomorPeserta) {
            Swal.fire({
                title: 'Konfirmasi Scan',
                text: `Apakah Anda yakin ingin melakukan scan untuk peserta ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Scan',
                cancelButtonText: 'Batal'
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
                                    timerProgressBar: true,
                                    willClose: () => {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        },
                        error: function(xhr) {
                            let message = 'Terjadi kesalahan saat memproses scan';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

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

        // Show any flash messages from server
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            timerProgressBar: true
        });
        @endif
    </script>
</body>

</html>