<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="icon" href="data:,">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | eLearning Classy</title>
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

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input {
            width: auto;
            margin-right: 0.75rem;
        }

        .remember-me label {
            margin-bottom: 0;
            color: var(--text-light);
        }

        .btn {
            display: block;
            width: 100%;
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

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .session-status {
            color: var(--primary);
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.875rem;
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

            <h1>Masuk ke eLearning</h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary">Masuk</button>

                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
