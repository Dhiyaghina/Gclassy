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

        // Dapatkan semua kelas yang tersedia dengan eager loading teacher dan user-nya
        $allClassRooms = ClassRoom::with('teacher.user')->get();

        // Dapatkan kelas yang sudah diikuti student (melalui tabel pivot class_student)
        $enrolledClassRooms = $student->classRooms;

        // Inisialisasi koleksi untuk kelas yang bisa diakses dan yang terkunci
        $accessibleClassRooms = collect();
        $lockedClassRooms = collect();

        // Buat array untuk menyimpan status akses setiap kelas
        $classAccessStatus = [];

        foreach ($allClassRooms as $classRoom) {
            $hasAccess = false;
            $paymentStatus = 'belum_bayar'; // Default status

            // Cek apakah student sudah terdaftar di kelas ini (via class_student pivot)
            if ($enrolledClassRooms->contains($classRoom->id)) {
                $hasAccess = true;
                $paymentStatus = 'terdaftar';
            } else {
                // Jika belum terdaftar, cek apakah kelas membutuhkan pembayaran
                if ($classRoom->isBimbel()) {
                    $payment = $student->payments()
                                     ->where('class_room_id', $classRoom->id)
                                     ->latest()
                                     ->first();

                    if ($payment) {
                        $paymentStatus = $payment->status;
                        if ($payment->isApproved()) {
                            $hasAccess = true;
                            // Jika pembayaran disetujui tapi belum terdaftar di pivot, daftarkan sekarang
                            // Ini memastikan siswa terdaftar di pivot table untuk kelas bimbel setelah pembayaran disetujui.
                            $student->classRooms()->attach($classRoom->id);
                            // Refresh collection enrolledClassRooms jika attach dilakukan agar konsisten dalam loop ini
                            $enrolledClassRooms->push($classRoom);
                        }
                    }
                } else {
                    // Kelas reguler tidak memerlukan pembayaran, langsung akses
                    $hasAccess = true;
                    $paymentStatus = 'tidak_perlu_bayar';
                    // Untuk kelas reguler, jika student belum terdaftar di pivot, daftarkan
                    if (!$enrolledClassRooms->contains($classRoom->id)) {
                        $student->classRooms()->attach($classRoom->id);
                        $enrolledClassRooms->push($classRoom); // Refresh collection
                    }
                }
            }

            $classAccessStatus[$classRoom->id] = [
                'has_access' => $hasAccess,
                'payment_status' => $paymentStatus,
            ];

            if ($hasAccess) {
                $accessibleClassRooms->push($classRoom);
            } else {
                $lockedClassRooms->push($classRoom);
            }
        }

        return view('student.dashboard', compact('accessibleClassRooms', 'lockedClassRooms', 'classAccessStatus'));
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
        $tasks = collect();
        $assignments = collect();
        if ($hasAccessToMaterials) {
            $tasks = $classRoom->tasks()->get();
            $assignments = $classRoom->assignments()->get();
        }

        return view('student.class_detail', compact('classRoom', 'isEnrolled', 'paymentStatus', 'payment', 'hasAccessToMaterials', 'tasks', 'assignments'));
    }
}
