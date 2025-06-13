<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="icon" href="data:,">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eLearning Classy</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --text: #1f2937;
            --bg: #f9fafb;
            --card-bg: #ffffff;
            --border: #e5e7eb;
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
            padding: 2.5rem;
            text-align: center;
        }

        .logo {
            margin-bottom: 1.5rem;
        }

        .logo svg {
            height: 3rem;
            fill: var(--primary);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        p {
            color: var(--text);
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            text-align: center;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary);
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

            <h1>eLearning Classy</h1>
            <p>Selamat datang di sistem eLearning kami</p>

            <div class="btn-group">
                <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>
