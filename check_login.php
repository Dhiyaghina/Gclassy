<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== TEACHER LOGIN CREDENTIALS ===\n\n";

$teachers = User::where('role', 'teacher')->with('teacher')->get();

foreach ($teachers as $user) {
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Password: password\n";
    echo "Subject: " . ($user->teacher ? $user->teacher->subject : 'N/A') . "\n";
    echo "---\n";
}

echo "\n=== TRY LOGGING IN WITH: ===\n";
echo "Email: sarah.johnson@teacher.com\n";
echo "Password: password\n";
echo "URL: http://127.0.0.1:8001\n";
