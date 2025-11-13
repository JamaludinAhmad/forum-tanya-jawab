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
</div>


@endsection