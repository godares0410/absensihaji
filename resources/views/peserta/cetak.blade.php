<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Kartu Peserta</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial;
            margin: 0;
            padding: 10px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            width: 33.3%;
            height: 50%;
            padding: 10px;
            box-sizing: border-box;
        }
        .card-content {
            border: 1px solid #000;
            height: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }
        .qr-code {
            margin-top: auto;
            text-align: center;
        }
        
        /* CSS khusus untuk cetak */
        @media print {
            body {
                padding: 0;
            }
            .card-content {
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .qr-code img, .qr-code svg {
                display: block !important;
                margin: 0 auto;
                max-width: 100% !important;
                height: auto !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @foreach($pesertas as $peserta)
        <div class="card">
            <div class="card-content">
                <h3>KARTU PESERTA</h3>
                <p>Nama: {{ $peserta->nama_peserta }}</p>
                <p>Alamat: {{ $peserta->alamat }}</p>
                <p>Rombongan: {{ $peserta->rombongan }}</p>
                <p>Regu: {{ $peserta->regu }}</p>
                <p>Keterangan: {{ $peserta->keterangan }}</p>
                <div class="qr-code">
                    {{-- Pilih salah satu metode QR Code berikut --}}
                    {{-- Metode 1: SVG (Direkomendasikan) --}}
                    {!! DNS2D::getBarcodeSVG($peserta->nomor_peserta, 'QRCODE', 5, 5) !!}
                    
                    {{-- Metode 2: PNG (Alternatif) --}}
                    {{-- <img src="data:image/png;base64,{{ base64_encode(DNS2D::getBarcodePNG($peserta->nomor_peserta, 'QRCODE')) }}" alt="QR Code"> --}}
                    
                    <p>No: {{ $peserta->nomor_peserta }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="no-print" style="position: fixed; bottom: 10px; right: 10px;">
        <button onclick="window.print()">Cetak Manual</button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                // Optional: Tutup window setelah cetak (untuk halaman popup)
                // setTimeout(function() { window.close(); }, 100);
            }, 1000); // Beri waktu 1 detik untuk memastikan semua elemen ter-render
        };
    </script>
</body>
</html>`