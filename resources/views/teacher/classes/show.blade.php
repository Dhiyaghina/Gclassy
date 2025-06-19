@extends('teacher.layout')

@section('title', 'Detail Kelas - ' . $classRoom->name)

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
    <!-- Detail Kelas -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                 <h3 class="text-2xl font-bold text-gray-800">Informasi Kelas</h3>
            </div>
            <div class="card-body p-4">
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
                            <dd class="mt-1 text-sm text-gray-900 font-mono ">
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

           

@endsection
