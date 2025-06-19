@extends('teacher.layout')

@section('title', 'Daftar Siswa Kelas- ' . $classRoom->name)

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
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="card-header bg-white border-0 pt-4 pb-0">
             <h3 class="text-2xl font-bold text-gray-800"> Siswa Terdaftar ({{ $classRoom->students->count() }})</h3>
        </div>
    <div class="card-body p-4">
        @if($classRoom->students->count() > 0)
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($classRoom->students as $student)
                    <div class="flex items-center space-x-3 p-5 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="h-18 w-18 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">
                                    {{ substr($student->user->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $student->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $student->student_id }}</p>
                            @if($student->user->phone)
                                <p class="text-xs text-gray-400">{{ $student->user->phone }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada siswa</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada siswa yang terdaftar di kelas ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
