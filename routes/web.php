<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ClassController as TeacherClassController;
use App\Http\Controllers\Teacher\TaskController;
// use App\Http\Controllers\Teacher\TugasController;
use App\Http\Controllers\Teacher\AssignmentController as TeacherAssignmentController; 
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\AssignmentSubmissionController as StudentAssignmentSubmissionController; // Import the new controller
use App\Http\Controllers\Teacher\AssignmentController; // Diperlukan jika route assignments.grade aktif

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

Route::get('/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::post('/classrooms/{classRoom}/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::delete('/forum/{forum}', [ForumController::class, 'destroy'])->name('forum.destroy');
    
    // Routes untuk comments
    Route::post('/forum/{forum}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Profile route, dengan redirect untuk admin
    Route::get('/profile', function() {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return app(ProfileController::class)->edit(request());
    })->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Student specific routes (Enrollment, Class Detail, Payment, Assignment)
    Route::prefix('student')->name('student.')->group(function () {
        // Existing student enrollment routes
        Route::get('/enrollment', [EnrollmentController::class, 'index'])->name('enrollment.index');
        Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');
        Route::delete('/enrollment/{classRoom}', [EnrollmentController::class, 'leave'])->name('enrollment.leave');

        // Student class detail and payment routes
        Route::get('/class/{classRoom}', [StudentDashboardController::class, 'showClassDetail'])->name('class.detail');
        Route::get('/payment/{classRoom}', [StudentPaymentController::class, 'showPaymentForm'])->name('payment.form');
        Route::post('/payment/{classRoom}', [StudentPaymentController::class, 'processPayment'])->name('payment.process');

        // New student assignment routes
        // Route untuk menampilkan form upload/edit tugas
        Route::get('/assignment-submission/{assignment}/upload', [StudentAssignmentSubmissionController::class, 'create'])->name('assignments-submission.create');
        // Route untuk menyimpan/memperbarui tugas
        Route::post('/assignment-submission/{assignment}', [StudentAssignmentSubmissionController::class, 'store'])->name('assignments-submission.store');
    });
});

// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'teacher'])->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/classes', [TeacherClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{classRoom}', [TeacherClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{classRoom}/orang', [TeacherClassController::class, 'orang'])->name('classes.orang');
    Route::resource('/classes/{classRoom}/tasks', TaskController::class)->names('tasks');
    Route::put('/teacher/submission/{submissionId}/grade', [AssignmentController::class, 'gradeSubmission'])->name('teacher.submissions.grade');


    //  Route::get('/tasks/{taskId}/assignments', [AssignmentController::class, 'show'])->name('tasks.show');

    // Assignment Routes (menggunakan parameter 'assignment' untuk konsistensi dengan Laravel)
    Route::get('/classes/{classRoom}/tugas', [TeacherAssignmentController::class, 'index'])->name('classes.assignments.index');
    Route::post('/classes/{classRoom}/tugas', [TeacherAssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/classes/{classRoom}/tugas/{assignment}', [TeacherAssignmentController::class, 'show'])->name('classes.assignments.show');
    Route::put('/classes/{classRoom}/tugas/{assignment}', [TeacherAssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/classes/{classRoom}/tugas/{assignment}', [TeacherAssignmentController::class, 'destroy'])->name('assignments.destroy');
    
    // Grading submission
    Route::post('/submission/{submission}/grade', [TeacherAssignmentController::class, 'gradeSubmission'])->name('submissions.grade');
});


require __DIR__.'/auth.php';
