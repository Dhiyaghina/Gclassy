@extends('admin.layout')

@section('title', 'Detail Kelas')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Kelas</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.classrooms.edit', $classRoom) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Kelas
                </a>
                <a href="{{ route('admin.classrooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Daftar Kelas
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">            <!-- Class Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kelas</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Kelas</label>
                        <p class="text-gray-900">{{ $classRoom->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Mata Pelajaran</label>
                        <p class="text-gray-900">{{ $classRoom->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Guru</label>
                        <p class="text-gray-900">
                            <a href="{{ route('admin.teachers.show', $classRoom->teacher) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $classRoom->teacher->user->name }}
                            </a>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tipe</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classRoom->type === 'bimbel' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $classRoom->type === 'bimbel' ? 'Bimbel' : 'Reguler' }}
                        </span>
                    </div>
                      @if($classRoom->type === 'bimbel' && $classRoom->price)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Harga</label>
                        <p class="text-gray-900">Rp {{ number_format($classRoom->price, 0, ',', '.') }}</p>
                    </div>
                    @endif
                    
                    @if($classRoom->type === 'reguler' && $classRoom->enrollment_code)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Kode Enrollment</label>
                        <div class="flex items-center space-x-2">
                            <p class="text-gray-900 font-mono bg-gray-100 px-3 py-1 rounded border">{{ $classRoom->enrollment_code }}</p>
                            <button onclick="copyToClipboard('{{ $classRoom->enrollment_code }}')" 
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                📋 Salin
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Siswa dapat menggunakan kode ini untuk bergabung ke kelas reguler</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Jadwal</label>
                        <p class="text-gray-900">{{ $classRoom->schedule ?? 'Belum diatur' }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-600">Total Siswa</label>
                        <span class="text-2xl font-bold text-blue-600">{{ $classRoom->students->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-600">Total Pembayaran</label>
                        <span class="text-2xl font-bold text-green-600">{{ $classRoom->payments->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-600">Pembayaran Disetujui</label>
                        <span class="text-2xl font-bold text-emerald-600">{{ $classRoom->payments->where('status', 'approved')->count() }}</span>
                    </div>
                    
                    @if($classRoom->type === 'bimbel' && $classRoom->price)
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-600">Total Pendapatan</label>
                        <span class="text-2xl font-bold text-purple-600">
                            Rp {{ number_format($classRoom->payments->where('status', 'approved')->sum('amount'), 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-600">Dibuat</label>
                        <span class="text-sm text-gray-600">{{ $classRoom->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>        <!-- Description -->
        @if($classRoom->description)
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700">{{ $classRoom->description }}</p>
            </div>
        </div>
        @endif

        <!-- Enrolled Students -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Siswa Terdaftar</h3>
                <button onclick="openAddStudentModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Siswa
                </button>
            </div>
            
            @if($classRoom->students->count() > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg">                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($classRoom->students as $student)
                                @php
                                    $payment = $classRoom->payments->where('student_id', $student->id)->first();
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin.students.show', $student) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $student->user->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->student_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->pivot->created_at->format('d M Y') }}</td>                                    <td class="px-6 py-4 whitespace-nowrap">                                        @if($payment)
                                            @if($payment->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Belum Bayar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.classrooms.removeStudent', [$classRoom, $student]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this student from the class?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No students enrolled in this class yet.</p>
                </div>
            @endif
        </div>

        <!-- Payment History -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment History</h3>
            
            @if($classRoom->payments->count() > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($classRoom->payments->sortByDesc('created_at') as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin.students.show', $payment->student) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $payment->student->user->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @elseif($payment->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No payment history found for this class.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Add Student to Class</h3>
            <form method="POST" action="{{ route('admin.classrooms.addStudent', $classRoom) }}" class="mt-4">
                @csrf
                <div class="mb-4">
                    <select name="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select a student...</option>
                        @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->student_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-center space-x-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Student
                    </button>
                    <button type="button" onclick="closeAddStudentModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddStudentModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
}

function closeAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = '✓ Disalin';
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
