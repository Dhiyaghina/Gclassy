@extends('teacher.layout')

@section('title', 'Buat Tugas - ' . $classRoom->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ $classRoom->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $classRoom->subject }}</p>
            <div class="nav nav-pills nav-fill">
                <a class="nav-link active" aria-current="page" href="{{ route('teacher.classes.show', ['classRoom' => $classRoom->id]) }}">Informasi</a>
                <a class="nav-link" href="{{ route('teacher.tasks.index', ['classRoom' => $classRoom->id]) }}">Materi</a>
                <a class="nav-link" href="{{ route('teacher.classes.assignments.index', ['classRoom' => $classRoom->id]) }}">Tugas</a> 
                <a class="nav-link" href="{{ route('teacher.classes.orang', ['classRoom'=>$classRoom->id]) }}">Orang</a>
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

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!--CARD TAMBAH TUGAS -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Tambah Tugas Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.assignments.store', $classRoom->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-tag me-1"></i>Nama Tugas 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required 
                                           placeholder="Masukkan nama tugas">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1"></i>Tanggal Pengumpulan 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                <i class="fas fa-align-left me-1"></i>Deskripsi 
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required 
                                      placeholder="Masukkan deskripsi tugas">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="attachment" class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-1"></i>File Lampiran (Opsional)
                            </label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" name="attachment" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG. Maksimal 5MB
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>


            <!--CARD DAFTAR TUGAS -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-list-ul text-primary me-2"></i>
                        Daftar Tugas
                        <span class="badge bg-primary ms-2">{{ $assignments->count() }} tugas</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="25%">
                                            <i class="fas fa-tasks me-1"></i>Nama Tugas
                                        </th>
                                        <th width="15%">
                                            <i class="fas fa-calendar me-1"></i>Tanggal Pengumpulan
                                        </th>
                                        <th width="10%" class="text-center">
                                            <i class="fas fa-flag me-1"></i>Status
                                        </th>
                                        <th width="15%" class="text-center">
                                            <i class="fas fa-paper-plane me-1"></i>Submissions
                                        </th>
                                        <th width="30%" class="text-center">
                                            <i class="fas fa-cogs me-1"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $index => $assignment)
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-dark">{{ $assignment->name }}</strong>
                                                @if($assignment->attachment)
                                                    <small class="text-muted mt-1">
                                                        <i class="fas fa-paperclip text-primary"></i> Ada lampiran
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $assignment->due_date->format('d M Y') }}</span>
                                                @if($assignment->is_overdue)
                                                    <small class="text-danger fw-semibold">
                                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($assignment->is_overdue)
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i>Terlambat
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('teacher.classes.assignments.show', [$classRoom->id, $assignment->id]) }}" 
                                               class="btn btn-outline-info">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ $assignment->submitted_count }} submission(s)
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Assignment actions">
                                                <!-- View Detail Button -->
                                                <a href="{{ route('teacher.classes.assignments.show', [$classRoom->id, $assignment->id]) }}" 
                                                   class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Button -->
                                                <button class="btn btn-outline-warning" data-bs-toggle="modal" 
                                                        data-bs-target="#editModal{{ $assignment->id }}" title="Edit Tugas">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <!-- Delete Button -->
                                                <form action="{{ route('teacher.assignments.destroy', [$classRoom->id, $assignment->id]) }}" 
                                                      method="POST" style="display:inline;" 
                                                      onsubmit="return confirm('Yakin ingin menghapus tugas ini? Semua submission akan ikut terhapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus Tugas">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $assignment->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $assignment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="editModalLabel{{ $assignment->id }}">
                                                        <i class="fas fa-edit text-primary me-2"></i>
                                                        Edit Tugas: {{ $assignment->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('teacher.assignments.update', [$classRoom->id, $assignment->id]) }}" 
                                                      method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="edit_name{{ $assignment->id }}" class="form-label fw-semibold">
                                                                        <i class="fas fa-tag me-1"></i>Nama Tugas
                                                                    </label>
                                                                    <input type="text" class="form-control" 
                                                                           id="edit_name{{ $assignment->id }}" name="name" 
                                                                           value="{{ $assignment->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="edit_due_date{{ $assignment->id }}" class="form-label fw-semibold">
                                                                        <i class="fas fa-calendar-alt me-1"></i>Tanggal Pengumpulan
                                                                    </label>
                                                                    <input type="date" class="form-control" 
                                                                           id="edit_due_date{{ $assignment->id }}" name="due_date" 
                                                                           value="{{ $assignment->due_date->format('Y-m-d') }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="edit_description{{ $assignment->id }}" class="form-label fw-semibold">
                                                                <i class="fas fa-align-left me-1"></i>Deskripsi
                                                            </label>
                                                            <textarea class="form-control" 
                                                                      id="edit_description{{ $assignment->id }}" name="description" 
                                                                      rows="4" required>{{ $assignment->description }}</textarea>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="edit_attachment{{ $assignment->id }}" class="form-label fw-semibold">
                                                                <i class="fas fa-paperclip me-1"></i>File Lampiran
                                                            </label>
                                                            @if($assignment->attachment)
                                                                <div class="mb-2 p-2 bg-light rounded">
                                                                    <small class="text-muted">File saat ini: </small>
                                                                    <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-primary text-decoration-none">
                                                                        <i class="fas fa-download me-1"></i>{{ basename($assignment->attachment) }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <input type="file" class="form-control" 
                                                                   id="edit_attachment{{ $assignment->id }}" name="attachment" 
                                                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                                                            <div class="form-text">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Kosongkan jika tidak ingin mengubah file
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-2"></i>Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save me-2"></i>Perbarui Tugas
                                                        </button>
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
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Belum ada tugas</h5>
                            <p class="text-muted">Silakan tambahkan tugas baru untuk kelas ini menggunakan form di atas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection