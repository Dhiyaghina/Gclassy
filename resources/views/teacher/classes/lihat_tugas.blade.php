@extends('teacher.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Tugas: {{ $assignment->name }}</h1>
                <a href="{{ route('teacher.classes.assignments.index', $classRoom->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tugas
                </a>
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
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Informasi Tugas
                            </h5>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">Nama Tugas:</dt>
                                <dd class="col-sm-9">{{ $assignment->name }}</dd>
                                
                                <dt class="col-sm-3">Kelas:</dt>
                                <dd class="col-sm-9">{{ $assignment->classRoom->name }}</dd>
                                
                                <dt class="col-sm-3">Tanggal Pengumpulan:</dt>
                                <dd class="col-sm-9">
                                    {{ $assignment->due_date->format('d M Y') }}
                                    @if($assignment->is_overdue)
                                        <span class="badge bg-danger ms-2">Terlambat</span>
                                    @else
                                        <span class="badge bg-success ms-2">Aktif</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-3">Deskripsi:</dt>
                                <dd class="col-sm-9">{{ $assignment->description }}</dd>
                                
                                @if($assignment->attachment)
                                <dt class="col-sm-3">Lampiran:</dt>
                                <dd class="col-sm-9">
                                    <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Unduh Lampiran
                                    </a>
                                </dd>
                                @endif
                                
                                <dt class="col-sm-3">Dibuat:</dt>
                                <dd class="col-sm-9">{{ $assignment->created_at->format('d M Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar"></i> Statistik
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
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
                </div>
            </div>

            <!-- Submissions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-upload"></i> Submissions ({{ $assignment->submissions->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($assignment->submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Waktu Pengumpulan</th>
                                        <th>File</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignment->submissions as $index => $submission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $submission->student->name }}</strong>
                                            <br><small class="text-muted">{{ $submission->student->email }}</small>
                                        </td>
                                        <td>
                                            @if($submission->submitted_at)
                                                {{ $submission->submitted_at->format('d M Y H:i') }}
                                                @if($submission->submitted_at > $assignment->due_date)
                                                    <br><small class="text-danger">Terlambat</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Belum dikumpulkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->file_path)
                                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-download"></i> Unduh
                                                </a>
                                            @endif
                                            @if($submission->submission_text)
                                                <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#textModal{{ $submission->id }}">
                                                    <i class="fas fa-eye"></i> Lihat Teks
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->grade)
                                                <span class="badge bg-success">{{ $submission->grade }}</span>
                                            @else
                                                <span class="badge bg-secondary">Belum dinilai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->submitted_at)
                                                @if($submission->submitted_at > $assignment->due_date)
                                                    <span class="badge bg-warning">Terlambat</span>
                                                @else
                                                    <span class="badge bg-success">Tepat Waktu</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger">Belum Dikumpulkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->submitted_at)
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $submission->id }}">
                                                    <i class="fas fa-star"></i> 
                                                    {{ $submission->grade ? 'Edit Nilai' : 'Beri Nilai' }}
                                                </button>
                                            @endif
                                        </td>
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
                                            </div>
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
@endsection