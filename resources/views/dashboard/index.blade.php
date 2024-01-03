@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome back, {{ Auth()->user()->name }}</h1>
  </div>
  <div class="container">
    <h2 class="mb-3">Total Harga Material</h2>
    <div class="row">
        <div class="col-md-3">
            <h4>Hari Ini</h4>
            <p>Total harga: Rp {{ number_format($totalCost24Hours, 0, ',', '.') }}</p>
        </div>
        <div class="col-md-3">
            <h4>Seminggu</h4>
            <p>Total harga: Rp {{ number_format($totalCostWeek, 0, ',', '.') }}</p>
        </div>
        <div class="col-md-3">
            <h4>Sebulan</h4>
            <p>Total harga: Rp {{ number_format($totalCostMonth, 0, ',', '.') }}</p>
        </div>
        <div class="col-md-3">
            <h4>Sepanjang Tahun Ini</h4>
            <p>Total harga: Rp {{ number_format($totalCostYear, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection