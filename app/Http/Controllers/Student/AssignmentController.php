<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    /**
     * Tampilkan form untuk mengunggah tugas baru.
     * Jika tugas sudah diunggah sebelumnya, tampilkan detail untuk mengubah/mengunggah ulang.
     */
    public function create(Task $task)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan siswa memiliki akses ke kelas tugas ini
        // Cek apakah student terdaftar di kelas (melalui pivot table class_student)
        $isEnrolled = $student->classRooms->contains($task->classRoom->id);

        $hasAccessToClass = false;
        if ($isEnrolled) {
            $hasAccessToClass = true;
        } elseif ($task->classRoom->isBimbel()) {
            // Jika kelas bimbel dan belum terdaftar, cek status pembayaran
            $payment = $student->payments()
                               ->where('class_room_id', $task->classRoom->id)
                               ->latest()
                               ->first();
            if ($payment && $payment->isApproved()) {
                $hasAccessToClass = true;
            }
        } else { // Kelas reguler
            $hasAccessToClass = true;
        }

        if (!$hasAccessToClass) {
            return redirect()->route('student.class.detail', $task->classRoom)
                             ->with('error', 'Anda tidak memiliki akses ke kelas ini untuk mengunggah tugas.');
        }

        // Cari tugas yang sudah ada untuk siswa dan tugas ini
        $assignment = Assignment::where('task_id', $task->id)
                                ->where('student_id', $student->id)
                                ->first();

        return view('student.assignments.form', compact('task', 'assignment'));
    }

    /**
     * Simpan tugas yang baru diunggah atau perbarui yang sudah ada.
     */
    public function store(Request $request, Task $task)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan siswa memiliki akses ke kelas tugas ini sebelum mengunggah
        $isEnrolled = $student->classRooms->contains($task->classRoom->id);
        $hasAccessToClass = false;
        if ($isEnrolled) {
            $hasAccessToClass = true;
        } elseif ($task->classRoom->isBimbel()) {
            $payment = $student->payments()
                               ->where('class_room_id', $task->classRoom->id)
                               ->latest()
                               ->first();
            if ($payment && $payment->isApproved()) {
                $hasAccessToClass = true;
            }
        } else {
            $hasAccessToClass = true;
        }

        if (!$hasAccessToClass) {
            return redirect()->route('student.class.detail', $task->classRoom)
                             ->with('error', 'Anda tidak memiliki akses ke kelas ini untuk mengunggah tugas.');
        }

        $assignment = Assignment::where('task_id', $task->id)
                                ->where('student_id', $student->id)
                                ->first();

        $rules = [
            'assignment_file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png'], // Maks 10MB
        ];

        // Jika ada tugas yang sudah ada dan tidak ada file baru yang diunggah, file tidak wajib
        if ($assignment && !$request->hasFile('assignment_file')) {
            $rules['assignment_file'] = ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png'];
        }

        $request->validate($rules);

        try {
            $filePath = $assignment ? $assignment->file_path : null;
            $folderPath = $assignment ? $assignment->folder_path : null;

            if ($request->hasFile('assignment_file')) {
                // Hapus file lama jika ada
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                // Buat nama folder unik berdasarkan task_id dan student_id
                $folderName = 'assignments/' . $task->id . '/' . $student->id;
                $fileName = $request->file('assignment_file')->getClientOriginalName();
                $filePath = $request->file('assignment_file')->storeAs($folderName, $fileName, 'public');
                $folderPath = $folderName; // Simpan path folder
            } else if (!$assignment) {
                // Jika tidak ada file diunggah dan ini pembuatan tugas baru, itu error
                throw ValidationException::withMessages(['assignment_file' => 'File tugas harus diunggah.']);
            }

            if ($assignment) {
                // Perbarui tugas yang sudah ada
                $assignment->update([
                    'folder_path' => $folderPath,
                    'file_path' => $filePath,
                    // 'nilai' dikelola oleh guru
                ]);
                $message = 'Tugas berhasil diperbarui!';
            } else {
                // Buat tugas baru
                Assignment::create([
                    'task_id' => $task->id,
                    'student_id' => $student->id,
                    'folder_path' => $folderPath,
                    'file_path' => $filePath,
                    'nilai' => null, // Default null untuk nilai
                ]);
                $message = 'Tugas berhasil diunggah!';
            }

            return redirect()->route('student.class.detail', $task->classRoom)
                             ->with('success', $message);

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengunggah tugas: ' . $e->getMessage());
        }
    }
}
