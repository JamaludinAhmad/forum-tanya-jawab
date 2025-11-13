@extends('layouts.master')

@section('title', 'Kategori Baru')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
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
                required
              >
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

