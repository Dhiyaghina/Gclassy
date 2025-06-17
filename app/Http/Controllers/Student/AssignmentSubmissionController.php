<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AssignmentSubmissionController extends Controller
{
    /**
     * Tampilkan form untuk mengunggah tugas baru.
     * Jika tugas sudah diunggah sebelumnya, tampilkan detail untuk mengubah/mengunggah ulang.
     */
    public function create(Assignment $assignment)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan siswa memiliki akses ke kelas tugas ini
        // Cek apakah student terdaftar di kelas (melalui pivot table class_student)
        $isEnrolled = $student->classRooms->contains($assignment->classRoom->id);

        $hasAccessToClass = false;
        if ($isEnrolled) {
            $hasAccessToClass = true;
        } elseif ($assignment->classRoom->isBimbel()) {
            // Jika kelas bimbel dan belum terdaftar, cek status pembayaran
            $payment = $student->payments()
                            ->where('class_room_id', $assignment->classRoom->id)
                            ->latest()
                            ->first();
            if ($payment && $payment->isApproved()) {
                $hasAccessToClass = true;
            }
        } else { // Kelas reguler
            $hasAccessToClass = true;
        }

        if (!$hasAccessToClass) {
            return redirect()->route('student.class.detail', $assignment->classRoom)
                            ->with('error', 'Anda tidak memiliki akses ke kelas ini untuk mengunggah tugas.');
        }

        // Cari tugas yang sudah ada untuk siswa dan tugas ini
        $assignmentSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
                                    ->where('student_id', $student->id)
                                    ->first();

        // Pastikan view selalu mendapatkan assignmentSubmission, meskipun nilainya null
        return view('student.assignments.form', compact('assignment', 'assignmentSubmission'));
    }

    /**
     * Simpan tugas yang baru diunggah atau perbarui yang sudah ada.
     */
    public function store(Request $request, Assignment $assignment)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan siswa memiliki akses ke kelas tugas ini sebelum mengunggah
        $isEnrolled = $student->classRooms->contains($assignment->classRoom->id);
        $hasAccessToClass = false;
        if ($isEnrolled) {
            $hasAccessToClass = true;
        } elseif ($assignment->classRoom->isBimbel()) {
            $payment = $student->payments()
                            ->where('class_room_id', $assignment->classRoom->id)
                            ->latest()
                            ->first();
            if ($payment && $payment->isApproved()) {
                $hasAccessToClass = true;
            }
        } else {
            $hasAccessToClass = true;
        }

        if (!$hasAccessToClass) {
            return redirect()->route('student.class.detail', $assignment->classRoom)
                            ->with('error', 'Anda tidak memiliki akses ke kelas ini untuk mengunggah tugas.');
        }

        $assignmentSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
                                    ->where('student_id', $student->id)
                                    ->first();

        $rules = [
            'assignment_file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png'], // Maks 10MB
            'submission_text' => ['nullable', 'string'],
        ];

        // Jika ada tugas yang sudah ada dan tidak ada file baru yang diunggah, file tidak wajib
        if ($assignmentSubmission && !$request->hasFile('assignment_file')) {
            $rules['assignment_file'] = ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png'];
        }

        $request->validate($rules);

        try {
            $filePath = $assignmentSubmission ? $assignmentSubmission->file_path : null;
            $folderPath = $assignmentSubmission ? $assignmentSubmission->folder_path : null;

            if ($request->hasFile('assignment_file')) {
                // Hapus file lama jika ada
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                // Buat nama folder unik berdasarkan task_id dan student_id
                $folderName = 'assignments/' . $assignment->id . '/' . $student->id;
                $fileName = $request->file('assignment_file')->getClientOriginalName();
                $filePath = $request->file('assignment_file')->storeAs($folderName, $fileName, 'public');
                $folderPath = $folderName; // Simpan path folder
            } else if (!$assignmentSubmission) {
                // Jika tidak ada file diunggah dan ini pembuatan tugas baru, itu error
                throw ValidationException::withMessages(['assignment_file' => 'File tugas harus diunggah.']);
            }

            if ($assignmentSubmission) {
                // Perbarui tugas yang sudah ada
                $assignmentSubmission->update([
                    'folder_path' => $folderPath,
                    'file_path' => $filePath,
                    'submission_text' => $request->submission_text,
                ]);
                $message = 'Tugas berhasil diperbarui!';
            } else {
                // Buat tugas baru
                AssignmentSubmission::create([
                    'assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                    'folder_path' => $folderPath,
                    'file_path' => $filePath,
                    'submission_text' => $request->submission_text,
                ]);
                $message = 'Tugas berhasil diunggah!';
            }

            return redirect()->route('student.class.detail', $assignment->classRoom)
                            ->with('success', $message);

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengunggah tugas: ' . $e->getMessage());
        }
    }
}
