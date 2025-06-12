<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_teachers' => Teacher::count(),
            'total_students' => Student::count(),
            'active_classes' => ClassRoom::where('is_active', true)->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'approved_payments' => Payment::where('status', 'approved')->count(),
            'total_revenue' => Payment::where('status', 'approved')->sum('amount'),
        ];
        
        // Get recent payments
        $recent_payments = Payment::with(['student.user', 'classRoom'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Get class distribution
        $class_distribution = ClassRoom::withCount('students')
            ->get()
            ->map(function($class) {
                return [
                    'name' => $class->name,
                    'students_count' => $class->students_count,
                    'type' => $class->type
                ];
            });
        
        return view('admin.dashboard', compact('stats', 'recent_payments', 'class_distribution'));
    }
}
