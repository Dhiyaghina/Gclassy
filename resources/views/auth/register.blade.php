<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="icon" href="data:,">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | eLearning Classy</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --text: #1f2937;
            --text-light: #6b7280;
            --bg: #f9fafb;
            --card-bg: #ffffff;
            --border: #e5e7eb;
            --error: #ef4444;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 24rem;
            padding: 1rem;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo svg {
            height: 3rem;
            fill: var(--primary);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text);
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 1rem;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: rgba(79, 70, 229, 0.05);
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    <path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                </svg>
            </div>

            <h1>Buat Akun Baru</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>

                <div class="login-link">
                    <a href="{{ route('login') }}">Sudah punya akun? Masuk disini</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
