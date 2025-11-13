@extends("layouts.master")

@section('title', 'Seputar Tanya Jawab')

@section('content')
  <div class="col-md-12">
    <a href="{{ route('questions.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Create Question
    </a>
  </div>

@endsection