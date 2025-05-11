<!-- /Users/admin/Documents/absensinew/resources/views/peserta/index.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Peserta</title>
</head>

<body>
    <h1>Import Peserta</h1>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('peserta.preview') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Pilih File Excel:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Tampilkan Data</button>
    </form>

</body>

</html>