<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['student.user', 'classRoom', 'approver']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by class
        if ($request->filled('class_room_id')) {
            $query->where('class_room_id', $request->class_room_id);
        }
        
        $payments = $query->latest()->paginate(15);
        $classRooms = ClassRoom::all();
        
        return view('admin.payments.index', compact('payments', 'classRooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::with('user')->get();
        $classRooms = ClassRoom::with('teacher.user')->get();
        
        return view('admin.payments.create', compact('students', 'classRooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_room_id' => 'required|exists:class_rooms,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $paymentData = [
            'student_id' => $request->student_id,
            'class_room_id' => $request->class_room_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'notes' => $request->notes,
        ];

        // Handle file upload
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $paymentData['payment_proof'] = $file->storeAs('payment_proofs', $filename, 'public');
        }

        $payment = Payment::create($paymentData);

        // If approved, auto-enroll student to class
        if ($request->status === 'approved') {
            $student = Student::find($request->student_id);
            $classRoom = ClassRoom::find($request->class_room_id);
            
            if (!$student->classRooms()->where('class_room_id', $classRoom->id)->exists()) {
                $student->classRooms()->attach($classRoom->id);
            }
            
            $payment->update([
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('student.user', 'classRoom', 'approver');
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $students = Student::with('user')->get();
        $classRooms = ClassRoom::with('teacher.user')->get();
        return view('admin.payments.edit', compact('payment', 'students', 'classRooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_room_id' => 'required|exists:class_rooms,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $paymentData = [
            'student_id' => $request->student_id,
            'class_room_id' => $request->class_room_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'notes' => $request->notes,
        ];

        // Handle file upload
        if ($request->hasFile('payment_proof')) {
            // Delete old file if exists
            if ($payment->payment_proof) {
                \Storage::disk('public')->delete($payment->payment_proof);
            }
            
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $paymentData['payment_proof'] = $file->storeAs('payment_proofs', $filename, 'public');
        }

        // Handle status changes
        if ($request->status === 'approved' && $payment->status !== 'approved') {
            $paymentData['approved_at'] = now();
            $paymentData['approved_by'] = auth()->id();
            
            // Auto-enroll student to class
            $student = Student::find($request->student_id);
            $classRoom = ClassRoom::find($request->class_room_id);
            
            if (!$student->classRooms()->where('class_room_id', $classRoom->id)->exists()) {
                $student->classRooms()->attach($classRoom->id);
            }
        } elseif ($request->status === 'rejected' && $payment->status !== 'rejected') {
            $paymentData['rejected_at'] = now();
        }

        $payment->update($paymentData);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * Approve payment
     */
    public function approve(Payment $payment)
    {
        $payment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Auto-assign student to class if approved
        $payment->student->classRooms()->syncWithoutDetaching([$payment->class_room_id]);

        return redirect()->back()
            ->with('success', 'Payment approved successfully. Student has been enrolled in the class.');
    }

    /**
     * Reject payment
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'notes' => $request->rejection_reason,
            'rejected_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Payment rejected successfully.');
    }
}
