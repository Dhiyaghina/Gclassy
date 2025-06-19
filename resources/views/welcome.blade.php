<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GClassy - Platform E-Learning</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #6b46c1;
        }

        .btn-masuk {
            background: #6b46c1;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-masuk:hover {
            background: #553c9a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 70, 193, 0.4);
        }

        /* Main Content */
        .main-content {
            padding: 60px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 80vh;
        }

        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 80px;
        }

        .hero-text {
            max-width: 500px;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-cari {
            background: white;
            border: 2px solid #e2e8f0;
            padding: 12px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-cari:hover {
            border-color: #6b46c1;
            color: #6b46c1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-cari-primary {
            background: #6b46c1;
            color: white;
            border-color: #6b46c1;
        }

        .btn-cari-primary:hover {
            background: #553c9a;
            color: white;
        }

        .hero-illustration {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 400px;
        }

        /* Illustration Elements */
        .laptop {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 280px;
            height: 180px;
            background: #2d3748;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .laptop::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 40px;
            background: #4299e1;
            border-radius: 8px;
        }

        .laptop::after {
            content: '🎓 LIVE';
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            background: #e53e3e;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .teacher {
            position: absolute;
            top: 20%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: #48bb78;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        .teacher::before {
            content: '👩‍🏫';
        }

        .student1 {
            position: absolute;
            bottom: 10%;
            left: 5%;
            width: 60px;
            height: 60px;
            background: #ed8936;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(237, 137, 54, 0.3);
            animation: float 3s ease-in-out infinite 0.5s;
        }

        .student1::before {
            content: '👨‍💻';
        }

        .student2 {
            position: absolute;
            bottom: 20%;
            right: 20%;
            width: 60px;
            height: 60px;
            background: #9f7aea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(159, 122, 234, 0.3);
            animation: float 3s ease-in-out infinite 1s;
        }

        .student2::before {
            content: '👩‍💼';
        }

        .chart {
            position: absolute;
            top: 10%;
            left: 10%;
            width: 50px;
            height: 50px;
            background: #4299e1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 3px 10px rgba(66, 153, 225, 0.3);
            animation: bounce 2s ease-in-out infinite;
        }

        .chart::before {
            content: '📊';
        }

        .clock {
            position: absolute;
            top: 30%;
            right: 5%;
            width: 40px;
            height: 40px;
            background: #38b2ac;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 3px 10px rgba(56, 178, 172, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        .clock::before {
            content: '🕐';
        }

        .trophy {
            position: absolute;
            bottom: 5%;
            right: 5%;
            width: 45px;
            height: 45px;
            background: #f6e05e;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 3px 10px rgba(246, 224, 94, 0.3);
            animation: bounce 2s ease-in-out infinite 1.5s;
        }

        .trophy::before {
            content: '🏆';
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Feature Cards */
        .feature-cards {
            background: #6b46c1;
            border-radius: 20px;
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            box-shadow: 0 20px 40px rgba(107, 70, 193, 0.3);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .feature-content h3 {
            color: white;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .feature-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                justify-content: center;
                flex-wrap: wrap;
            }

            .feature-cards {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 30px 20px;
            }

            .illustration-container {
                height: 300px;
            }

            .laptop {
                width: 200px;
                height: 130px;
            }
        }

        @media (max-width: 480px) {
            .nav {
                flex-direction: column;
                gap: 20px;
            }

            .hero-text h1 {
                font-size: 1.8rem;
            }

            .hero-text p {
                font-size: 1rem;
            }

            .btn-cari {
                padding: 10px 16px;
                font-size: 0.9rem;
                min-width: 120px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">GClassy</div>
                <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="hero-section">
                <div class="hero-text">
                    <h1>Selamat Datang di Gclassy</h1>
                    <p>GClassy adalah platform pembelajaran daring yang dirancang untuk membantu siswa belajar dengan lebih fleksibel, terstruktur, dan menyenangkan. Dengan antarmuka yang ramah pengguna, materi yang berkualitas, serta akses yang mudah melalui berbagai perangkat.</p>
                </div>
                <div class="hero-illustration">
                    <div class="illustration-container">
                        <div class="laptop"></div>
                        <div class="teacher"></div>
                        <div class="student1"></div>
                        <div class="student2"></div>
                        <div class="chart"></div>
                        <div class="clock"></div>
                        <div class="trophy"></div>
                    </div>
                </div>
            </div>

            <div class="feature-cards">
                <div class="feature-card">
                    <div class="feature-icon">💻</div>
                    <div class="feature-content">
                        <h3>Melihat Materi</h3>
                        <p>Akses ribuan materi pembelajaran berkualitas yang disusun oleh para ahli</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <div class="feature-content">
                        <h3>Mengumpul Tugas</h3>
                        <p>Sistem pengumpulan tugas yang mudah dan terorganisir dengan baik</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Smooth animations on scroll
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Animate feature cards on load
        document.querySelectorAll('.feature-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            card.style.transitionDelay = `${index * 0.2}s`;
            observer.observe(card);
        });

        // Animate hero elements
        window.addEventListener('load', () => {
            document.querySelector('.hero-text').style.animation = 'slideInLeft 1s ease-out';
            document.querySelector('.hero-illustration').style.animation = 'slideInRight 1s ease-out 0.3s both';
        });

        // Add CSS for load animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>