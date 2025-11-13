@extends('layouts.master')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container mt-4">
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Biodata</h3>
        </div>
        <div class="card-body">
          <p><strong>Nama:</strong> {{ $user->name }}</p>
          <p><strong>Email:</strong> {{ $user->email }}</p>
          <p><strong>Umur:</strong> {{ $user->umur ?? '-' }}</p>
          <p><strong>Alamat:</strong> {{ $user->alamat ?? '-' }}</p>
          <p><strong>Biodata:</strong></p>
          <p>{{ $user->biodata ?? 'Belum ada biodata.' }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Perbarui Profil</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="name">Nama</label>
              <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control @error('name') is-invalid @enderror"
                required
              >
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror"
                required
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="umur">Umur</label>
              <input
                type="number"
                id="umur"
                name="umur"
                value="{{ old('umur', $user->umur) }}"
                class="form-control @error('umur') is-invalid @enderror"
                min="0"
                max="120"
              >
              @error('umur')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input
                type="text"
                id="alamat"
                name="alamat"
                value="{{ old('alamat', $user->alamat) }}"
                class="form-control @error('alamat') is-invalid @enderror"
              >
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="biodata">Biodata</label>
              <textarea
                id="biodata"
                name="biodata"
                class="form-control @error('biodata') is-invalid @enderror"
                rows="4"
              >{{ old('biodata', $user->biodata) }}</textarea>
              @error('biodata')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">Kata Sandi Baru</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah kata sandi.</small>
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Kata Sandi</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
              >
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

