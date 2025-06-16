<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assignmentSubmission ? __('Ubah Tugas: ') : __('Unggah Tugas: ') }} {{ $assignment->title }}
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

                    <form action="{{ route('student.assignments-submission.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="assignment_file" class="block text-sm font-medium text-gray-700">File Tugas</label>
                            <input type="file" id="assignment_file" name="assignment_file" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100" {{ $assignmentSubmission ? '' : 'required' }}>
                            <p class="mt-1 text-xs text-gray-500">
                                Unggah file tugas Anda (PDF, DOC, DOCX, ZIP, RAR, TXT, JPG, JPEG, PNG). Maks 10MB.
                            </p>
                            @if ($assignmentSubmission && $assignmentSubmission->file_path)
                                <p class="mt-2 text-sm text-gray-600">File yang sudah diunggah: 
                                    <a href="{{ Storage::url($assignmentSubmission->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ basename($assignmentSubmission->file_path) }}
                                    </a>
                                    (Akan diganti jika Anda mengunggah file baru)
                                </p>
                            @endif
                            @error('assignment_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Menambahkan Field submission_text (Opsional) -->
                        <div class="mb-4">
                            <label for="submission_text" class="block text-sm font-medium text-gray-700">Komentar / Deskripsi (Opsional)</label>
                            <textarea id="submission_text" name="submission_text" rows="4" class="mt-1 block w-full text-sm text-gray-500
                                border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                placeholder-gray-400">{{ old('submission_text', $assignmentSubmission ? $assignmentSubmission->submission_text : '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                Tambahkan komentar atau deskripsi tambahan untuk tugas Anda. Ini adalah field opsional.
                            </p>
                            @error('submission_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ $assignmentSubmission ? 'Perbarui Tugas' : 'Unggah Tugas' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
