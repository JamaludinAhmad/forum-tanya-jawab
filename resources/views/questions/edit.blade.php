@extends("layouts.master")
@section('title', 'Edit Pertanyaan')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="mb-4">Edit Pertanyaan</h1>
      
      <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
          <label for="title" class="form-label">Judul Pertanyaan</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" 
               id="title" name="title" value="{{ old('title', $question->title) }}" required>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="body" class="form-label">Deskripsi</label>
          <textarea class="form-control @error('body') is-invalid @enderror" 
                id="body" name="body" rows="5" required>{{ old('body', $question->body) }}</textarea>
          @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="category" class="form-label">Kategori</label>
          <select
            class="form-control @error('category_ids') is-invalid @enderror"
            id="category"
            name="category_ids[]"
            multiple
            required
          >
            @php
              $selectedCategories = old('category_ids', $question->categories->pluck('id')->all());
            @endphp
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          <small class="text-muted">Pilih minimal satu kategori.</small>
          @error('category_ids')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Gambar (Opsional)</label>
          <input
            type="file"
            name="image"
            id="image"
            class="form-control @error('image') is-invalid @enderror"
            accept="image/*"
          >
          @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          @if($question->image_url)
            <div class="mt-2">
              <span class="d-block text-muted mb-1">Gambar saat ini:</span>
              <img src="{{ asset('storage/' . $question->image_url) }}" alt="Gambar pertanyaan" class="img-fluid rounded">
            </div>
          @endif
          <small class="text-muted d-block mt-2">Unggah gambar baru untuk mengganti gambar lama (maks 2MB).</small>
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

@push('scripts')
<script>
  $(function () {
    $('#body').summernote({
      height: 200,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview']]
      ]
    });
  });
</script>
@endpush