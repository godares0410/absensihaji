@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="content-header">
  <h1>Dashboard <small>Control panel</small></h1>
</section>

<section class="content">
  <div class="row">
    <!-- Other boxes for statistics like totalPeserta, totalScan, etc. -->
  </div>

  <!-- Filter Section -->
  <div class="row">
    <div class="col-lg-6">
      <form action="{{ route('peserta.cetakKartu') }}" method="GET">
        <div class="form-group">
          <label for="rombongan">Rombongan</label>
          <select name="rombongan" id="rombongan" class="form-control">
            <option value="semua">Semua</option>
            @foreach($rombonganList as $rombongan)
              <option value="{{ $rombongan }}">{{ $rombongan }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="regu">Regu</label>
          <select name="regu" id="regu" class="form-control">
            <option value="semua">Semua</option>
            <!-- Regu options will be populated based on selected rombongan -->
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Print Kartu</button>
      </form>
    </div>
  </div>
</section>

<script>
  document.getElementById('rombongan').addEventListener('change', function() {
    var rombongan = this.value;
    var reguSelect = document.getElementById('regu');

    // Clear existing options
    reguSelect.innerHTML = '<option value="semua">Semua</option>';

    if (rombongan !== 'semua') {
      fetch(`/get-regu/${rombongan}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(function(regu) {
            var option = document.createElement('option');
            option.value = regu;
            option.textContent = regu;
            reguSelect.appendChild(option);
          });
        });
    }
  });
</script>
@endsection