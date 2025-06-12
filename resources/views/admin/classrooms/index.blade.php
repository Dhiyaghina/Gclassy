@extends('admin.layout')

@section('content')
<div class="space-y-6">    <!-- Header -->    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Kelas</h1>
        <a href="{{ route('admin.classrooms.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Kelas Baru
        </a>
    </div>

    <!-- Classes Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">                <tr>                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Guru</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Kode Enrollment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($classRooms as $classRoom)
                <tr>                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($classRoom->name, 25) }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($classRoom->description, 30) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($classRoom->type === 'bimbel')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Bimbel
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Regular
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">                        <div class="text-sm text-gray-900">
                            {{ $classRoom->teacher ? $classRoom->teacher->user->name : 'Belum ditugaskan' }}
                        </div>
                        @if($classRoom->teacher)
                            <div class="text-sm text-gray-500">{{ $classRoom->teacher->subject }}</div>
                        @endif
                    </td>                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $classRoom->students_count }} siswa</div>                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            @if($classRoom->price)
                                Rp {{ number_format($classRoom->price, 0, ',', '.') }}                            @else
                                Gratis
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">                        @if($classRoom->type === 'reguler' && $classRoom->enrollment_code)
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-mono bg-gray-100 px-2 py-1 rounded text-gray-800">{{ $classRoom->enrollment_code }}</span>
                                <button onclick="copyToClipboard('{{ $classRoom->enrollment_code }}')" 
                                        class="text-blue-600 hover:text-blue-800 bg-blue-50 rounded-full p-1 hover:bg-blue-100" title="Salin Kode">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                    </svg>
                                </button>
                            </div>
                        @else
                            <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">                        @if($classRoom->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Tidak Aktif
                            </span>
                        @endif                    </td><td class="px-6 py-4 whitespace-nowrap text-sm font-medium">                        <div class="flex flex-row items-center justify-evenly">
                            <a href="{{ route('admin.classrooms.show', $classRoom) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 rounded-full p-2 hover:bg-blue-100" title="Lihat">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.classrooms.edit', $classRoom) }}" class="text-indigo-600 hover:text-indigo-800 bg-indigo-50 rounded-full p-2 hover:bg-indigo-100" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.classrooms.destroy', $classRoom) }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 rounded-full p-2 hover:bg-red-100" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>                @empty                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada kelas ditemukan. 
                        <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center ml-2 text-blue-600 hover:text-blue-800 bg-blue-50 rounded-full p-2 hover:bg-blue-100" title="Tambah Kelas Baru">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($classRooms->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $classRooms->links() }}
    </div>
    @endif
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = '✓';
        button.classList.add('text-green-600');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('text-green-600');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Gagal menyalin kode');
    });
}
</script>
@endsection
