<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('user', 'classRooms')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classRooms = ClassRoom::where('is_active', true)->get();
        return view('admin.students.create', compact('classRooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'student_id' => 'nullable|string|unique:students',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'class_rooms' => 'nullable|array',
            'class_rooms.*' => 'exists:class_rooms,id',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Create student profile
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        // Attach to classes
        if ($request->class_rooms) {
            $student->classRooms()->attach($request->class_rooms);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load('user', 'classRooms.teacher.user', 'payments.classRoom');
        $availableClasses = ClassRoom::whereDoesntHave('students', function($query) use ($student) {
            $query->where('students.id', $student->id);
        })->where('is_active', true)->with('teacher.user')->get();
        
        return view('admin.students.show', compact('student', 'availableClasses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load('user', 'classRooms');
        $classRooms = ClassRoom::where('is_active', true)->get();
        return view('admin.students.edit', compact('student', 'classRooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($student->user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'student_id' => ['nullable', 'string', Rule::unique('students')->ignore($student->id)],
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'class_rooms' => 'nullable|array',
            'class_rooms.*' => 'exists:class_rooms,id',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $student->user->update($userData);

        // Update student profile
        $student->update([
            'student_id' => $request->student_id,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        // Sync classes
        $student->classRooms()->sync($request->class_rooms ?? []);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete(); // This will cascade delete the student profile
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Assign student to a class
     */
    public function assignToClass(Request $request, Student $student)
    {
        $request->validate([
            'class_room_id' => 'required|exists:class_rooms,id',
        ]);

        $classRoom = ClassRoom::findOrFail($request->class_room_id);
        
        // Check if already enrolled
        if (!$student->classRooms()->where('class_room_id', $classRoom->id)->exists()) {
            $student->classRooms()->attach($classRoom->id);
        }

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Student assigned to class successfully.');
    }

    /**
     * Remove student from a class
     */
    public function removeFromClass(Student $student, ClassRoom $classRoom)
    {
        $student->classRooms()->detach($classRoom->id);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Student removed from class successfully.');
    }
}
