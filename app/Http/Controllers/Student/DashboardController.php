<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student; // Ambil profil student

        // Dapatkan semua kelas yang tersedia
        // Menggunakan with('teacher.user') untuk memuat relasi berlapis agar tidak N+1 query di view
        $availableClassRooms = ClassRoom::with('teacher.user')->get();

        // Dapatkan kelas yang sudah diikuti student (melalui tabel pivot class_student)
        $enrolledClassRooms = $student->classRooms;

        // Buat array untuk menyimpan status akses setiap kelas
        $classAccessStatus = [];
        foreach ($availableClassRooms as $classRoom) {
            $hasAccess = false;
            $paymentStatus = 'belum_bayar'; // Default status

            // Cek apakah student sudah terdaftar di kelas ini
            if ($enrolledClassRooms->contains($classRoom->id)) {
                $hasAccess = true; // Jika sudah terdaftar, berarti punya akses
                $paymentStatus = 'terdaftar'; // Status lebih tepat untuk yang sudah terdaftar
            } else {
                // Jika belum terdaftar, cek apakah kelas membutuhkan pembayaran
                if ($classRoom->isBimbel()) { // Asumsi kelas bimbel memerlukan pembayaran
                    // Cek status pembayaran untuk kelas ini
                    // Gunakan latest() pada query builder untuk mendapatkan pembayaran terbaru
                    $payment = $student->payments()
                                     ->where('class_room_id', $classRoom->id)
                                     ->latest() // Ini setara dengan orderByDesc('created_at')
                                     ->first();

                    if ($payment) {
                        $paymentStatus = $payment->status;
                        if ($payment->isApproved()) {
                            $hasAccess = true; // Akses diberikan jika pembayaran disetujui
                        }
                    }
                } else {
                    // Kelas reguler tidak memerlukan pembayaran, langsung akses
                    $hasAccess = true;
                    $paymentStatus = 'tidak_perlu_bayar';
                }
            }
            $classAccessStatus[$classRoom->id] = [
                'has_access' => $hasAccess,
                'payment_status' => $paymentStatus,
            ];
        }

        return view('student.dashboard', compact('availableClassRooms', 'enrolledClassRooms', 'classAccessStatus'));
    }

    public function showClassDetail(ClassRoom $classRoom)
    {
        $user = Auth::user();
        $student = $user->student;

        // Cek apakah student sudah terdaftar di kelas ini
        $isEnrolled = $student->classRooms->contains($classRoom->id);

        // Cek status pembayaran (hanya relevan jika kelasnya bimbel dan belum terdaftar)
        $paymentStatus = null;
        $payment = null;

        if (!$isEnrolled && $classRoom->isBimbel()) {
            // Gunakan latest() pada query builder untuk mendapatkan pembayaran terbaru
            $payment = $student->payments()
                               ->where('class_room_id', $classRoom->id)
                               ->latest() // Ini setara dengan orderByDesc('created_at')
                               ->first();
            if ($payment) {
                $paymentStatus = $payment->status;
            }
        }

        // Tentukan apakah student memiliki akses ke materi
        $hasAccessToMaterials = false;
        if ($isEnrolled) {
            $hasAccessToMaterials = true;
        } elseif ($classRoom->isBimbel() && $payment && $payment->isApproved()) {
            $hasAccessToMaterials = true;
        } elseif (!$classRoom->isBimbel()) {
            $hasAccessToMaterials = true; // Kelas reguler otomatis akses
        }

        // Jika sudah memiliki akses, ambil materi (tasks)
        // Jika tidak memiliki akses, kembalikan koleksi kosong untuk menghindari error
        $tasks = $hasAccessToMaterials ? $classRoom->tasks()->get() : collect();

        return view('student.class_detail', compact('classRoom', 'isEnrolled', 'paymentStatus', 'payment', 'hasAccessToMaterials', 'tasks'));
    }
}

