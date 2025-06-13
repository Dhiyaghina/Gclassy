@extends('teacher.layout')

@section('title', 'Detail Kelas - ' . $classRoom->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ $classRoom->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $classRoom->subject }}</p>
            <div class="nav nav-pills nav-fill">
               <a class="nav-link active" aria-current="page" href="{{ route('teacher.classes.show', ['classRoom' => $classRoom->id]) }}">Forum</a>
                <a class="nav-link" href="#">Tugas Kelas</a>
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
<div class="grid grid-cols-3 lg:grid-cols-3 gap-6">
    <!-- Detail Kelas -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Kelas</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Kelas</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $classRoom->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $classRoom->subject }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipe Kelas</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($classRoom->type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jadwal</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $classRoom->schedule ?? 'Belum ditentukan' }}</dd>
                    </div>
                    @if($classRoom->type === 'reguler' && $classRoom->enrollment_code)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Enrollment</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">
                                {{ $classRoom->enrollment_code }}
                            </dd>
                        </div>
                    @endif
                    @if($classRoom->type === 'bimbel')
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Harga</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($classRoom->price, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                    @if($classRoom->description)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $classRoom->description }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
            </div>
            </div>

            <div class="lg:col-span-2">
        <!-- Form untuk membuat post baru -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Buat Postingan Baru</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('forum.store', $classRoom) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Umumkan sesuatu kepada kelas Anda
                        </label>
                        <textarea 
                            name="content" 
                            id="content" 
                            rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tulis sesuatu untuk kelas..."
                            required
                        ></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                            Lampiran (Opsional)
                        </label>
                        <input 
                            type="file" 
                            name="attachment" 
                            id="attachment"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif"
                        >
                        @error('attachment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button 
                            type="submit"
                            class="bg-blue-600 color:bg-blue-700 text-blue-700 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Posting
                        </button>
                    </div>
                </form>
            </div>
        </div>
        

        <!-- Daftar Postingan-->
        @forelse($classRoom->forum as $forum)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <!-- Header Post -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ substr($forum->user->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $forum->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $forum->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($forum->user_id === Auth::id())
                            <form action="{{ route('forum.destroy', $forum) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="text-red-600 hover:text-red-800 text-sm"
                                    onclick="return confirm('Yakin ingin menghapus post ini?')"
                                >
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Konten Post -->
                    <div class="mb-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $forum->content }}</p>
                        
                        @if($forum->attachment)
                            <div class="mt-3">
                                <a 
                                    href="{{ asset('storage/' . $forum->attachment) }}" 
                                    target="_blank"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    Lihat Lampiran
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Komentar -->
                    <div class="border-t pt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">
                            Komentar ({{ $forum->comments->count() }})
                        </h4>

                        <!-- Form Komentar -->
                        <form action="{{ route('comments.store', $forum) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-700">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <textarea 
                                        name="content" 
                                        rows="2" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Tulis komentar..."
                                        required
                                    ></textarea>
                                    <div class="mt-2 flex justify-end">
                                        <button 
                                            type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded text-sm transition duration-150 ease-in-out">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Daftar Komentar -->
                        @foreach($forum->comments as $comment)
                            <div class="flex space-x-3 mb-3">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-700">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-50 rounded-lg px-3 py-2">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                            @if($comment->user_id === Auth::id())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-xs"
                                                        onclick="return confirm('Yakin ingin menghapus komentar ini?')"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada postingan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai diskusi dengan membuat postingan pertama.</p>
                </div>
            </div>
        @endforelse
    </div>
        </div>

    </div>  
</div>
@endsection
