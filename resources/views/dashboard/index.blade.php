@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome back, {{ Auth()->user()->name }}</h1>
  </div>
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <div class="col">
      <div class="card ">
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-6">
                    <i class="bi bi-people-fill" style="font-size: 40px"></i>
                </div>
                <div class="col-md-6">
                    <h5 class="card-text">{{ $totalUsers }}</h5>
                    <p class="card-text">Total User</p>
                </div>
            </div>
       </div>
      </div>
    </div>
    <div class="col">
        <div class="card ">
          <div class="card-body">
              <div class="row g-0">
                  <div class="col-md-6">
                      <i class="bi bi-book-fill" style="font-size: 40px"></i>
                  </div>
                  <div class="col-md-6">
                      <h5 class="card-text">{{ $totalBooks }}</h5>
                      <p class="card-text">Total Buku</p>
                  </div>
              </div>
         </div>
        </div>
      </div>
      <div class="col">
        <div class="card ">
          <div class="card-body">
              <div class="row g-0">
                  <div class="col-md-4">
                      <i class="bi bi-archive-fill" style="font-size: 40px"></i>
                  </div>
                  <div class="col-md-8">
                      <h5 class="card-text">{{ $totalBorrowsNotReturned }}</h5>
                      <p class="card-text">Total Peminjaman</p>
                  </div>
              </div>
         </div>
        </div>
      </div>
      <div class="col">
        <div class="card ">
          <div class="card-body">
              <div class="row g-0">
                  <div class="col-md-4">
                      <i class="bi bi-arrow-down-square-fill" style="font-size: 40px"></i>
                  </div>
                  <div class="col-md-8">
                      <h5 class="card-text">{{ $totalBorrowsReturned }}</h5>
                      <p class="card-text">Total Pengembalian</p>
                  </div>
              </div>
         </div>
        </div>
      </div>
  </div>
</div>
@endsection