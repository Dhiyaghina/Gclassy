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
}
