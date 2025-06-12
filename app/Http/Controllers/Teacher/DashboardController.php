<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get teacher's classes
        $myClasses = ClassRoom::where('teacher_id', $teacher->id)
                             ->with(['students', 'payments'])
                             ->get();

        // Calculate statistics
        $totalClasses = $myClasses->count();
        $totalStudents = $myClasses->sum(function($class) {
            return $class->students->count();
        });
        
        $totalRevenue = $myClasses->sum(function($class) {
            return $class->payments->where('status', 'approved')->sum('amount');
        });

        // Get recent payments for teacher's classes
        $recentPayments = Payment::whereIn('class_room_id', $myClasses->pluck('id'))
                                ->with(['student.user', 'classRoom'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'myClasses',
            'totalClasses',
            'totalStudents',
            'totalRevenue',
            'recentPayments'
        ));
    }
}
