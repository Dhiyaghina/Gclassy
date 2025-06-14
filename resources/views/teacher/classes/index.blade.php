@extends('teacher.layout')

@section('title', 'Tugas Kelas - ' . $classRoom->name)

@section('content')
<div class="grid grid-cols-3 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <!-- Informasi Kelas -->
        <h3 class="text-lg font-medium">Informasi Kelas</h3>
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
                <h4 class="text-sm font-medium text-gray-900">{{ $classRoom->name }}</h4>
                <p class="text-xs text-gray-500">{{ $classRoom->subject }}</p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <!-- Form untuk membuat materi baru -->
        <button class="bg-green-600 text-white px-4 py-2 rounded-md" id="createTaskBtn">Buat Materi</button>

        <!-- Daftar Materi -->
        @foreach($classRoom->tasks as $task)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                <p class="text-xs text-gray-500">{{ $task->created_at->diffForHumans() }}</p>
                <p class="mt-2 text-sm text-gray-900">{{ $task->content }}</p>
                @if($task->attachment)
                    <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank" class="text-blue-600">Lihat Lampiran</a>
                @endif

                <!-- Tombol Edit dan Hapus -->
                <button class="bg-yellow-500 text-white px-3 py-1 rounded-md" onclick="editTask({{ $task->id }})">Edit</button>
                <button class="bg-red-600 text-white px-3 py-1 rounded-md" onclick="deleteTask({{ $task->id }})">Hapus</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal untuk Create / Edit -->
<div id="taskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h3 class="text-lg font-medium mb-4" id="modalTitle">Buat Materi Baru</h3>
        <form id="taskForm" action="{{ route('tasks.store', $classRoom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="taskId" id="taskId">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Materi</label>
                <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Konten Materi</label>
                <textarea name="content" id="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="attachment" class="block text-sm font-medium text-gray-700">Lampiran (Opsional)</label>
                <input type="file" name="attachment" id="attachment" class="w-full px-3 py-2 border border-gray-300 rounded-md" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
            </div>
            <div class="flex justify-end">
                <button type="submit" id="submitTaskBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
        <button class="absolute top-2 right-2 text-gray-500" onclick="closeModal()">X</button>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
// Menampilkan modal untuk create
document.getElementById('createTaskBtn').addEventListener('click', function() {
    document.getElementById('taskModal').classList.remove('hidden');
    document.getElementById('taskForm').action = "{{ route('tasks.store', $classRoom->id) }}";
    document.getElementById('modalTitle').textContent = "Buat Materi Baru";
    document.getElementById('taskId').value = ''; // Reset taskId
    document.getElementById('submitTaskBtn').textContent = "Simpan";
});

// Menutup modal
function closeModal() {
    document.getElementById('taskModal').classList.add('hidden');
}

// Menampilkan modal untuk edit
function editTask(taskId) {
    fetch(`/tasks/${taskId}/edit`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('taskModal').classList.remove('hidden');
        document.getElementById('taskForm').action = `/tasks/${taskId}`;
        document.getElementById('modalTitle').textContent = "Edit Materi";
        document.getElementById('title').value = data.title;
        document.getElementById('content').value = data.content;
        document.getElementById('taskId').value = taskId;
        document.getElementById('submitTaskBtn').textContent = "Update";
    });
}

// Menghapus materi
function deleteTask(taskId) {
    Swal.fire({
        title: 'Yakin ingin menghapus materi ini?',
        text: "Tindakan ini tidak bisa dibatalkan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            }).then(response => response.json())
              .then(data => {
                  Swal.fire('Dihapus!', 'Materi berhasil dihapus.', 'success');
                  location.reload();
              });
        }
    });
}
</script>
@endsection
