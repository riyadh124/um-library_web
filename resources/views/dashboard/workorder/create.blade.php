@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Workorder</h1>
</div>
<div class="col-lg-8">
    <form method="POST" action="/dashboard/workorder" class="mb-5" >
        @csrf
        <div class="mb-3">
          <label for="nomor_tiket" class="form-label">Nomor Tiket</label>
          <input type="text" class="form-control @error('nomor_tiket') is-invalid @enderror" id="nomor_tiket" name="nomor_tiket" value="TCKT-{{ old('nomor_tiket') }}" autofocus required>
          @error('nomor_tiket')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
            <label for="tipe_segmen" class="form-label">Tipe Segmen</label>
            <select class="form-select @error('tipe_segmen') is-invalid @enderror" id="tipe_segmen" name="tipe_segmen" required>
                <option value="">Pilih Tipe Segmen</option>
                <option value="Seeder" {{ old('tipe_segmen') === 'Seeder' ? 'selected' : '' }}>Seeder</option>
                <option value="Distribusi" {{ old('tipe_segmen') === 'Distribusi' ? 'selected' : '' }}>Distribusi</option>
            </select>
            @error('tipe_segmen')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lokasi_gangguan_masal" class="form-label">Lokasi Gangguan Masal</label>
            <input type="text" class="form-control @error('lokasi_gangguan_masal') is-invalid @enderror" id="lokasi_gangguan_masal" name="lokasi_gangguan_masal" value="{{ old('lokasi_gangguan_masal') }}" autofocus required>
            @error('lokasi_gangguan_masal')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>
          
      
          <div class="mb-3">
            <label for="deskripsi_gangguan" class="form-label">Deskripsi Gangguan</label>
            <input type="text" class="form-control @error('deskripsi_gangguan') is-invalid @enderror" id="deskripsi_gangguan" name="deskripsi_gangguan" value="{{ old('deskripsi_gangguan') }}" autofocus required>
            @error('deskripsi_gangguan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="instruksi_pekerjaan" class="form-label">Instruksi Pekerjaan</label>
            <input type="text" class="form-control @error('instruksi_pekerjaan') is-invalid @enderror" id="instruksi_pekerjaan" name="instruksi_pekerjaan" value="{{ old('instruksi_pekerjaan') }}" autofocus required>
            @error('instruksi_pekerjaan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>

        <button type="submit" class="btn btn-primary">Create Workorder</button>
    </form>
</div>

@endsection

