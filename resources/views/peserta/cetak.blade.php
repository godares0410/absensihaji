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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }

        .page-wrapper {
            padding: 10mm;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            width: 53.98mm;
            height: 85.60mm;
            background-image: url('/image/doc/idcard.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            box-sizing: border-box;
            padding: 0;
            page-break-inside: avoid;
            margin-bottom: 5mm;
        }

        .card-content {
            height: 100%;
            color: black;
            padding: 6mm 4mm 4mm 4mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card-content img.photo {
            width: 80px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 5px;
            border: 1px solid #000;
        }

        .name {
            font-size: 14px;
            font-weight: bold;
        }

        .info {
            font-size: 8px;
            margin: 1px 0;
        }

        .box-group {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 3px;
        }

        .box {
            width: 30%;
            background: #fff;
            border-radius: 3px;
            border: 1px solid #000;
            padding: 1px;
        }

        .box-title {
            font-size: 7px;
            font-weight: bold;
        }

        .box-value {
            font-size: 9px;
            font-weight: bold;
        }

        .qr-code {
            width: 25mm;
            height: 25mm;
            margin: 2px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* border: 1px solid #000; */
        }

        .qr-code svg {
            width: 100%;
            height: 100%;
        }

        .qr-code .small-text {
            font-size: 7px;
            margin-top: 1mm;
            text-align: center;
        }


        .small-text {
            font-size: 6px;
        }

        .footer-box {
            border: 1px solid #000;
            border-radius: 3px;
            padding: 2px;
            background-color: #fff;
            margin-top: 1px;
            width: 100%;
            box-sizing: border-box;
        }

        .footer-text {
            font-size: 6px;
            text-align: center;
        }

        @media print {
            body {
                padding: 0;
            }

            .card-content {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .card {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

</head>

<body>
    <div class="page-wrapper">
        <div class="container">
            @foreach($pesertas as $peserta)
            <div class="card">
                <div class="card-content">
                    <img class="photo" src="{{ $peserta->foto ? asset('image/'.$peserta->foto) : asset('image/icon.png') }}" alt="Foto Peserta">
                    <div class="name">{{ strtoupper($peserta->nama_peserta) }}</div>
                    <div class="info">NO. PORSI {{ $peserta->nomor_peserta }}</div>

                    <div class="box-group">
                        <div class="box">
                            <div class="box-title">EMBARKASI</div>
                            <div class="box-value">{{ strtoupper($peserta->embarkasi) }}</div>
                        </div>
                        <div class="box">
                            <div class="box-title">KLOTER</div>
                            <div class="box-value">{{ $peserta->kloter }}</div>
                        </div>
                        <div class="box">
                            <div class="box-title">ROMBONGAN</div>
                            <div class="box-value">{{ $peserta->rombongan }}</div>
                        </div>
                        <!-- <div class="box">
                            <div class="box-title">REGU</div>
                            <div class="box-value">{{ $peserta->regu }}</div>
                        </div> -->
                    </div>

                    <div class="qr-code">
                        <div class="qr-image">
                            {!! DNS2D::getBarcodeSVG($peserta->nomor_peserta, 'QRCODE') !!}
                        </div>
                        <div class="small-text">No: {{ $peserta->nomor_peserta }}</div>
                    </div>


                    <div class="footer-box">
                        <div class="footer-text">
                            JAMAAH HAJI KBIHU AL AMANAH 2025<br>
                            NO. TELP. PEMBIMBING: 081234477735
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="no-print" style="position: fixed; bottom: 10px; right: 10px;">
        <button onclick="window.print()">Cetak Manual</button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>

</html>