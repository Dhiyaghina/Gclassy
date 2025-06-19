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
<div class="container py-4">

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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h3 class="text-2xl font-bold text-gray-800">
                         Tambah Tugas Baru
                        </h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teacher.assignments.store', $classRoom->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-tag me-1"></i>Nama Tugas 
                                    </label> <br>
                                    <input type="text" class="mt-1 block w-full text-sm text-gray-500
                                                            border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                            placeholder-gray-400" 
                                    id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama tugas">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1"></i>Tanggal Pengumpulan 
                                    </label> <br>
                                    <input type="date" class="form-label fw-semibold text-dark" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback  text-sm text-red-500">Tanggal yang anda pilih sudah lewat!</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">
                                <i class="fas fa-align-left me-1"></i>Deskripsi 
                            </label><br>
                            <textarea class="mt-1 block w-full text-sm text-gray-500
                                border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                placeholder-gray-400" 
                                      id="description" name="description" rows="4" required 
                                      placeholder="Masukkan deskripsi tugas">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="attachment" class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-1"></i>File Lampiran (Opsional)
                            </label>
                            <br>
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
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save me-2"></i>Simpan Tugas
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


            <!--CARD DAFTAR TUGAS -->
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h3 class="text-2xl font-bold text-gray-800"> Daftar Tugas</h3>
                    </div>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">                
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tugas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenggat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengumpulan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                             @foreach($assignments as $index => $assignment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $index + 1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $assignment->name }}
                                         <!-- @if($assignment->attachment)
                                             <small class="text-muted mt-1">
                                                <i class="fas fa-paperclip text-primary"></i> Ada lampiran
                                             </small>
                                         @endif -->
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $assignment->due_date->format('d M Y') }}</span>
                                        @if($assignment->is_overdue)
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('teacher.classes.assignments.show', [$classRoom->id, $assignment->id]) }}" 
                                               class="btn btn-outline-info">
                                                {{ $assignment->submitted_count }} Pengumpulan
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                       <div class="dropdown">
                                            <div class="flex space-x-1">
                                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="toggleEditForm({{ $assignment->id }})">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('teacher.assignments.destroy', [$classRoom, $assignment]) }}" method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 rounded">
                                                            Hapus
                                                        </button>
                                                    </form>
                                            </div>
                                        </div> 
                                    </div>
                                </td>

                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
<br>
            <!-- Untuk form editnya -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
                 <div id="editForm{{ $assignment->id }}" class="edit-form border-top mt-3" style="display: none;">
                    <div class="p-4 bg-light bg-opacity-50 rounded">
                        <h3 class="text-2xl font-bold text-gray-800">
                            Edit Tugas
                        </h3>
                        <form action="{{ route('teacher.assignments.update', [$classRoom, $assignment]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Nama Tugas</label> <br>
                                <input type="text" name="name" value="{{ $assignment->name }}" class="mt-1 block w-full text-sm text-gray-500
                                border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                placeholder-gray-400">
                                @error('name')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Deskripsi</label> <br>
                                <textarea name="description" class="mt-1 block w-full text-sm text-gray-500
                                border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                placeholder-gray-400" rows="4">{{ $assignment->description }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Tanggal Pengumpulan</label> <br>
                                <input type="date" name="due_date" value="{{ $assignment->due_date->format('Y-m-d') }}" class="form-control rounded-3 border-light">
                                @error('due_date')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Lampiran Baru</label> <br>
                                <input type="file" name="attachment" class="form-control rounded-3 border-light">
                                @error('attachment')
                                    <div class="alert alert-danger mt-2 rounded-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <br>
                                @if($assignment->attachment)
                                    <small class="text-muted">File saat ini: 
                                        <a href="{{ Storage::url($assignment->attachment) }}" target="_blank" class="text-primary text-decoration-none">
                                            {{ basename($assignment->attachment) }}
                                        </a>
                                    </small>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="toggleEditForm({{ $assignment->id }})">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                            </div>
                        </form>
                    </div>
                 </div>
                </div>
                </div>
            </div>
        </div>
@endsection

<script>
    function toggleEditForm(assignmentId) {
        const form = document.getElementById('editForm' + assignmentId);
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            form.style.display = 'none';
        }
    }
</script>
