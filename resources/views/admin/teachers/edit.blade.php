@extends('admin.layout')

@section('content')
<div class="space-y-6">    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Guru: {{ $teacher->user->name }}</h1>
        <a href="{{ route('admin.teachers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali ke Guru
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $teacher->user->name) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $teacher->user->email) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $teacher->user->phone) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', $teacher->subject) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('subject') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employee ID -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Karyawan</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('employee_id') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qualification -->
                <div>
                    <label for="qualification" class="block text-sm font-medium text-gray-700">Kualifikasi</label>
                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $teacher->qualification) }}" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('qualification') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('qualification')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div>
                    <label for="experience" class="block text-sm font-medium text-gray-700">Pengalaman (tahun)</label>
                    <input type="number" name="experience" id="experience" value="{{ old('experience', $teacher->experience) }}" min="0"
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('experience') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>                <!-- Password (Optional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
                    <input type="password" name="password" id="password" 
                           class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                    <p class="mt-1 text-sm text-gray-500">Kosongkan untuk mempertahankan password saat ini</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>            <!-- Bio -->
            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea name="bio" id="bio" rows="3" 
                          class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has('bio') ? 'border-red-500' : 'border-gray-300' }}">{{ old('bio', $teacher->bio) }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Perbarui Guru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
