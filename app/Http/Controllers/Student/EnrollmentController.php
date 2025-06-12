<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Show enrollment form
     */
    public function index()
    {
        $student = Auth::user()->student ?? null;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa tidak ditemukan.');
        }
        
        $enrolledClasses = $student->classRooms()->where('type', 'reguler')->get();
        
        return view('student.enrollment', compact('enrolledClasses'));
    }
    
    /**
     * Process enrollment with code
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_code' => 'required|string|exists:class_rooms,enrollment_code',
        ]);

        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->back()->with('error', 'Profil siswa tidak ditemukan.');
        }

        $classRoom = ClassRoom::where('enrollment_code', $request->enrollment_code)
            ->where('type', 'reguler')
            ->where('is_active', true)
            ->first();

        if (!$classRoom) {
            return redirect()->back()
                ->withErrors(['enrollment_code' => 'Kode enrollment tidak valid atau kelas tidak aktif.']);
        }
        
        // Check if already enrolled
        if ($classRoom->students()->where('student_id', $student->id)->exists()) {
            return redirect()->back()
                ->withErrors(['enrollment_code' => 'Anda sudah terdaftar di kelas ini.']);
        }

        $classRoom->students()->attach($student->id);

        return redirect()->back()
            ->with('success', 'Berhasil bergabung ke kelas: ' . $classRoom->name);
    }
    
    /**
     * Leave a class
     */
    public function leave(ClassRoom $classRoom)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->back()->with('error', 'Profil siswa tidak ditemukan.');
        }
        
        // Only allow leaving regular classes
        if ($classRoom->type !== 'reguler') {
            return redirect()->back()->with('error', 'Hanya dapat keluar dari kelas reguler.');
        }
        
        $classRoom->students()->detach($student->id);
        
        return redirect()->back()
            ->with('success', 'Berhasil keluar dari kelas: ' . $classRoom->name);
    }
}
