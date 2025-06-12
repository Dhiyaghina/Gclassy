@extends('admin.layout')

@section('content')
<div class="space-y-6">    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pembayaran</h1>
        <a href="{{ route('admin.payments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Pembayaran Baru
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap gap-4">            <div class="flex-1 min-w-48">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="flex-1 min-w-48">
                <label for="class_room_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="class_room_id" id="class_room_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Kelas</option>
                    @foreach($classRooms as $classRoom)
                        <option value="{{ $classRoom->id }}" {{ request('class_room_id') == $classRoom->id ? 'selected' : '' }}>
                            {{ $classRoom->name }}
                        </option>
                    @endforeach
                </select>
            </div>            <div class="flex items-end">
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->student->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $payment->student->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $payment->classRoom->name }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($payment->classRoom->type) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">                        @if($payment->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Menunggu
                            </span>
                        @elseif($payment->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $payment->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                    </td>                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        
                        @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900"
                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')">
                                    Setujui
                                </button>
                            </form>
                            
                            <button type="button" class="text-red-600 hover:text-red-900"
                                    onclick="openRejectModal({{ $payment->id }})">
                                Tolak
                            </button>
                        @endif
                        
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        
                        <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada pembayaran ditemukan. <a href="{{ route('admin.payments.create') }}" class="text-blue-600 hover:text-blue-900">Tambah pembayaran pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $payments->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pembayaran</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="reject_notes" class="block text-sm font-medium text-gray-700">Alasan penolakan:</label>
                    <textarea name="notes" id="reject_notes" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(paymentId) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').action = `/admin/payments/${paymentId}/reject`;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reject_notes').value = '';
}
</script>
@endsection
