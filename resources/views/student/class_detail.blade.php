<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kelas: ') . $classRoom->name }}
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

                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $classRoom->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $classRoom->description }}</p>
                        <p class="text-sm text-gray-500 mt-1">Guru: {{ $classRoom->teacher->user->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Mata Pelajaran: {{ $classRoom->subject }}</p>
                        <p class="text-sm text-gray-500">Tipe Kelas: <span class="font-semibold">{{ ucfirst($classRoom->type) }}</span></p>

                        @if ($classRoom->isBimbel())
                            <p class="text-lg font-bold text-indigo-600 mt-3">Harga: Rp{{ number_format($classRoom->price, 2, ',', '.') }}</p>
                        @endif
                    </div>

                    @if ($hasAccessToMaterials)
                        <hr class="my-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Materi Kursus</h4>
                        @if ($tasks->isNotEmpty())
                            <ul class="list-disc pl-5">
                                @foreach ($tasks as $task)
                                    <li class="mb-2">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $task->title }}
                                        </a>
                                        <p class="text-sm text-gray-600 ml-4">{{ Str::limit($task->content, 100) }}</p>
                                        @if ($task->attachment)
                                            <a href="{{ $task->getAttachmentUrl() }}" target="_blank" class="text-blue-500 hover:underline text-sm ml-4">
                                                Unduh Lampiran
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600">Belum ada materi kursus untuk kelas ini.</p>
                        @endif
                    @else
                        <hr class="my-6">
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">Akses Terbatas!</p>
                            <p>Anda belum memiliki akses ke materi kursus ini.</p>

                            @if ($classRoom->isBimbel())
                                @if ($paymentStatus === 'pending')
                                    <p class="mt-2">Status Pembayaran: <span class="font-semibold text-yellow-700">Menunggu Verifikasi Admin</span></p>
                                    @if($payment && $payment->payment_proof)
                                        <p class="text-sm mt-1">Bukti pembayaran Anda sudah diunggah. <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Bukti</a></p>
                                    @endif
                                    <p class="mt-2 text-sm text-gray-600">Kami akan memberi tahu Anda setelah pembayaran diverifikasi.</p>
                                @elseif ($paymentStatus === 'rejected')
                                    <p class="mt-2">Status Pembayaran: <span class="font-semibold text-red-700">Ditolak</span></p>
                                    <p class="text-sm mt-1">Pembayaran Anda sebelumnya ditolak. Silakan lakukan pembayaran ulang dan upload bukti yang benar.</p>
                                    <a href="{{ route('student.payment.form', $classRoom) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Upload Bukti Pembayaran
                                    </a>
                                @else {{-- Belum ada pembayaran atau status selain pending/rejected --}}
                                    <p class="mt-2">Untuk mengakses materi, Anda perlu melakukan pembayaran.</p>
                                    <a href="{{ route('student.payment.form', $classRoom) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Upload Bukti Pembayaran
                                    </a>
                                @endif
                            @else {{-- Regulasi class, should not be here if hasAccessToMaterials is false --}}
                                <p class="mt-2">Kelas ini seharusnya tidak memerlukan pembayaran, ada kesalahan. Mohon hubungi admin.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>