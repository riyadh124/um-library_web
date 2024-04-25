@extends('dashboard.layouts.main')

@section('container')


@if (session()->has('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<style>
    .book {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background-color: #f9f9f9;
    }

    .book-header {
        display: flex;
    }

    .book-header img {
        width: 150px;
        height: auto;
        margin-right: 20px;
        object-fit: cover;

    }

    .book-details {
        flex: 1;
    }

    .book-title {
        font-size: 1.2em;
        margin-top: 0;
    }

    .book-author,
    .book-publisher,
    .book-code,
    .book-year,
    .book-status {
        margin: 5px 0;
    }
</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Katalog Buku</h1>

    <form action="{{ route('dashboard.book.index') }}" method="GET"
        class="form-inline d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari buku..." aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Cari</button>
    </form>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
        Tambah Buku Baru
    </button>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/dashboard/book/store" method="POST" enctype="multipart/form-data">
                @csrf

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBookModalLabel">Tambah Buku Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Form untuk menambahkan buku baru -->
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="pengarang">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="kode_buku">Kode Buku</label>
                        <input type="text" class="form-control" id="kode_buku" name="kode_buku" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="cover">Cover Buku</label>
                        <input type="file" class="form-control-file mt-2" id="cover" name="cover" accept="image/*" required>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Buku</button>
            </div>

        </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/dashboard/book/update" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editBookModalLabel">Edit Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Form untuk mengedit buku -->
                    <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="edit_judul">Judul Buku</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_pengarang">Pengarang</label>
                        <input type="text" class="form-control" id="edit_pengarang" name="pengarang" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kode_buku">Kode Buku</label>
                        <input type="text" class="form-control" id="edit_kode_buku" name="kode_buku" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_penerbit">Penerbit</label>
                        <input type="text" class="form-control" id="edit_penerbit" name="penerbit" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tahun_terbit">Tahun Terbit</label>
                        <input type="text" class="form-control" id="edit_tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                    <!-- Tambahkan input file untuk mengunggah cover buku -->
                    <div class="form-group">
                        <label for="edit_cover">Cover Buku</label>
                        <input type="file" class="form-control-file" id="edit_cover" name="cover" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($books->count() > 0)
@foreach($books as $book)
<div class="book">
    <div class="book-header">
        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku">
        <div class="book-details">
            <h2 class="book-title">{{ $book->judul_buku }}</h2>
            <p class="book-author">Pengarang: {{ $book->pengarang }}</p>
            <p class="book-publisher">Penerbit: {{ $book->penerbit }}</p>
            <p class="book-year">Tahun Terbit: {{ $book->tahun_terbit }}</p>
            <p class="book-status">Status: {{ $book->status }}</p>
            <p class="book-code">Kode Buku: {{ $book->kode_buku }}</p>
            <div class="barcode">
                {!! $barcodes[$book->id] !!}
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editBookModal"
    data-book-id="{{ $book->id }}" data-judul="{{ $book->judul_buku }}" data-pengarang="{{ $book->pengarang }}"
    data-kode-buku="{{ $book->kode_buku }}" data-penerbit="{{ $book->penerbit }}"
    data-tahun-terbit="{{ $book->tahun_terbit }}" data-status="{{ $book->status }}">Edit</button>

    <!-- Tombol Hapus -->
    <form action="/dashboard/book/{{ $book->id }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">Hapus</button>
    </form>
</div>
@endforeach
@else
<p>Tidak ada buku yang ditemukan.</p>
@endif
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function () {
        $("#tahun_terbit").datepicker({
            dateFormat: "yy",
            changeYear: true,
            yearRange: "1900:{{ date('Y') }}", // Batasi rentang tahun dari 1900 hingga tahun saat ini
            showButtonPanel: true
        });
    });

    $(document).ready(function() {
        $('#editBookModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var bookId = button.data('book-id'); // Mendapatkan data buku dari atribut data-book-id
            var judul = button.data('judul'); // Mendapatkan judul buku dari atribut data-judul
            var pengarang = button.data('pengarang'); // Mendapatkan pengarang buku dari atribut data-pengarang
            var kodeBuku = button.data('kode-buku'); // Mendapatkan kode buku dari atribut data-kode-buku
            var penerbit = button.data('penerbit'); // Mendapatkan penerbit buku dari atribut data-penerbit
            var tahunTerbit = button.data('tahun-terbit'); // Mendapatkan tahun terbit buku dari atribut data-tahun-terbit
            var status = button.data('status'); // Mendapatkan status buku dari atribut data-status

            // Mengisi nilai-nilai input dengan data buku yang dipilih
            var modal = $(this);
            modal.find('.modal-body #book_id').val(bookId);
            modal.find('.modal-body #edit_judul').val(judul);
            modal.find('.modal-body #edit_pengarang').val(pengarang);
            modal.find('.modal-body #edit_kode_buku').val(kodeBuku);
            modal.find('.modal-body #edit_penerbit').val(penerbit);
            modal.find('.modal-body #edit_tahun_terbit').val(tahunTerbit);
            modal.find('.modal-body #edit_status').val(status);
        });
    });
</script>