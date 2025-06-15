<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pembayaran Kelas: ') . $classRoom->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('student.payment.process', $classRoom) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Informasi Transfer Bank BSI --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">Informasi Pembayaran (Khusus Transfer Bank)</p>
                            <p class="mt-2">Silakan lakukan transfer ke rekening berikut:</p>
                            <p class="mt-1"><strong>Bank:</strong> BSI (Bank Syariah Indonesia)</p>
                            <p><strong>Nomor Rekening:</strong> 1002278911</p>
                            <p class="mt-2 text-sm">Pastikan nominal transfer sesuai dengan "Jumlah Pembayaran".</p>
                        </div>
                        {{-- End Informasi Transfer Bank BSI --}}

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                            <input type="number" id="amount" name="amount" step="0.01" value="{{ old('amount', $classRoom->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih metode pembayaran...</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="e_wallet" {{ old('payment_method') === 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">ID Transaksi (Opsional)</label>
                            <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="Jika ada, contoh: kode unik transfer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran (Gambar)</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100" required>
                            <p class="mt-1 text-xs text-gray-500">Upload gambar bukti transfer/pembayaran (JPG, PNG, GIF, SVG, maks 2MB).</p>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kirim Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
