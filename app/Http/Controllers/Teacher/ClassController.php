<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan.');
        }

        $classes = ClassRoom::where('teacher_id', $teacher->id)
                           ->with(['students.user'])
                           ->withCount('students')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('teacher.classes.index', compact('classes'));
    }
    

    public function show(ClassRoom $classRoom)
    {
        $teacher = auth()->user()->teacher;
        
        // Check if this class belongs to the authenticated teacher
        if ($classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $classRoom->load(['students.user', 'payments' => function($query) {
            $query->with('student.user')->orderBy('created_at', 'desc');
        }]);

        return view('teacher.classes.show', compact('classRoom'));
    }
    public function orang(ClassRoom $classRoom)
    {
        $teacher = auth()->user()->teacher;
        
        // Pastikan kelas ini milik guru yang sedang login
        if ($classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Load data yang dibutuhkan untuk halaman 'orang'
        $classRoom->load(['students.user']); // Menampilkan data siswa yang terhubung dengan kelas

        // Kembalikan tampilan untuk halaman 'Orang'
        return view('teacher.classes.orang', compact('classRoom'));
    }

     // Menampilkan tugas (materi) untuk kelas tertentu
    public function tugas(ClassRoom $classRoom)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan kelas ini milik guru yang sedang login
        if ($classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Load tugas yang ada di kelas ini
        $tasks = $classRoom->tasks;

        // Kembalikan tampilan tugas
        return view('teacher.classes.tugas', compact('classRoom', 'tasks'));
    }

    // Menampilkan form untuk membuat tugas baru
    public function createTugas(ClassRoom $classRoom)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan kelas ini milik guru yang sedang login
        if ($classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        return view('teacher.classes.createTugas', compact('classRoom'));
    }

    // Menyimpan tugas baru
    public function storeTugas(Request $request, ClassRoom $classRoom)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan kelas ini milik guru yang sedang login
        if ($classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $attachment = $request->file('attachment') ? $request->file('attachment')->store('attachments', 'public') : null;

        Task::create([
            'classroom_id' => $classRoom->id,
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => $attachment,
        ]);

        return redirect()->route('teacher.classes.tugas', ['classRoom' => $classRoom->id])->with('success', 'Tugas berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit tugas
    public function editTugas(Task $task)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan tugas ini milik kelas yang sedang diajarkan oleh guru yang sedang login
        if ($task->classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        return view('teacher.classes.editTugas', compact('task'));
    }

    // Menyimpan perubahan pada tugas
    public function updateTugas(Request $request, Task $task)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan tugas ini milik kelas yang sedang diajarkan oleh guru yang sedang login
        if ($task->classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $attachment = $request->file('attachment') 
                        ? $request->file('attachment')->store('attachments', 'public') 
                        : $task->attachment;

        $task->update([
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => $attachment,
        ]);

        return redirect()->route('teacher.classes.tugas', ['classRoom' => $task->classRoom->id])->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menghapus tugas
    public function deleteTugas(Task $task)
    {
        $teacher = auth()->user()->teacher;

        // Pastikan tugas ini milik kelas yang sedang diajarkan oleh guru yang sedang login
        if ($task->classRoom->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        $task->delete();

        return redirect()->route('teacher.classes.tugas', ['classRoom' => $task->classRoom->id])->with('success', 'Tugas berhasil dihapus.');
    }
}


