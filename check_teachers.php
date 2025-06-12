<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== CHECKING TEACHER USERS ===\n";

$teachers = User::where('role', 'teacher')->with('teacher')->get();

echo "Found " . $teachers->count() . " teacher users:\n\n";

foreach ($teachers as $user) {
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    
    if ($user->teacher) {
        echo "Teacher ID: " . $user->teacher->id . "\n";
        echo "Employee ID: " . $user->teacher->employee_id . "\n";
        echo "Subject: " . $user->teacher->subject . "\n";
    } else {
        echo "No teacher profile found!\n";
    }
    
    echo "---\n";
}

echo "\n=== SAMPLE LOGIN INFO ===\n";
if ($teachers->count() > 0) {
    $firstTeacher = $teachers->first();
    echo "You can login with:\n";
    echo "Email: " . $firstTeacher->email . "\n";
    echo "Password: password (default from seeder)\n";
}
