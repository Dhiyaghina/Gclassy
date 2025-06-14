<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Task;
use App\Models\Student;
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
}
