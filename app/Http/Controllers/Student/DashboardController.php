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
            $payment = $student->payments()
                               ->where('class_room_id', $classRoom->id)
                               ->latest()
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
            // Jika akses diberikan melalui pembayaran, tambahkan student ke kelas_student pivot
            // Ini penting agar relasi student->classRooms->contains() bekerja dengan benar
            // untuk cek akses tugas, forum, dll.
            if (!$isEnrolled) {
                $student->classRooms()->attach($classRoom->id);
                $isEnrolled = true; // Perbarui status pendaftaran lokal
            }
        } elseif (!$classRoom->isBimbel()) {
            $hasAccessToMaterials = true; // Kelas reguler otomatis akses
            // Untuk kelas reguler, jika student belum terdaftar di pivot, daftarkan
            if (!$isEnrolled) {
                 $student->classRooms()->attach($classRoom->id);
                 $isEnrolled = true; // Perbarui status pendaftaran lokal
            }
        }

        // Jika sudah memiliki akses, ambil materi (tasks)
        // Eager load assignments untuk *siswa saat ini* pada setiap tugas
        $tasks = collect();
        if ($hasAccessToMaterials) {
            $tasks = $classRoom->tasks()->with(['assignments' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])->get();
        }

        return view('student.class_detail', compact('classRoom', 'isEnrolled', 'paymentStatus', 'payment', 'hasAccessToMaterials', 'tasks'));
    }
}
