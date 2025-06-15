@extends('teacher.layout')

@section('title', 'Materi - ' . $classRoom->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ $classRoom->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $classRoom->subject }}</p>
            <div class="nav nav-pills nav-fill">
                <a class="nav-link active" aria-current="page" href="{{ route('teacher.classes.show', ['classRoom' => $classRoom->id]) }}">Forum</a>
                <a class="nav-link" href="{{ route('teacher.tasks.index', ['classRoom' => $classRoom->id]) }}">Materi</a>
                <a class="nav-link" href="#">Tugas</a>
                <a class="nav-link" href="{{ route('teacher.classes.orang', ['classRoom'=>$classRoom->id]) }}">Orang</a>
                <a class="nav-link" href="#">Nilai</a>
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
<div class="container py-4">

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Tambah Materi -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold text-primary mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Materi Baru
                    </h5>
                    <small class="text-muted">Masukkan detail materi pembelajaran yang ingin ditambahkan</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teacher.tasks.store', ['classRoom' => $classRoom->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-heading me-1"></i>
                                    Judul Materi
                                </label>
                                <br>
                                <input type="text" name="title" placeholder="Masukkan judul materi..." required 
                                       class="form-control form-control-lg rounded-3 border-light shadow-sm">
                                @error('title')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Isi Materi
                                </label>
                                <br>
                                <textarea name="content" placeholder="Masukkan konten materi pembelajaran..." required 
                                          class="form-control rounded-3 border-light shadow-sm" rows="6"></textarea>
                                @error('content')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-paperclip me-1"></i>
                                    Lampiran (Opsional)
                                </label>
                                <input type="file" name="attachment" 
                                       class="form-control rounded-3 border-light shadow-sm">
                                       <br>
                                <small class="form-text text-muted mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, gambar
                                </small>
                                @error('attachment')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 px-4 shadow-sm">
                                    <i class="fas fa-plus me-2"></i>
                                    Tambah Materi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<br>
    <!-- Daftar Materi -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-list me-2"></i>
                    Daftar Materi Pembelajaran
                </h5>
                <span class="badge bg-primary rounded-pill">{{ count($tasks) }} materi</span>
            </div>

            @if(count($tasks) > 0)
                <div class="row">
                    @foreach($tasks as $task)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 material-card">
                                <div class="card-body p-4">
                                    <div>
                                                <h6 class="fw-bold text-dark mb-1">{{ $task->title }}</h6>
                                                <h2 class="text-muted mb-0 content-preview">
                                                    {{ Str::limit($task->content, 100) }}
                                                </h2>
                                                <small class="text-muted">
                                                    Diposting {{ $task->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        
                                        
                                        <!-- Dropdown Menu -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                                                <li>
                                                    <button class="dropdown-item" onclick="toggleEditForm({{ $task->id }})">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="{{ route('teacher.tasks.destroy', [$classRoom, $task]) }}" method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                                @if($task->attachment)
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank" 
                                                           class="dropdown-item">
                                                            <i class="fas fa-download me-2"></i>Unduh Lampiran
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Preview Konten -->
                                    <div class="mb-3">
                                        @if($task->attachment)
                                            <div class="attachment-preview bg-light rounded-3 p-3 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-paperclip text-muted me-2"></i>
                                                    <span class="text-muted small">Lampiran tersedia</span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>

                                <!-- Form Edit (Hidden by default) -->
                                <div id="editForm{{ $task->id }}" class="edit-form border-top" style="display: none;">
                                    <div class="p-4 bg-light bg-opacity-50">
                                        <h6 class="fw-semibold text-dark mb-3">
                                            <i class="fas fa-edit me-2"></i>
                                            Edit Materi
                                        </h6>
                                        
                                        <form action="{{ route('teacher.tasks.update', [$classRoom, $task]) }}" method="POST" 
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Judul Materi</label>
                                                <input type="text" name="title" value="{{ $task->title }}" 
                                                       class="form-control rounded-3 border-light">
                                                @error('title')
                                                    <div class="alert alert-danger mt-2 rounded-3">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Isi Materi</label>
                                                <textarea name="content" class="form-control rounded-3 border-light" 
                                                          rows="4">{{ $task->content }}</textarea>
                                                @error('content')
                                                    <div class="alert alert-danger mt-2 rounded-3">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Lampiran Baru</label>
                                                <input type="file" name="attachment" 
                                                       class="form-control rounded-3 border-light">
                                                @error('attachment')
                                                    <div class="alert alert-danger mt-2 rounded-3">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-success btn-sm rounded-3 flex-fill">
                                                    <i class="fas fa-save me-1"></i>
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm rounded-3" 
                                                        onclick="toggleEditForm({{ $task->id }})">
                                                    <i class="fas fa-times me-1"></i>
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Materi</h5>
                        <p class="text-muted">Tambahkan materi pembelajaran pertama Anda menggunakan form di atas.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal untuk Detail Materi -->
    <div class="modal fade" id="materialDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 bg-primary bg-opacity-10">
                    <h5 class="modal-title fw-bold" id="materialDetailTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="materialDetailContent"></div>
                    <div id="materialDetailAttachment"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS untuk styling tambahan --}}
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.material-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.material-avatar {
    width: 50px;
    height: 50px;
    font-size: 1.2rem;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(15, 47, 190, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.alert {
    border: none;
}

.dropdown-menu {
    border: 1px solid rgba(0,0,0,0.1);
    min-width: 150px;
}

.dropdown-item {
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.content-preview {
    font-size: 0.9rem;
    line-height: 1.5;
}

.attachment-preview {
    border-left: 4px solid #667eea;
}

.edit-form {
    background: rgba(102, 126, 234, 0.03);
}

@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
    
    .material-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}
</style>

{{-- JavaScript untuk fungsi edit dan detail --}}
<script>
function toggleEditForm(taskId) {
    const editForm = document.getElementById('editForm' + taskId);
    if (editForm.style.display === 'none' || editForm.style.display === '') {
        editForm.style.display = 'block';
        editForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        editForm.style.display = 'none';
    }
}

function showMaterialDetail(taskId) {
    // Data materi (dalam implementasi nyata, ini bisa diambil via AJAX)
    const materials = @json($tasks);
    const material = materials.find(item => item.id === taskId);
    
    if (material) {
        document.getElementById('materialDetailTitle').textContent = material.title;
        document.getElementById('materialDetailContent').innerHTML = `
            <div class="mb-3">
                <h6 class="fw-semibold">Konten Materi:</h6>
                <p class="text-muted">${material.content}</p>
            </div>
            <div class="mb-3">
                <small class="text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Dibuat: ${new Date(material.created_at).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}
                </small>
            </div>
        `;
        
        const attachmentDiv = document.getElementById('materialDetailAttachment');
        if (material.attachment) {
            attachmentDiv.innerHTML = `
                <div class="border-top pt-3">
                    <h6 class="fw-semibold">Lampiran:</h6>
                    <a href="/storage/${material.attachment}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download me-1"></i>
                        Unduh Lampiran
                    </a>
                </div>
            `;
        } else {
            attachmentDiv.innerHTML = '';
        }
        
        const modal = new bootstrap.Modal(document.getElementById('materialDetailModal'));
        modal.show();
    }
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });
});
</script>
@endsection