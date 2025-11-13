@extends('layouts.master')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mt-4">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah Kategori</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Nama Kategori</label>
              <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Contoh: Laravel"
                required
              >
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Daftar Kategori</h3>
          <span class="badge badge-secondary">{{ $categories->count() }} total</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0" id="categories-table">
              <thead>
                <tr>
                  <th style="width:60px">#</th>
                  <th>Nama</th>
                  <th style="width:150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $category)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                      <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                      <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center p-3">Belum ada kategori.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(function () {
    $('#categories-table').DataTable({
      paging: true,
      searching: true,
      ordering: false,
      lengthChange: false,
      pageLength: 5,
      language: {
        search: 'Cari:',
        paginate: {
          previous: 'Sebelumnya',
          next: 'Berikutnya'
        },
        info: 'Menampilkan _START_ - _END_ dari _TOTAL_ kategori',
        infoEmpty: 'Tidak ada kategori',
        zeroRecords: 'Kategori tidak ditemukan'
      }
    });
  });
</script>
@endpush

