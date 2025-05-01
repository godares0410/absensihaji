<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peserta Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 210mm; /* A4 size */
            height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
        }

        .box {
            border: 1px solid #000;
            padding: 10mm;
            margin-bottom: 10mm;
            height: 150mm; /* adjust height if needed */
        }

        .content {
            font-size: 14px;
        }

        .content .label {
            font-weight: bold;
        }

        .qr-code {
            margin-top: 10mm;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <div class="content">
                <p><span class="label">Nama:</span> {{ $peserta->nama_peserta }}</p>
                <p><span class="label">Alamat:</span> {{ $peserta->alamat }}</p>
                <p><span class="label">Rombongan:</span> {{ $peserta->rombongan }}</p>
                <p><span class="label">Regu:</span> {{ $peserta->regu }}</p>
                <p><span class="label">Keterangan:</span> {{ $peserta->keterangan }}</p>
            </div>

            <div class="qr-code">
                {!! $qrCode !!} <!-- QR Code -->
            </div>
        </div>
    </div>
</body>
</html>
