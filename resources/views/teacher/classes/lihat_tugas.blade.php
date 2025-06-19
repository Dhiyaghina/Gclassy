@extends('teacher.layout')

@section('title', 'Buat Tugas - ' . $classRoom->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ $classRoom->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $classRoom->subject }}</p>
            <div class="hidden space-x-8 sm:-my-px sm:ml-4 sm:flex">
                <x-nav-link : href="{{ route('teacher.classes.show', ['classRoom' => $classRoom->id]) }}">Informasi</x-nav-link>
                <x-nav-link : href="{{ route('teacher.tasks.index', ['classRoom' => $classRoom->id]) }}">Materi</x-nav-link>
                <x-nav-link : href="{{ route('teacher.classes.assignments.index', ['classRoom' => $classRoom->id]) }}">Tugas</x-nav-link> 
                <x-nav-link : href="{{ route('teacher.classes.orang', ['classRoom'=>$classRoom->id]) }}">Orang</x-nav-link>
            </div>
        </div>        
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $classRoom->type === 'reguler' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ ucfirst($classRoom->type) }}
            </span>
        </div>
        
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <a href="{{ route('teacher.classes.assignments.index', $classRoom->id) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-black border border-black hover:bg-gray-400">
                            &laquo; Kembali </a>
                        <h3 class="text-2xl font-bold text-gray-800">Tugas {{ $assignment->name }}</h3>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Assignment Info -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <dl class="row">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-heading me-1"></i>
                                    Kelas: {{ $assignment->classRoom->name }}
                                </label>
                                <br>
                                <label class="form-label fw-semibold text-dark">
                                    Tenggat Pengumpulan: {{ $assignment->due_date->format('d M Y') }}
                                    @if($assignment->is_overdue)
                                        <span class="badge bg-danger ms-2 text-sm font-medium text-red-900">(Lewat Tenggat)</span>
                                    @else
                                        <span class="badge bg-success ms-2">(Belum Tenggat)</span>
                                    @endif
                                    </label>
                                <br>
                                <label class="form-label fw-semibold text-dark">Dibuat: {{ $assignment->created_at->format('d M Y H:i') }}</label>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar"></i> Statistik
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="column text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-primary">{{ $assignment->submissions->count() }}</h3>
                                        <small class="text-muted">Total Submission</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-success">{{ $assignment->submissions->whereNotNull('grade')->count() }}</h3>
                                    <small class="text-muted">Sudah Dinilai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Submissions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-upload"></i> Pengumpulan ({{ $assignment->submissions->count() }})
                    </h5>
                </div>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                    @if($assignment->submissions->count() > 0)
                        <div class="table-responsive">
                            <!-- <table class="table table-hover"> -->
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Pengumpulan</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($assignment->submissions as $index => $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $index + 1 }}</div></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->submitted_at)
                                                {{ $submission->submitted_at->format('d M Y H:i') }}
                                                @if($submission->submitted_at > $assignment->due_date)
                                                    <br><small class="text-danger text-red-900">{{ $submission->updated_at }} (Terlambat)</small>
                                                @endif
                                            @else
                                                <span class="text-muted">{{ $submission->updated_at }} </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->file_path)
                                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-eye"></i> Lihat Tugas
                                                </a>
                                                <!-- <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-download"></i> Unduh
                                                </a> -->
                                            @endif
                                            @if($submission->submission_text)
                                                <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#textModal{{ $submission->id }}">
                                                    <i class="fas fa-eye"></i> Lihat Teks
                                                </button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('teacher.submissions.grade', $submission->id) }}" method="POST">
                                                @csrf
                                                <input type="number"
                                                    name="grade"
                                                    value="{{ $submission->grade }}"
                                                    min="0"
                                                    max="100"
                                                    class="w-16 border-b-2 border-blue-500 focus:outline-none text-center"
                                                    placeholder="0" />
                                                <span class="text-gray-500">/100</span>
                                                <input type="hidden" name="feedback" value="{{ $submission->feedback }}">
                                            </form>
                                        </td>


                                        <!-- <td>
                                            @if($submission->submitted_at)
                                                @if($submission->submitted_at > $assignment->due_date)
                                                    <span class="badge bg-warning">Terlambat</span>
                                                @else
                                                    <span class="badge bg-success">Tepat Waktu</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger">Belum Dikumpulkan</span>
                                            @endif
                                        </td> -->
                                        <!-- <td>
                                            @if($submission->submitted_at)
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $submission->id }}">
                                                    <i class="fas fa-star"></i> 
                                                    {{ $submission->grade ? 'Edit Nilai' : 'Beri Nilai' }}
                                                </button>
                                            @endif
                                        </td> -->
                                    </tr>

                                    <!-- Text Modal (jika ada submission text) -->
                                    @if($submission->submission_text)
                                    <div class="modal fade" id="textModal{{ $submission->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Teks Submission - {{ $submission->student->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="border p-3 bg-light">
                                                        {{ $submission->submission_text }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Grade Modal -->
                                    @if($submission->submitted_at)
                                    <div class="modal fade" id="gradeModal{{ $submission->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Beri Nilai - {{ $submission->student->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('teacher.submissions.grade', $submission->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="grade{{ $submission->id }}" class="form-label">Nilai (0-100)</label>
                                                            <input type="number" class="form-control" 
                                                                   id="grade{{ $submission->id }}" name="grade" 
                                                                   min="0" max="100" 
                                                                   value="{{ $submission->grade }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="feedback{{ $submission->id }}" class="form-label">Feedback (Opsional)</label>
                                                            <textarea class="form-control" 
                                                                      id="feedback{{ $submission->id }}" name="feedback" 
                                                                      rows="3">{{ $submission->feedback }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                                    </div>
                                                </form>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada submission</h5>
                            <p class="text-muted">Siswa belum ada yang mengumpulkan tugas ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </table>
    </div>
</div>
<script>
    document.querySelectorAll('input[name="grade"]').forEach(input => {
        input.addEventListener('change', function () {
            this.form.submit();
        });
    });
</script>

@endsection