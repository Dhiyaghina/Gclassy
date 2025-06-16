@extends('teacher.layout')


@section('content')
<div class="container">
    <h2>Materi Kelas: {{ $classRoom->name }}</h2>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah Materi --}}
    <form action="{{ route('teacher.tasks.store', ['classRoom' => $classRoom->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Judul Materi" required class="form-control mb-2">
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <textarea name="content" placeholder="Isi Materi" required class="form-control mb-2"></textarea>
        @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="file" name="attachment" class="form-control mb-2">
        @error('attachment')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary">Tambah Materi</button>
    </form>

    <hr>

    {{-- Daftar Materi --}}
    @foreach($tasks as $task)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>{{ $task->title }}</strong>
                <form action="{{ route('teacher.tasks.destroy', [$classRoom, $task]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
            <div class="card-body">
                <p>{{ $task->content }}</p>
                @if($task->attachment)
                    <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">Lihat Lampiran</a>
                @endif

                {{-- Form Edit --}}
                <form action="{{ route('teacher.tasks.update', [$classRoom, $task]) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" value="{{ $task->title }}" class="form-control mb-2">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <textarea name="content" class="form-control mb-2">{{ $task->content }}</textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <input type="file" name="attachment" class="form-control mb-2">
                    @error('attachment')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
