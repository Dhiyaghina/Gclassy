@extends('teacher.layout')

@section('title', 'Dashboard Guru')

@section('header')
    <h1 class="text-3xl font-bold leading-tight text-gray-900">Dashboard Guru</h1>
    <p class="mt-2 text-sm text-gray-600">Selamat datang, {{ $teacher->user->name }}</p>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Kelas -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Kelas</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalClasses }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Siswa</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalStudents }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</dt>
                        <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Mata Pelajaran -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Mata Pelajaran</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $teacher->subject }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kelas Yang Diampu -->
<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Kelas Yang Diampu</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Daftar kelas yang Anda ajar saat ini.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if($myClasses->count() > 0)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($myClasses as $class)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-gray-900">{{ $class->name }}</h4>                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $class->type === 'reguler' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($class->type) }}
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ $class->subject }}</p>
                            <div class="mt-3">
                                <a href="{{ route('teacher.classes.show', $class) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-900">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kelas</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum ditugaskan ke kelas manapun.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pembayaran Terbaru -->
@if($recentPayments->count() > 0)
    <div class="mt-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pembayaran Terbaru</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">5 pembayaran terbaru untuk kelas Anda.</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <ul class="-mb-8">                        @foreach($recentPayments as $index => $payment)
                            <li class="{{ !$loop->last ? 'pb-4' : '' }}">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $payment->status === 'approved' ? 'bg-green-500' : ($payment->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm text-gray-500">
                                            <span class="font-medium text-gray-900">{{ $payment->student->user->name }}</span>
                                            - {{ $payment->classRoom->name }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status === 'approved' ? 'bg-green-100 text-green-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $payment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
