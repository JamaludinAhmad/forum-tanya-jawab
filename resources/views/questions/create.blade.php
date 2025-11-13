@extends("layouts.master")
@section('title', 'Buat Pertanyaan Baru')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="mb-4">Buat Pertanyaan Baru</h1>
      
      <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
          <label for="title" class="form-label">Judul Pertanyaan</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" 
               id="title" name="title" value="{{ old('title') }}" required>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="body" class="form-label">Deskripsi</label>
          <textarea class="form-control @error('body') is-invalid @enderror" 
                id="body" name="body" rows="5" required>{{ old('body') }}</textarea>
          @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="category" class="form-label">Kategori</label>
          <select class="form-control @error('category_id') is-invalid @enderror" 
              id="category" name="category_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label for="image">Gambar (Opsional):</label>
          <input type="file" name="image" id="image">
        </div>
        
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Posting Pertanyaan</button>
          <a href="{{ route('questions.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection