@extends("layouts.master")

@section('title', 'Detail Pertanyaan')

@section('content')
<div class="container mt-4">
  <div class="card mb-4">
    <div class="card-body">
      <h4>{{ $question->title }}</h4>
      <div class="text-muted small mb-3">
        <span>Dibuat oleh: <strong>{{ $question->users->name }}</strong></span> </br>
        <span class="ms-3">Tanggal: <strong>{{ $question->created_at->format('d M Y H:i') }}</strong></span>
      </div>
      <div class="mb-3">
        @forelse($question->categories as $category)
          <span class="badge bg-info mr-1">{{ $category->name }}</span>
        @empty
          <span class="badge bg-secondary">Tanpa kategori</span>
        @endforelse
      </div>
      @if($question->image_url)
        <div class="mb-3">
          <img src="{{ asset('storage/' . $question->image_url) }}" alt="Gambar pertanyaan" class="img-fluid rounded">
        </div>
      @endif
      <div id='summernote'>{!! $question->body !!}</div>
    </div>
  </div>

  <h3 class="mb-3">Jawaban</h3>
  
  @forelse($question->answers as $answer)
    <div class="card mb-3">
      <div class="card-body" id="answer-view-{{ $answer->id }}">
        <div class="text-muted small mb-2">
          <strong>{{ $answer->user->name }}</strong>
        </div>
        <p>{{ $answer->text }}</p>
        @can('update-answer', $answer)
          <button onclick="toggleEdit({{ $answer->id }})" class="btn btn-sm btn-warning me-2">Edit</button>
        @endcan
        @can('delete-answer', $answer)
          <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
          </form>
        @endcan
      </div>

      @can('update-answer', $answer)
        <div id="answer-edit-{{ $answer->id }}" style="display: none;" class="card-body">
            <form action="{{ route('answers.update', $answer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="text-{{ $answer->id }}">Edit Jawaban:</label>
                    <textarea name="text" id="text-{{ $answer->id }}" rows="5" class="form-control" style="width: 100%" required>{{ old('text', $answer->text) }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Perbarui Jawaban</button>
                <button type="button" onclick="toggleEdit({{ $answer->id }})" class="btn btn-secondary">Batal</button>
            </form>
        </div>
      @endcan
    </div>
  @empty
    <p class="text-muted">Belum ada jawaban.</p>
  @endforelse

  <div class="card mt-4">
    <div class="card-body">
      <h5>Buat Jawaban</h5>
      <form method="POST" action="{{ route('answers.store',  $question->id) }}">
        @csrf
        <textarea class="form-control" name="text" id="text" rows="4" placeholder="Tulis jawaban Anda..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim Jawaban</button>
      </form>
    </div>
  </div>
</div>

<script>
    function toggleEdit(answerId) {
        // Ambil elemen view dan edit
        var viewBlock = document.getElementById('answer-view-' + answerId);
        var editBlock = document.getElementById('answer-edit-' + answerId);

        if (!viewBlock || !editBlock) {
            return;
        }

        // Gunakan computed style untuk memeriksa apakah view terlihat
        var viewVisible = window.getComputedStyle(viewBlock).display !== 'none';

        if (viewVisible) {
            // sembunyikan view & tampilkan form edit (edit adalah sibling)
            viewBlock.style.display = 'none';
            editBlock.style.display = 'block';
        } else {
            // tampilkan view & sembunyikan edit
            viewBlock.style.display = 'block';
            editBlock.style.display = 'none';
        }
    }

</script>
@endsection
@push('scripts')

</script>
@endpush