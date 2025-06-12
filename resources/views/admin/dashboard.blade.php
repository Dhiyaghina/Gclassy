@extends('admin.layout')

@section('content')
<div class="space-y-6">    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900">Dasbor Admin</h1>
        <p class="text-gray-600">Selamat datang di Sistem Manajemen E-Learning Gclassy</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Total Guru</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_teachers'] }}</p>
                </div>
                <div class="text-blue-200">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Total Siswa</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_students'] }}</p>
                </div>
                <div class="text-green-200">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Kelas Aktif</h3>
                    <p class="text-3xl font-bold">{{ $stats['active_classes'] }}</p>
                </div>
                <div class="text-purple-200">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">Pembayaran Menunggu</h3>
                    <p class="text-3xl font-bold">{{ $stats['pending_payments'] }}</p>
                </div>
                <div class="text-yellow-200">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>    <!-- Revenue and Approved Payments -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Pendapatan</h3>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500">Dari pembayaran yang disetujui</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pembayaran Disetujui</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['approved_payments'] }}</p>
            <p class="text-sm text-gray-500">Berhasil diproses</p>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white shadow rounded-lg">        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Pembayaran Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $payment->student->user->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $payment->student->user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->classRoom->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($payment->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu
                                </span>
                            @elseif($payment->status === 'approved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payment->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pembayaran terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>    <!-- Class Distribution -->
    @if($class_distribution->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Distribusi Kelas</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($class_distribution as $class)                <div class="border rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900">{{ $class['name'] }}</h4>
                    <p class="text-sm text-gray-500 capitalize">Kelas {{ $class['type'] === 'reguler' ? 'Reguler' : 'Bimbel' }}</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $class['students_count'] }}</p>
                    <p class="text-xs text-gray-500">Siswa terdaftar</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
