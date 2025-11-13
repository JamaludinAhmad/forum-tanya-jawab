@extends("layouts.master")

@section('title', 'Daftar Pertanyaan')

@section('content')
<div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Pertanyaan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Pertanyaan</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Pertanyaan Saya</h3>
              <div class="card-tools">
                <a href="{{ route('questions.create') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus"></i> Buat Pertanyaan
                </a>
              </div>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th style="width:40px">#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th style="width:120px">Jawaban</th>
                    <th style="width:140px">Dibuat</th>
                    <th style="width:140px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($questions as $question)
                    <tr>
                      <td>{{ $loop->iteration + ($questions->currentPage()-1) * $questions->perPage() }}</td>
                      <td><a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a></td>
                      @forelse($question->categories as $category)
                        <td>
                          <span class="badge bg-info">{{ $category->name }}</span>
                        </td>
                      @empty
                        <td><span class="badge bg-secondary">-</span></td>
                      @endforelse
                      <td>{{ $question->answers_count ?? $question->answers->count() }}</td>
                      <td>{{ $question->created_at->diffForHumans() }}</td>
                      <td>
                        <a href="{{ route('questions.show', $question) }}" class="btn btn-l btn-info" title="Lihat"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-l btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pertanyaan ini?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-l btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">Belum ada pertanyaan.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="card-footer clearfix">
              {{ $questions->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection