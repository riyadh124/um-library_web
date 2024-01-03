@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <div class="row my-3">
        <div class="col-lg-8">
            <h1 class="mb-3">{{ $workorder->nomor_tiket }}</h1>

            <a href="/dashboard/workorder" class="btn btn-success"> <i class="bi bi-arrow-left"
                    style="font-size: 15px"></i> Back to all workorders</a>
            {{-- <a href="/dashboard/workorder/{{ $workorder->id }}/edit" class="btn btn-warning"> <i
                    class="bi bi-pencil-fill" style="font-size: 15px"></i> Edit</a> --}}
            <form action="/dashboard/workorder/{{ $workorder->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger border-0" onclick="return confirm('Are you sure?')">
                    <i class="bi bi-trash-fill" style="font-size: 15px"></i>
                    Delete
                </button>
            </form>

            <div class="my-3">
                <label for="exampleFormControlInput1" class="form-label">Nomor Tiket</label>
                <input value={{ $workorder->nomor_tiket }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Tipe Segmen</label>
                <input value={{ $workorder->tipe_segmen }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Lokasi Gangguan Masal</label>
                <textarea readonly disabled class="form-control" id="exampleFormControlTextarea1" rows="3">
                    {{ $workorder->lokasi_gangguan_masal }}
                </textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Deskripsi Gangguan</label>
                <textarea readonly disabled class="form-control" id="exampleFormControlTextarea1" rows="3">
                    {{ $workorder->deskripsi_gangguan }}
                </textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Instruksi Pekerjaan</label>
                <textarea readonly disabled class="form-control" id="exampleFormControlTextarea1" rows="3">
                    {{ $workorder->instruksi_pekerjaan }}
                </textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Status</label>
                <input value={{ $workorder->status }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            @if ( $workorder->user)
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Teknisi</label>
                <input value={{ $workorder->user->name }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            @endif
           
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Catatan Perbaikan</label>
                <textarea readonly disabled class="form-control" id="exampleFormControlTextarea1" rows="3">
                    {{ $workorder->keterangan_perbaikan }}
                </textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Created At</label>
                <input value={{ $workorder->created_at }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Updated At</label>
                <input value={{ $workorder->updated_at }} readonly disabled type="text" class="form-control"
                    id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Dokumentasi Sebelum Perbaikan</label>
                <div class="row">
                    @foreach ($docBefores as $docBefore)
                    <img src="{{ asset('storage/' . $docBefore->image) }}" style="height: 150px; object-fit: cover;"
                        class="img-fluid mx-3 mb-3 col-4 img-thumbnail">
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">List material yang digunakan</label>
                <div class="row">
                    @foreach ($listMaterials as $listMaterial)
                    <div class="col-12 mb-3">
                        <div style="display: flex; align-items: center;">
                            <img src="{{ asset('storage/' . $listMaterial->image) }}"
                                style="height: 100px; width: 150px; object-fit: cover;" class="img-fluid mx-3 img-thumbnail">
                            <div>
                                <p>{{ $listMaterial->material->nama }} x {{ $listMaterial->count }} Pcs =
                                   Rp.{{ $listMaterial->material->harga * $listMaterial->count }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Dokumentasi Setelah Perbaikan</label>
                <div class="row">
                    @foreach ($docAfters as $docAfter)
                    <img src="{{ asset('storage/' . $docAfter->image) }}" style="height: 150px; object-fit: cover;"
                        class="img-fluid mx-3 mb-3 col-4 img-thumbnail">
                    @endforeach
                </div>
            </div>


    </div>
</div>
</div>
@endsection