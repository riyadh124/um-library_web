
@extends('layouts.main')

@section('container')
    <div class="container mt-4">
        <img src="{{ asset('storage/images/hibah-buku-utk-perpustakaan-subur-a-1030x579.jpg') }}" class="bg-body shadow-sm mx-auto" style="height:400px;width:100%;border-radius: 30px;object-fit: cover;margin-bottom:20px;" alt="" srcset="">

        <p>Perpustakaan Universitas Mulia adalah inti dari kegiatan akademik di universitas ini. Didukung oleh koleksi yang terus diperbarui dan beragam, serta teknologi terkini, perpustakaan ini berkomitmen untuk memfasilitasi kegiatan belajar-mengajar dan penelitian. Mahasiswa dan dosen dapat mengakses ribuan judul buku, jurnal elektronik, makalah, dan sumber daya lainnya secara online melalui portal perpustakaan ini. Selain itu, perpustakaan ini juga menjadi tempat untuk mendapatkan bantuan penelitian dan layanan lainnya yang diperlukan untuk memperdalam pengetahuan dan mendukung proyek akademik. Dengan fokus pada kualitas, aksesibilitas, dan inovasi, Perpustakaan Universitas Mulia bertujuan untuk menjadi pusat pengetahuan yang dinamis bagi seluruh komunitas akademiknya.</p>
        {{-- <img src="img/{{ $image }}" alt="{{ $name }}" width="200" class="img-thumbnail">     --}}
    </div>
@endsection

