@extends('admin.layout')

@section('title', 'Edit Payment')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Pembayaran</h2>
            <a href="{{ route('admin.payments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Pembayaran
            </a>
        </div>

        <form method="POST" action="{{ route('admin.payments.update', $payment) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                <!-- Student -->
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih siswa...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->user->name }} ({{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class -->
                <div>
                    <label for="class_room_id" class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                    <select name="class_room_id" id="class_room_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required onchange="updateAmount()">
                        <option value="">Select a class...</option>
                        @foreach($classRooms as $classRoom)
                            <option value="{{ $classRoom->id }}" data-price="{{ $classRoom->price }}" data-type="{{ $classRoom->type }}" {{ old('class_room_id', $payment->class_room_id) == $classRoom->id ? 'selected' : '' }}>
                                {{ $classRoom->name }} - {{ $classRoom->subject }} ({{ ucfirst($classRoom->type) }})
                                @if($classRoom->type === 'bimbel' && $classRoom->price)
                                    - Rp {{ number_format($classRoom->price, 0, ',', '.') }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('class_room_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (Rp)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           min="0" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select payment method...</option>
                        <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cash" {{ old('payment_method', $payment->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="e_wallet" {{ old('payment_method', $payment->payment_method) === 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="credit_card" {{ old('payment_method', $payment->payment_method) === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction ID -->
                <div>
                    <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">Transaction ID</label>
                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('transaction_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="pending" {{ old('status', $payment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $payment->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $payment->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Payment Proof -->                @if($payment->payment_proof)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Payment Proof</label>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment Proof" class="max-w-xs h-auto rounded-lg shadow-md">
                    </div>
                </div>
                @endif

                <!-- Payment Proof -->
                <div class="md:col-span-2">
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $payment->payment_proof ? 'Replace Payment Proof' : 'Payment Proof' }}
                    </label>
                    <input type="file" name="payment_proof" id="payment_proof" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Upload image file (jpg, png, etc.). Leave empty to keep current proof.</p>
                    @error('payment_proof')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $payment->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateAmount() {
    const classSelect = document.getElementById('class_room_id');
    const amountInput = document.getElementById('amount');
    const selectedOption = classSelect.options[classSelect.selectedIndex];
    
    if (selectedOption && selectedOption.dataset.price && selectedOption.dataset.type === 'bimbel') {
        amountInput.value = selectedOption.dataset.price;
    }
}
</script>
@endsection
