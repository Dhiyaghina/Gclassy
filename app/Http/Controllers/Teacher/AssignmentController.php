<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Task;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // Siswa mengumpulkan tugas
    public function submit(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $request->validate([
            'folder_path' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,docx,jpg,png|max:2048',
        ]);

        // Simpan file tugas
        $filePath = $request->file('file')->store('assignments');

        // Simpan data tugas yang dikumpulkan
        Assignment::create([
            'task_id' => $taskId,
            'student_id' => auth()->user()->id, // Misal siswa terhubung dengan user yang login
            'folder_path' => $request->folder_path,
            'file_path' => $filePath,
        ]);

        return redirect()->route('assignments.submit', $taskId)->with('success', 'Tugas berhasil dikumpulkan');
    }

    // Guru memberikan nilai pada tugas
    public function grade(Request $request, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Update nilai
        $assignment->update([
            'nilai' => $request->nilai,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diberikan');
    }

    // Menampilkan daftar tugas untuk kelas tertentu
    public function index($classRoomId)
    {
        $classRoom = ClassRoom::findOrFail($classRoomId);
        $assignments = $classRoom->assignments()->with('submissions.student')->get();
        
        return view('teacher.classes.tugas', compact('assignments', 'classRoom'));
    }

    // Menyimpan tugas baru
    public function store(Request $request, $classRoomId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
            'due_date' => 'required|date|after:today',
        ]);

        $classRoom = ClassRoom::findOrFail($classRoomId);
        
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('assignments/attachments', 'public');
        }

        Assignment::create([
            'class_room_id' => $classRoom->id,
            'name' => $request->name,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.classes.assignments.index', $classRoomId)
                         ->with('success', 'Tugas berhasil ditambahkan');
    }

    // Mengedit tugas
    public function update(Request $request, $classRoomId, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
            'due_date' => 'required|date',
        ]);

        $attachmentPath = $assignment->attachment;
        
        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($assignment->attachment) {
                Storage::disk('public')->delete($assignment->attachment);
            }
            $attachmentPath = $request->file('attachment')->store('assignments/attachments', 'public');
        }

        $assignment->update([
            'name' => $request->name,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.classes.assignments.index', $classRoomId)
                         ->with('success', 'Tugas berhasil diperbarui');
    }

    // Menghapus tugas
    public function destroy($classRoomId, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        // Hapus file attachment jika ada
        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }
        
        // Hapus semua file submissions
        foreach ($assignment->submissions as $submission) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }
        
        $assignment->delete();

        return redirect()->route('teacher.classes.assignments.index', $classRoomId)
                         ->with('success', 'Tugas berhasil dihapus');
    }

    // Menampilkan detail tugas dan submissions
    public function show($classRoomId, $assignmentId)
    {
        $classRoom = ClassRoom::findOrFail($classRoomId);
        $assignment = Assignment::with(['submissions.student', 'classRoom'])->findOrFail($assignmentId);
        
        return view('teacher.classes.lihat_tugas', compact('assignment', 'classRoom'));
    }

    // Memberikan nilai pada submission
    public function gradeSubmission(Request $request, $submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diberikan');
    }

    
}
