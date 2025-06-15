@extends('teacher.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manajemen Tugas - {{ $classRoom->name }}</h1>
                <a href="{{ route('teacher.classes.show', $classRoom->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Kelas
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

            <!-- Add Assignment Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus"></i> Tambah Tugas Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.assignments.store', $classRoom->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Tugas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Tanggal Pengumpulan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="attachment" class="form-label">File Lampiran (Opsional)</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" name="attachment" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                            <div class="form-text">Format: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG. Maksimal 5MB</div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Tugas
                        </button>
                    </form>
                </div>
            </div>

            <!-- Assignments List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Daftar Tugas ({{ $assignments->count() }} tugas)
                    </h5>
                </div>
                <div class="card-body">
                    @if($assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Tugas</th>
                                        <th>Tanggal Pengumpulan</th>
                                        <th>Status</th>
                                        <th>Submissions</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $index => $assignment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $assignment->name }}</strong>
                                            @if($assignment->attachment)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-paperclip"></i> Ada lampiran
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $assignment->due_date->format('d M Y') }}
                                            @if($assignment->is_overdue)
                                                <br><small class="text-danger">Terlambat</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignment->is_overdue)
                                                <span class="badge bg-danger">Terlambat</span>
                                            @else
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('teacher.classes.assignments.show', [$classRoom->id, $assignment->id]) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                {{ $assignment->submitted_count }} submission(s)
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- View Detail -->
                                                <a href="{{ route('teacher.classes.assignments.show', [$classRoom->id, $assignment->id]) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Button -->
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                                        data-bs-target="#editModal{{ $assignment->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <!-- Delete Button -->
                                                <form action="{{ route('teacher.assignments.destroy', [$classRoom->id, $assignment->id]) }}" 
                                                      method="POST" style="display:inline;" 
                                                      onsubmit="return confirm('Yakin ingin menghapus tugas ini? Semua submission akan ikut terhapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $assignment->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Tugas: {{ $assignment->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('teacher.assignments.update', [$classRoom->id, $assignment->id]) }}" 
                                                      method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="edit_name{{ $assignment->id }}" class="form-label">Nama Tugas</label>
                                                                    <input type="text" class="form-control" 
                                                                           id="edit_name{{ $assignment->id }}" name="name" 
                                                                           value="{{ $assignment->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="edit_due_date{{ $assignment->id }}" class="form-label">Tanggal Pengumpulan</label>
                                                                    <input type="date" class="form-control" 
                                                                           id="edit_due_date{{ $assignment->id }}" name="due_date" 
                                                                           value="{{ $assignment->due_date->format('Y-m-d') }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="edit_description{{ $assignment->id }}" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" 
                                                                      id="edit_description{{ $assignment->id }}" name="description" 
                                                                      rows="4" required>{{ $assignment->description }}</textarea>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="edit_attachment{{ $assignment->id }}" class="form-label">File Lampiran</label>
                                                            @if($assignment->attachment)
                                                                <div class="mb-2">
                                                                    <small class="text-muted">File saat ini: </small>
                                                                    <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-primary">
                                                                        {{ basename($assignment->attachment) }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <input type="file" class="form-control" 
                                                                   id="edit_attachment{{ $assignment->id }}" name="attachment">
                                                            <div class="form-text">Kosongkan jika tidak ingin mengubah file</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Perbarui Tugas</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada tugas</h5>
                            <p class="text-muted">Silakan tambahkan tugas baru untuk kelas ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection