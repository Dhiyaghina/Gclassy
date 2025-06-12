@extends('teacher.layout')

@section('title', 'Detail Kelas - ' . $classRoom->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ $classRoom->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $classRoom->subject }}</p>
        </div>        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $classRoom->type === 'reguler' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ ucfirst($classRoom->type) }}
            </span>
            @if($classRoom->type === 'bimbel')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    Rp {{ number_format($classRoom->price, 0, ',', '.') }}
                </span>
            @endif
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Kelas -->
    <div class="lg:col-span-2">
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

        <!-- Daftar Siswa -->
        <div class="mt-6 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Siswa Terdaftar ({{ $classRoom->students->count() }})
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($classRoom->students->count() > 0)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($classRoom->students as $student)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
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
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Statistik Singkat -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Statistik</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total Siswa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $classRoom->students->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span class="text-sm font-medium text-gray-900">{{ $classRoom->payments->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Pembayaran Disetujui</span>
                        <span class="text-sm font-medium text-green-600">
                            {{ $classRoom->payments->where('status', 'approved')->count() }}
                        </span>
                    </div>
                    @if($classRoom->type === 'bimbel')
                        <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                            <span class="text-sm font-medium text-gray-500">Total Pendapatan</span>
                            <span class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($classRoom->payments->where('status', 'approved')->sum('amount'), 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pembayaran Terbaru -->
        @if($classRoom->payments->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Pembayaran Terbaru</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($classRoom->payments->take(5) as $payment)
                                <li class="@if(!$loop->last) pb-4 @endif">                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-6 w-6 rounded-full flex items-center justify-center ring-4 ring-white text-xs text-white {{ $payment->status === 'approved' ? 'bg-green-500' : ($payment->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                                @if($payment->status === 'approved') ✓
                                                @elseif($payment->status === 'rejected') ✗
                                                @else ? @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">{{ $payment->student->user->name }}</span>
                                            </div>
                                            <div class="mt-1 text-xs text-gray-500">
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                · {{ $payment->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
