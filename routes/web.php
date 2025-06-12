<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ClassController as TeacherClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
      if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->isStudent()) {
            return redirect()->route('dashboard'); 
        }
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Check if user is admin and redirect to admin dashboard
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassRoomController::class)->parameters([
        'classrooms' => 'classRoom'
    ]);
    Route::resource('payments', PaymentController::class);
    
    // Additional student actions
    Route::post('students/{student}/assign-class', [StudentController::class, 'assignToClass'])->name('students.assignToClass');
    Route::delete('students/{student}/classes/{classRoom}', [StudentController::class, 'removeFromClass'])->name('students.removeFromClass');
    
    // Additional classroom actions
    Route::post('classrooms/{classRoom}/add-student', [ClassRoomController::class, 'addStudent'])->name('classrooms.addStudent');
    Route::delete('classrooms/{classRoom}/students/{student}', [ClassRoomController::class, 'removeStudent'])->name('classrooms.removeStudent');
    
    // Additional payment actions
    Route::patch('payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::patch('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    
    // Enrollment with code
    Route::post('classrooms/enroll-with-code', [ClassRoomController::class, 'enrollWithCode'])->name('classrooms.enrollWithCode');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        // If admin tries to access profile, redirect to admin dashboard
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return app(ProfileController::class)->edit(request());
    })->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Student enrollment routes
    Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
        Route::get('/enrollment', [App\Http\Controllers\Student\EnrollmentController::class, 'index'])->name('enrollment.index');
        Route::post('/enrollment', [App\Http\Controllers\Student\EnrollmentController::class, 'store'])->name('enrollment.store');
        Route::delete('/enrollment/{classRoom}', [App\Http\Controllers\Student\EnrollmentController::class, 'leave'])->name('enrollment.leave');
    });
});

//punya guru
Route::prefix('teacher')->middleware(['auth', 'teacher'])->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/classes', [TeacherClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{classRoom}', [TeacherClassController::class, 'show'])->name('classes.show');
});
require __DIR__.'/auth.php';
