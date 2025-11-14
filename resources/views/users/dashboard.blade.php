@extends("layouts.master")

@section('title', 'Seputar Tanya Jawab')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="row">
  <div class="col-md-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $user->questions()->count() }}</h3>
        <p>Pertanyaan Saya</p>
      </div>
      <div class="icon">
        <i class="fas fa-question-circle"></i>
      </div>
      <a href="{{ route('questions.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-md-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $user->answers()->count() }}</h3>
        <p>Jawaban Saya</p>
      </div>
      <div class="icon">
        <i class="fas fa-comments"></i>
      </div>
      <a href="{{ route('questions.index') }}" class="small-box-footer">Kelola Pertanyaan <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="mt-3">
  <a href="{{ route('questions.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Buat Pertanyaan Baru
  </a>

  <div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">✨ 10 Pertanyaan Terbaru</h3>
    </div>
    <div class="card-body p-0">
        {{-- Memeriksa apakah ada pertanyaan sebelum looping --}}
        @if($questions->isEmpty())
            <p class="p-3 text-muted">Belum ada pertanyaan terbaru.</p>
        @else
            <ul class="list-group list-group-flush">
                @foreach($questions as $question)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">
                                <a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a>
                            </div>
                            <small class="text-muted">{{ Str::limit(strip_tags($question->content), 80) }}</small>
                            <br>
                            <small>
                                Ditanyakan oleh: **{{ $question->user->name ?? 'Pengguna Tidak Dikenal' }}** pada **{{ $question->created_at->format('d M Y') }}**
                            </small>
                        </div>
                        
                        <span class="badge bg-primary rounded-pill">{{ $question->answers->count() ?? 0 }} Jawaban</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('questions.index') }}">Lihat Semua Pertanyaan <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
  
</div>


@endsection