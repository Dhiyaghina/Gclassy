@extends('teacher.layout')

@section('content')
<form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Materi</label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700">Konten Materi</label>
        <textarea name="content" id="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>{{ old('content', $task->content) }}</textarea>
    </div>

    <div class="mb-4">
        <label for="attachment" class="block text-sm font-medium text-gray-700">Lampiran (Opsional)</label>
        <input type="file" name="attachment" id="attachment" class="w-full px-3 py-2 border border-gray-300 rounded-md" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
        @if($task->attachment)
            <div class="mt-2">
                <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank" class="text-blue-600">Lihat Lampiran</a>
            </div>
        @endif
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Update Materi</button>
    </div>
</form>
@endsection
