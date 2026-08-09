<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SI Kesiswaan - Sistem Informasi Kesiswaan</title>
    <link rel="icon" href="<?= base_url('logo-sekolah.png') ?>" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand .brand-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-brand .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .nav-link {
            font-weight: 500;
            margin: 0 1rem;
            color: #333 !important;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #667eea !important;
            transform: translateY(-2px);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.6rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-buttons {
            animation: fadeInUp 1s ease 0.4s backwards;
        }

        .btn-primary-custom {
            background: white;
            color: #667eea;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            margin-right: 1rem;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .btn-outline-custom {
            background: transparent;
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid white;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        .hero-image img {
            max-width: 320px;
            width: 100%;
            height: auto;
        }

        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: #f8f9fa;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-text {
            color: #666;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem 0;
            color: white;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }
        .footer-logo {
            width: 22px;
            height: 22px;
            object-fit: contain;
            margin-right: 8px;
            vertical-align: -4px;
        }

        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.7rem;
            transition: all 0.3s;
        }

        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .btn-primary-custom, .btn-outline-custom {
                padding: 0.8rem 2rem;
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="brand-logo" src="<?= base_url('logo-sekolah.png') ?>" alt="Logo">
                <span class="brand-text">SI Kesiswaan</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistik">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <a href="auth" class="btn btn-login ms-3">
                    <i class="bi bi-box-arrow-in-right"></i> LOGIN
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Kelola Kegiatan Kesiswaan <span style="color: #ffd700;"> SMP Islam Al-Muhajirin</span></h1>
                    <p class="hero-subtitle">
                        Sistem informasi terintegrasi untuk manajemen kegiatan, prestasi, dan dokumen akreditasi kesiswaan
                    </p>
                    <div class="hero-buttons">
                        <a href="auth" class="btn btn-primary-custom">
                            Mulai Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#fitur" class="btn btn-outline-custom">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <img src="<?= base_url('logo-sekolah.png') ?>" alt="Logo Sekolah">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <h2 class="section-title">Fitur</h2>
            <!-- <p class="section-subtitle">Solusi lengkap untuk kebutuhan manajemen kesiswaan Anda</p> -->
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Kegiatan</h3>
                        <p class="feature-text">Kelola semua kegiatan kesiswaan dari perencanaan hingga pelaporan lengkap dengan dokumentasi untuk keperluan akreditasi.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <h3 class="feature-title">Prestasi</h3>
                        <p class="feature-text">Catat dan dokumentasikan prestasi siswa sebagai bukti fisik akreditasi dengan sistem yang terstruktur dan mudah diakses.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                        <h3 class="feature-title">Dokumen Akreditasi</h3>
                        <p class="feature-text">Kelola dokumen akreditasi dengan sistem tracking kelengkapan dan status verifikasi secara real-time.</p>
                    </div>
                </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="statistik">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?= isset($stat_kegiatan) ? number_format($stat_kegiatan) : '0' ?></div>
                        <div class="stat-label">Total Kegiatan</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?= isset($stat_prestasi) ? number_format($stat_prestasi) : '0' ?></div>
                        <div class="stat-label">Total Prestasi</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?= isset($stat_program) ? number_format($stat_program) : '0' ?></div>
                        <div class="stat-label">Total Program Kerja OSIS</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number"><?= isset($stat_kepuasan) ? number_format($stat_kepuasan) : '0' ?></div>
                        <div class="stat-label">Terverifikasi</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">
                        <img class="footer-logo" src="<?= base_url('logo-sekolah.png') ?>" alt="Logo">SI Kesiswaan
                    </h5>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.7;">
                        Sistem Informasi Kesiswaan yang memudahkan pengelolaan kegiatan, prestasi, dan dokumen akreditasi secara terintegrasi.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/smpi.almuhajirin/" class="social-icon" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Quick Links</h5>
                    <a href="#home" class="footer-link">Home</a>
                    <a href="#fitur" class="footer-link">Fitur</a>
                    <a href="#statistik" class="footer-link">Statistik</a>

                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Kontak Kami</h5>
                    <p style="color: rgba(255,255,255,0.7);">
                        <i class="bi bi-geo-alt-fill"></i>Jl. Pedurenan 3 No.36, Padurenan, Kec. Gn. Sindur<br>
                        Kabupaten Bogor, Jawa Barat 16340<br><br>
                        <!-- <i class="bi bi-envelope-fill"></i> info@sikesiswaan.sch.id<br> -->
                        <i class="bi bi-telephone-fill"></i> 0813-1747-4371
                    </p>
                </div>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.1); margin: 2rem 0 1rem;">
            
            <div class="text-center" style="color: rgba(255,255,255,0.7);">
                <p class="mb-0">&copy; 2026 SI Kesiswaan. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
