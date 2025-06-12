@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Add New Teacher</h1>
        <a href="{{ route('admin.teachers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Teachers
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('subject') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Employee ID -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('employee_id') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qualification -->
                <div>
                    <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('qualification') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('qualification')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div>
                    <label for="experience" class="block text-sm font-medium text-gray-700">Experience (years)</label>
                    <input type="number" name="experience" id="experience" value="{{ old('experience') }}" min="0"
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('experience') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea name="bio" id="bio" rows="3" 
                          class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('bio') ? 'border-red-500' : 'border-gray-300' }}">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Teacher
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
