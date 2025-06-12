<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Teachers
        $teachers = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@teacher.com',
                'phone' => '081234567890',
                'employee_id' => 'EMP001',
                'subject' => 'Mathematics',
                'qualification' => 'Ph.D in Mathematics',
                'experience' => '10 years'
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@teacher.com',
                'phone' => '081234567891',
                'employee_id' => 'EMP002',
                'subject' => 'Physics',
                'qualification' => 'M.Sc in Physics',
                'experience' => '8 years'
            ],
            [
                'name' => 'Mrs. Lisa Anderson',
                'email' => 'lisa.anderson@teacher.com',
                'phone' => '081234567892',
                'employee_id' => 'EMP003',
                'subject' => 'English',
                'qualification' => 'M.A in English Literature',
                'experience' => '5 years'
            ],
            [
                'name' => 'Mr. David Rodriguez',
                'email' => 'david.rodriguez@teacher.com',
                'phone' => '081234567893',
                'employee_id' => 'EMP004',
                'subject' => 'Chemistry',
                'qualification' => 'M.Sc in Chemistry',
                'experience' => '7 years'
            ]
        ];

        foreach ($teachers as $teacherData) {
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'phone' => $teacherData['phone'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'employee_id' => $teacherData['employee_id'],
                'subject' => $teacherData['subject'],
                'qualification' => $teacherData['qualification'],
                'experience' => $teacherData['experience'],
            ]);
        }

        // Create Students
        $students = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@student.com',
                'phone' => '082345678901',
                'student_id' => 'STU001',
                'date_of_birth' => '2005-05-15',
                'address' => 'Jl. Merdeka No. 123, Jakarta'
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@student.com',
                'phone' => '082345678902',
                'student_id' => 'STU002',
                'date_of_birth' => '2005-08-20',
                'address' => 'Jl. Sudirman No. 456, Jakarta'
            ],
            [
                'name' => 'Ryan Wilson',
                'email' => 'ryan.wilson@student.com',
                'phone' => '082345678903',
                'student_id' => 'STU003',
                'date_of_birth' => '2004-12-10',
                'address' => 'Jl. Thamrin No. 789, Jakarta'
            ],
            [
                'name' => 'Sophia Brown',
                'email' => 'sophia.brown@student.com',
                'phone' => '082345678904',
                'student_id' => 'STU004',
                'date_of_birth' => '2005-03-25',
                'address' => 'Jl. Gatot Subroto No. 101, Jakarta'
            ],
            [
                'name' => 'Lucas Miller',
                'email' => 'lucas.miller@student.com',
                'phone' => '082345678905',
                'student_id' => 'STU005',
                'date_of_birth' => '2005-07-08',
                'address' => 'Jl. Kuningan No. 202, Jakarta'
            ],
            [
                'name' => 'Olivia Garcia',
                'email' => 'olivia.garcia@student.com',
                'phone' => '082345678906',
                'student_id' => 'STU006',
                'date_of_birth' => '2004-11-30',
                'address' => 'Jl. Senayan No. 303, Jakarta'
            ]
        ];

        foreach ($students as $studentData) {
            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'phone' => $studentData['phone'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentData['student_id'],
                'date_of_birth' => $studentData['date_of_birth'],
                'address' => $studentData['address'],
            ]);
        }

        // Create Classes
        $teachers = Teacher::all();
        $classes = [
            [
                'name' => 'Advanced Mathematics',
                'subject' => 'Mathematics',
                'type' => 'bimbel',
                'price' => 500000,
                'schedule' => 'Monday & Wednesday 16:00-18:00',
                'description' => 'Advanced mathematics course covering calculus, algebra, and geometry for high school students.',
                'teacher_id' => $teachers->where('subject', 'Mathematics')->first()->id,
            ],
            [
                'name' => 'General Mathematics',
                'subject' => 'Mathematics',
                'type' => 'reguler',
                'price' => null,
                'enrollment_code' => 'MATH2024',
                'schedule' => 'Tuesday & Thursday 14:00-16:00',
                'description' => 'Basic mathematics course for middle school students.',
                'teacher_id' => $teachers->where('subject', 'Mathematics')->first()->id,
            ],
            [
                'name' => 'Physics Fundamentals',
                'subject' => 'Physics',
                'type' => 'bimbel',
                'price' => 450000,
                'schedule' => 'Tuesday & Thursday 16:00-18:00',
                'description' => 'Comprehensive physics course covering mechanics, thermodynamics, and electromagnetism.',
                'teacher_id' => $teachers->where('subject', 'Physics')->first()->id,
            ],
            [
                'name' => 'English Conversation',
                'subject' => 'English',
                'type' => 'bimbel',
                'price' => 400000,
                'schedule' => 'Wednesday & Friday 15:00-17:00',
                'description' => 'Improve your English speaking and listening skills through interactive conversations.',
                'teacher_id' => $teachers->where('subject', 'English')->first()->id,
            ],
            [
                'name' => 'Basic English',
                'subject' => 'English',
                'type' => 'reguler',
                'price' => null,
                'enrollment_code' => 'ENG2024',
                'schedule' => 'Monday & Friday 13:00-15:00',
                'description' => 'Foundation English course for beginners.',
                'teacher_id' => $teachers->where('subject', 'English')->first()->id,
            ],
            [
                'name' => 'Organic Chemistry',
                'subject' => 'Chemistry',
                'type' => 'bimbel',
                'price' => 550000,
                'schedule' => 'Saturday 09:00-12:00',
                'description' => 'Intensive chemistry course focusing on organic compounds and reactions.',
                'teacher_id' => $teachers->where('subject', 'Chemistry')->first()->id,
            ]
        ];

        foreach ($classes as $classData) {
            ClassRoom::create($classData);
        }

        // Assign students to classes and create payments
        $students = Student::all();
        $classRooms = ClassRoom::all();

        // John Smith - Advanced Mathematics
        $john = $students->where('student_id', 'STU001')->first();
        $mathClass = $classRooms->where('name', 'Advanced Mathematics')->first();
        $john->classRooms()->attach($mathClass->id);
        
        Payment::create([
            'student_id' => $john->id,
            'class_room_id' => $mathClass->id,
            'amount' => $mathClass->price,
            'payment_method' => 'bank_transfer',
            'transaction_id' => 'TXN001234567',
            'status' => 'approved',
            'notes' => 'Payment for Advanced Mathematics course',
            'approved_at' => now(),
            'approved_by' => 1, // Admin user
        ]);

        // Emily Davis - Physics Fundamentals
        $emily = $students->where('student_id', 'STU002')->first();
        $physicsClass = $classRooms->where('name', 'Physics Fundamentals')->first();
        $emily->classRooms()->attach($physicsClass->id);
        
        Payment::create([
            'student_id' => $emily->id,
            'class_room_id' => $physicsClass->id,
            'amount' => $physicsClass->price,
            'payment_method' => 'e_wallet',
            'transaction_id' => 'TXN001234568',
            'status' => 'approved',
            'notes' => 'Payment for Physics Fundamentals course',
            'approved_at' => now(),
            'approved_by' => 1,
        ]);

        // Ryan Wilson - English Conversation (Pending Payment)
        $ryan = $students->where('student_id', 'STU003')->first();
        $englishClass = $classRooms->where('name', 'English Conversation')->first();
        
        Payment::create([
            'student_id' => $ryan->id,
            'class_room_id' => $englishClass->id,
            'amount' => $englishClass->price,
            'payment_method' => 'bank_transfer',
            'transaction_id' => 'TXN001234569',
            'status' => 'pending',
            'notes' => 'Payment for English Conversation course',
        ]);

        // Sophia Brown - Organic Chemistry (Approved)
        $sophia = $students->where('student_id', 'STU004')->first();
        $chemClass = $classRooms->where('name', 'Organic Chemistry')->first();
        $sophia->classRooms()->attach($chemClass->id);
        
        Payment::create([
            'student_id' => $sophia->id,
            'class_room_id' => $chemClass->id,
            'amount' => $chemClass->price,
            'payment_method' => 'cash',
            'status' => 'approved',
            'notes' => 'Cash payment for Organic Chemistry course',
            'approved_at' => now(),
            'approved_by' => 1,
        ]);

        // Lucas Miller - General Mathematics (Free class)
        $lucas = $students->where('student_id', 'STU005')->first();
        $generalMathClass = $classRooms->where('name', 'General Mathematics')->first();
        $lucas->classRooms()->attach($generalMathClass->id);

        // Olivia Garcia - Basic English (Free class)
        $olivia = $students->where('student_id', 'STU006')->first();
        $basicEnglishClass = $classRooms->where('name', 'Basic English')->first();
        $olivia->classRooms()->attach($basicEnglishClass->id);

        // Additional pending payment
        Payment::create([
            'student_id' => $lucas->id,
            'class_room_id' => $mathClass->id,
            'amount' => $mathClass->price,
            'payment_method' => 'bank_transfer',
            'transaction_id' => 'TXN001234570',
            'status' => 'pending',
            'notes' => 'Lucas wants to upgrade to Advanced Mathematics',
        ]);

        $this->command->info('Sample data created successfully!');
        $this->command->info('Teachers: 4 created');
        $this->command->info('Students: 6 created');
        $this->command->info('Classes: 6 created');
        $this->command->info('Payments: 5 created');
        $this->command->info('Student enrollments: 5 created');
    }
}
