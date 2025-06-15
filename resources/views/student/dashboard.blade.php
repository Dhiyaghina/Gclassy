<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif

                    {{-- Bagian Kelas Anda (Akses Penuh) --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kelas Anda (Akses Penuh)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                        @forelse ($accessibleClassRooms as $classRoom)
                            <div class="bg-white border border-green-200 rounded-lg shadow-md p-6 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $classRoom->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-1">Mata Pelajaran: {{ $classRoom->subject }}</p>
                                    <p class="text-sm text-gray-600 mb-3">Guru: {{ $classRoom->teacher->user->name ?? 'N/A' }}</p>
                                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($classRoom->description, 100) }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-green-600">Akses Penuh</span>
                                    <a href="{{ route('student.class.detail', $classRoom) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Lihat Kelas
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 col-span-3">Anda belum memiliki akses penuh ke kelas manapun.</p>
                        @endforelse
                    </div>

                    {{-- Garis Pemisah --}}
                    <hr class="my-8 border-gray-300">

                    {{-- Bagian Kelas Lainnya (Perlu Pembayaran/Menunggu) --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kelas Lainnya (Perlu Pembayaran / Menunggu Verifikasi)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($lockedClassRooms as $classRoom)
                            <div class="bg-gray-50 border border-red-200 rounded-lg shadow-sm p-6 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $classRoom->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-1">Mata Pelajaran: {{ $classRoom->subject }}</p>
                                    <p class="text-sm text-gray-600 mb-3">Guru: {{ $classRoom->teacher->user->name ?? 'N/A' }}</p>
                                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($classRoom->description, 100) }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    @php
                                        // Ambil accessInfo dari array yang sudah dibuat di controller
                                        $accessInfo = $classAccessStatus[$classRoom->id];
                                        $paymentStatus = $accessInfo['payment_status'];
                                    @endphp

                                    @if ($classRoom->isBimbel())
                                        @if ($paymentStatus === 'pending')
                                            <span class="text-sm font-semibold text-yellow-600">Menunggu Verifikasi Pembayaran</span>
                                            <a href="{{ route('student.class.detail', $classRoom) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Detail
                                            </a>
                                        @elseif ($paymentStatus === 'rejected')
                                            <span class="text-sm font-semibold text-red-600">Pembayaran Ditolak</span>
                                            <a href="{{ route('student.class.detail', $classRoom) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Lihat Detail & Bayar
                                            </a>
                                        @else {{-- belum_bayar --}}
                                            <span class="text-sm font-semibold text-red-600">Perlu Pembayaran</span>
                                            <a href="{{ route('student.class.detail', $classRoom) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Bayar Sekarang
                                            </a>
                                        @endif
                                    @else {{-- Kelas reguler, seharusnya tidak ada di sini jika logika controller benar --}}
                                        <span class="text-sm font-semibold text-gray-600">Status Tidak Diketahui</span>
                                        <a href="{{ route('student.class.detail', $classRoom) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Lihat Kelas
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 col-span-3">Tidak ada kelas yang perlu pembayaran atau menunggu verifikasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
