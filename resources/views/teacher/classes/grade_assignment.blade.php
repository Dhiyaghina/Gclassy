@extends('teacher.layout')

@section('content')
<div class="container">
    <h2>Penilaian Tugas</h2>

    <h4>Tugas: {{ $task->title }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Folder Tugas</th>
                <th>Tugas yang Diunggah</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->student->name }}</td>
                <td>{{ $assignment->folder_path }}</td>
                <td><a href="{{ Storage::url($assignment->file_path) }}" target="_blank">Lihat Tugas</a></td>
                <td>
                    <form action="{{ route('assignments.grade', $assignment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="nilai" value="{{ $assignment->nilai }}" min="0" max="100" class="form-control" required>
                        <button type="submit" class="btn btn-success">Berikan Nilai</button>
                    </form>
                </td>
                <td>
                    <!-- Aksi lainnya jika perlu -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
