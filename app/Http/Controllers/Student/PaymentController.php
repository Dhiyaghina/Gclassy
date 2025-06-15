<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function showPaymentForm(ClassRoom $classRoom)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan kelas adalah tipe bimbel dan belum terdaftar
        if (!$classRoom->isBimbel() || $student->classRooms->contains($classRoom->id)) {
            return redirect()->route('student.dashboard')->with('error', 'Kelas ini tidak memerlukan pembayaran atau Anda sudah terdaftar.');
        }

        // Cek apakah sudah ada pembayaran pending untuk kelas ini
        $existingPendingPayment = $student->payments()
                                           ->where('class_room_id', $classRoom->id)
                                           ->where('status', 'pending')
                                           ->first();

        if ($existingPendingPayment) {
            return redirect()->route('student.class.detail', $classRoom)
                             ->with('info', 'Anda sudah memiliki pembayaran pending untuk kelas ini. Mohon tunggu verifikasi.');
        }

        return view('student.payment_form', compact('classRoom'));
    }

    public function processPayment(Request $request, ClassRoom $classRoom)
    {
        $user = Auth::user();
        $student = $user->student;

        // Pastikan kelas adalah tipe bimbel dan belum terdaftar
        if (!$classRoom->isBimbel() || $student->classRooms->contains($classRoom->id)) {
            return redirect()->route('student.dashboard')->with('error', 'Kelas ini tidak memerlukan pembayaran atau Anda sudah terdaftar.');
        }

        $request->validate([
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'nullable|string|max:255',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
            'notes' => 'nullable|string',
        ]);

        try {
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            Payment::create([
                'student_id' => $student->id,
                'class_room_id' => $classRoom->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending', // Set status awal ke pending
                'notes' => $request->notes,
            ]);

            return redirect()->route('student.class.detail', $classRoom)
                             ->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi admin.');

        } catch (\Exception $e) {
            // Hapus file yang sudah diupload jika terjadi error
            if ($paymentProofPath) {
                Storage::disk('public')->delete($paymentProofPath);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}