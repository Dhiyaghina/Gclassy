@extends('admin.layout')

@section('title', 'Payment Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Payment Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.payments.edit', $payment) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Payment
                </a>
                <a href="{{ route('admin.payments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Payments
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Payment Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Payment ID</label>
                        <p class="text-gray-900">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Student</label>
                        <p class="text-gray-900">
                            <a href="{{ route('admin.students.show', $payment->student) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $payment->student->user->name }}
                            </a>
                            <span class="text-gray-500">({{ $payment->student->student_id }})</span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Class</label>
                        <p class="text-gray-900">
                            <a href="{{ route('admin.classrooms.show', $payment->classRoom) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $payment->classRoom->name }}
                            </a>
                            <span class="text-gray-500">- {{ $payment->classRoom->subject }}</span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Class Type</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->classRoom->type === 'bimbel' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($payment->classRoom->type) }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Amount</label>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                    </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-600">Status</label>
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
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaction Details</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Payment Method</label>
                        <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    </div>
                    
                    @if($payment->transaction_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Transaction ID</label>
                        <p class="text-gray-900 font-mono">{{ $payment->transaction_id }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Payment Date</label>
                        <p class="text-gray-900">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    @if($payment->updated_at != $payment->created_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                        <p class="text-gray-900">{{ $payment->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    
                    @if($payment->approved_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Approved Date</label>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($payment->approved_at)->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    
                    @if($payment->rejected_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Rejected Date</label>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($payment->rejected_at)->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Proof -->        @if($payment->payment_proof)
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Proof</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment Proof" class="max-w-lg h-auto rounded-lg shadow-md">
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                        View Full Size
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($payment->notes)
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Notes</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700">{{ $payment->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        @if($payment->status === 'pending')
        <div class="mt-8 flex space-x-3">
            <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to approve this payment?')">
                    Approve Payment
                </button>
            </form>
            
            <button onclick="openRejectModal()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Reject Payment
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Reject Payment Modal -->
@if($payment->status === 'pending')
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Reject Payment</h3>
            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="mt-4">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" 
                              placeholder="Please provide a reason for rejection..." required></textarea>
                </div>
                <div class="flex justify-center space-x-3">
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Reject
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
