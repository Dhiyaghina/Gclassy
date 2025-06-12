@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Bergabung ke Kelas Reguler</h1>
        
        <!-- Enrollment Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Masukkan Kode Enrollment</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('student.enrollment.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="enrollment_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Enrollment
                    </label>                    <input type="text" 
                           name="enrollment_code" 
                           id="enrollment_code" 
                           value="{{ old('enrollment_code') }}"
                           class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('enrollment_code') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Masukkan kode enrollment dari guru">
                    @error('enrollment_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Bergabung ke Kelas
                </button>
            </form>
        </div>
        
        <!-- Enrolled Classes -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Kelas Reguler Saya</h2>
            
            @if($enrolledClasses->count() > 0)
                <div class="grid gap-4">
                    @foreach($enrolledClasses as $class)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $class->name }}</h3>
                                    <p class="text-gray-600">{{ $class->subject }}</p>
                                    
                                    @if($class->teacher)
                                        <p class="text-sm text-gray-500">
                                            Guru: {{ $class->teacher->user->name }}
                                        </p>
                                    @endif
                                    
                                    @if($class->schedule)
                                        <p class="text-sm text-gray-500">
                                            Jadwal: {{ $class->schedule }}
                                        </p>
                                    @endif
                                    
                                    @if($class->description)
                                        <p class="text-sm text-gray-600 mt-2">{{ $class->description }}</p>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Kelas Reguler
                                        </span>
                                        
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                            Gratis
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="ml-4">
                                    <form action="{{ route('student.enrollment.leave', $class) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin keluar dari kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-6xl mb-4">📚</div>
                    <p class="text-gray-500 text-lg">Anda belum bergabung ke kelas reguler manapun.</p>
                    <p class="text-gray-400 text-sm mt-2">Masukkan kode enrollment untuk bergabung ke kelas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
