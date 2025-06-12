@extends('admin.layout')

@section('title', 'Teacher Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Teacher Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Teacher
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Teachers
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
                        <p class="text-gray-900">{{ $teacher->user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Employee ID</label>
                        <p class="text-gray-900">{{ $teacher->employee_id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-900">{{ $teacher->user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Phone</label>
                        <p class="text-gray-900">{{ $teacher->user->phone ?? 'Not provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Subject</label>
                        <p class="text-gray-900">{{ $teacher->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Qualification</label>
                        <p class="text-gray-900">{{ $teacher->qualification ?? 'Not provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Experience</label>
                        <p class="text-gray-900">{{ $teacher->experience ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Account Created</label>
                        <p class="text-gray-900">{{ $teacher->user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                        <p class="text-gray-900">{{ $teacher->user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email Verified</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $teacher->user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $teacher->user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Teaching -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Classes Teaching</h3>
                <a href="{{ route('admin.classrooms.create') }}?teacher_id={{ $teacher->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Create New Class
                </a>
            </div>
            
            @if($teacher->classRooms->count() > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($teacher->classRooms as $classRoom)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $classRoom->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->subject }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classRoom->type === 'bimbel' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($classRoom->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->students->count() }} students</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $classRoom->schedule ?? 'Not set' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.classrooms.show', $classRoom) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="{{ route('admin.classrooms.edit', $classRoom) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">This teacher is not assigned to any classes yet.</p>
                </div>
            @endif
        </div>

        <!-- Teaching Statistics -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Teaching Statistics</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $teacher->classRooms->count() }}</div>
                    <div class="text-sm text-gray-600">Total Classes</div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $teacher->classRooms->sum(function($class) { return $class->students->count(); }) }}</div>
                    <div class="text-sm text-gray-600">Total Students</div>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $teacher->classRooms->where('type', 'bimbel')->count() }}</div>
                    <div class="text-sm text-gray-600">Bimbel Classes</div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $teacher->classRooms->where('type', 'reguler')->count() }}</div>
                    <div class="text-sm text-gray-600">Regular Classes</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
