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
      <p>{{ $question->body }}</p>
    </div>
  </div>

  <h3 class="mb-3">Jawaban</h3>
  
  @forelse($question->answers as $answer)
    <div class="card mb-3">
      <div class="card-body">
        <div class="text-muted small mb-2">
          <strong>{{ $answer->users->name }}</strong>
        </div>
        <p>{{ $answer->text }}</p>
      </div>
    </div>
  @empty
    <p class="text-muted">Belum ada jawaban.</p>
  @endforelse

  <div class="card mt-4">
    <div class="card-body">
      <h5>Buat Jawaban</h5>
      <form method="POST">
        @csrf
        <textarea class="form-control" name="content" rows="4" placeholder="Tulis jawaban Anda..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim Jawaban</button>
      </form>
    </div>
  </div>
</div>
@endsection