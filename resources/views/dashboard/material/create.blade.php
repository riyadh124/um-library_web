@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Material</h1>
</div>
<div class="col-lg-8">
    <form method="POST" action="/dashboard/material" class="mb-5" >
        @csrf
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Material</label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" autofocus required>
          @error('nama')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" autofocus required>
            @error('harga')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>

        <button type="submit" class="btn btn-primary">Create Material</button>
    </form>
</div>

@endsection

