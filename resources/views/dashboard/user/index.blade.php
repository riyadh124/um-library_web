@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Users</h1>
  </div>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  
  {{-- @dd($workorders) --}}
  
  <div class="table-responsive small col-lg-12">
    <a href="/dashboard/user/create" class="btn btn-primary mb-3">Create New User</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Avatar</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Jabatan</th>
                <th scope="col">KTM</th>
                <th scope="col">NIM</th>
                <th scope="col">No Telepon</th>
                <th scope="col">Terverifikasi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="Avatar" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;">
                    @else
                    No Avatar
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->ktm }}</td>
                <td>{{ $user->nim }}</td>
                <td>{{ $user->no_telepon }}</td>
                <td>   
                    @if ($user->is_confirmed)
                    Terverifkasi
                    @else
                    Tidak Terverifikasi
                    @endif
                </td>
                <td>
                    @if (!$user->is_confirmed)
                    <form action="/dashboard/user/{{ $user->id }}/confirm" method="POST" class="d-inline">
                        @method('put')
                        @csrf
                        <button type="submit" class="badge bg-success border-0" onclick="return confirm('Are you sure?')"> 
                            Verifikasi
                        </button>
                    </form>
                    @endif
                    <form action="/dashboard/user/{{ $user->id }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"> 
                            <i class="bi bi-trash-fill"  style="font-size: 15px"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection