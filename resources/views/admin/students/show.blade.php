@extends('admin.layout')

@section('title', 'Student Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Student Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.students.edit', $student) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Student
                </a>
                <a href="{{ route('admin.students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Students
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Full Name</label>
                        <p class="text-gray-900">{{ $student->user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Student ID</label>
                        <p class="text-gray-900">{{ $student->student_id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-900">{{ $student->user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Phone</label>
                        <p class="text-gray-900">{{ $student->user->phone ?? 'Not provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Date of Birth</label>
                        <p class="text-gray-900">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'Not provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Address</label>
                        <p class="text-gray-900">{{ $student->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Account Created</label>
                        <p class="text-gray-900">{{ $student->user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                        <p class="text-gray-900">{{ $student->user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email Verified</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $student->user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Classes -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Enrolled Classes</h3>
                <button onclick="openAssignClassModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Assign to Class
                </button>
            </div>
            
            @if($student->classRooms->count() > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($student->classRooms as $classRoom)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $classRoom->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->subject }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->teacher->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classRoom->type === 'bimbel' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($classRoom->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->pivot->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.students.removeFromClass', [$student, $classRoom]) }}" class="inline">
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
                    <p class="text-gray-500">This student is not enrolled in any classes yet.</p>
                </div>
            @endif
        </div>

        <!-- Payment History -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment History</h3>
            
            @if($student->payments->count() > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($student->payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->classRoom->name }}</td>
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
                    <p class="text-gray-500">No payment history found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Assign Class Modal -->
<div id="assignClassModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Assign Student to Class</h3>
            <form method="POST" action="{{ route('admin.students.assignToClass', $student) }}" class="mt-4">
                @csrf
                <div class="mb-4">
                    <select name="class_room_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select a class...</option>
                        @foreach($availableClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} - {{ $class->subject }} ({{ ucfirst($class->type) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-center space-x-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Assign
                    </button>
                    <button type="button" onclick="closeAssignClassModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAssignClassModal() {
    document.getElementById('assignClassModal').classList.remove('hidden');
}

function closeAssignClassModal() {
    document.getElementById('assignClassModal').classList.add('hidden');
}
</script>
@endsection
