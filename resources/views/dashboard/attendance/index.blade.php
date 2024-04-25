@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Hadir</h1>
  </div>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  @if (session()->has('fail'))
  <div class="alert alert-danger" role="alert">
    {{ session('fail') }}
  </div>
  @endif

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kode">
    Kode Daftar Hadir
</button>
<br>

<div class="modal fade" id="kode" tabindex="-1" role="dialog" aria-labelledby="kode"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/dashboard/book/store" method="POST" enctype="multipart/form-data">
                @csrf

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBookModalLabel">Kode Daftar Hadir                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              {!! $barcodeData !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </form>

        </div>
    </div>
</div>
  <br>
  <form action="{{ route('dashboard.attendance.index') }}" method="GET"
        class="form-inline d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari data..." aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Cari</button>
    </form>

  <div class="table-responsive small col-lg-12 mt-3">
    {{-- <a href="/dashboard/material/create" class="btn btn-primary mb-3">Create New Material</a> --}}
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Jabatan</th>
          <th scope="col">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($attendances as $attendance)
        <tr>
          <td>{{ $attendance->id }}</td>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ $attendance->user->role}}</td>
          <td>{{ $attendance->attendance_date }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    

    
    {{ $attendances->links('pagination::bootstrap-5') }}

  </div>
@endsection