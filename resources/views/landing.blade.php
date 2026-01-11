<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PAUD Terpadu Cerdas - Pendidikan Anak Usia Dini yang berkualitas dengan kurikulum terpadu untuk mengembangkan potensi anak secara optimal">
    <meta name="keywords" content="PAUD, Pendidikan Anak Usia Dini, PAUD Terpadu, PAUD Cerdas, Tabungan Siswa, SPP PAUD">
    <title>PAUD Terpadu Cerdas | Pendidikan Berkualitas untuk Anak Usia Dini</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('logo-paud.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4facfe;
            --primary-dark: #00c6ff;
            --secondary: #667eea;
            --accent: #f093fb;
            --success: #00d68f;
            --warning: #ffaa00;
            --danger: #ff3d71;
            --dark: #2c3e50;
            --light: #f8f9fa;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-3: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.12);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.16);
            --shadow-xl: 0 24px 64px rgba(0,0,0,0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            background: transparent;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,0.98);
            box-shadow: var(--shadow-md);
            padding: 0.75rem 5%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }

        .navbar.scrolled .navbar-brand {
            color: var(--dark);
        }

        .navbar-brand img {
            height: 45px;
            width: 45px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
            padding: 3px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar.scrolled .nav-links a {
            color: var(--dark);
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--gradient-2);
            color: white;
            box-shadow: 0 4px 15px rgba(79,172,254,0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,172,254,0.5);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
        }

        .navbar.scrolled .btn-outline {
            border-color: var(--secondary);
            color: var(--secondary);
        }

        .btn-outline:hover {
            background: white;
            color: var(--secondary);
        }

        .navbar.scrolled .btn-outline:hover {
            background: var(--secondary);
            color: white;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .navbar.scrolled .mobile-menu-btn {
            color: var(--dark);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: var(--gradient-hero);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 5% 4rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,181.3C960,181,1056,139,1152,128C1248,117,1344,139,1392,149.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom;
            background-size: cover;
            pointer-events: none;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-text h1 span {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
        }

        .hero-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            min-width: 100px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }

        .stat-label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
        }

        /* Floating Elements */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.2;
            animation: floatShape 8s ease-in-out infinite;
        }

        .shape-1 {
            width: 100px;
            height: 100px;
            background: var(--accent);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            background: var(--warning);
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            background: var(--success);
            bottom: 20%;
            left: 5%;
            animation-delay: 4s;
        }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, -20px) rotate(90deg); }
            50% { transform: translate(0, -30px) rotate(180deg); }
            75% { transform: translate(-20px, -10px) rotate(270deg); }
        }

        /* Section Styles */
        section {
            padding: 5rem 5%;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 4rem;
        }

        .section-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(240,147,251,0.1) 100%);
            color: var(--secondary);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* About Section */
        .about {
            background: var(--light);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }

        .about-image::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid var(--secondary);
            border-radius: 20px;
            z-index: -1;
        }

        .about-text h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .about-text p {
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .about-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .about-feature i {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-2);
            color: white;
            border-radius: 50%;
            font-size: 0.9rem;
        }

        .about-feature span {
            font-weight: 500;
            color: var(--dark);
        }

        /* Programs Section */
        .programs {
            background: white;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .program-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .program-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
        }

        .program-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(240,147,251,0.1) 100%);
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .program-icon i {
            font-size: 2rem;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .program-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .program-card p {
            color: #6c757d;
            line-height: 1.7;
        }

        /* Features Section */
        .features {
            background: var(--gradient-hero);
            color: white;
        }

        .features .section-title {
            color: white;
        }

        .features .section-subtitle {
            color: rgba(255,255,255,0.8);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .feature-card:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }

        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta {
            background: white;
            text-align: center;
        }

        .cta-box {
            background: var(--gradient-2);
            border-radius: 30px;
            padding: 4rem;
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-box h2 {
            font-size: 2.2rem;
            color: white;
            margin-bottom: 1rem;
        }

        .cta-box p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: var(--secondary);
            font-weight: 600;
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        /* Contact Section */
        .contact {
            background: var(--light);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .contact-card i {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-1);
            color: white;
            border-radius: 50%;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        .contact-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .contact-card p {
            color: #6c757d;
        }

        .contact-card a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 4rem 5% 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-brand img {
            height: 60px;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
        }

        .footer-links h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255,255,255,0.6);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-stats {
                justify-content: center;
            }

            .hero-image {
                order: -1;
            }

            .hero-image img {
                max-width: 350px;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .cta-box {
                padding: 2rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <a href="#" class="navbar-brand">
            <img src="{{ asset('logo-paud.png') }}" alt="Logo PAUD Terpadu Cerdas">
            <span>PAUD Terpadu Cerdas</span>
        </a>

        <ul class="nav-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#tentang">Tentang Kami</a></li>
            <li><a href="#program">Program</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('login') }}" class="btn btn-outline">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
        </div>

        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>

        <div class="hero-content">
            <div class="hero-text">
                <h1>Membangun Generasi <span>Cerdas dan Berkarakter</span></h1>
                <p>
                    PAUD Terpadu Cerdas hadir untuk memberikan pendidikan berkualitas bagi anak usia dini.
                    Dengan kurikulum terpadu dan metode pembelajaran yang menyenangkan, kami membantu
                    mengembangkan potensi anak secara optimal.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-user-graduate"></i>
                        Portal Orang Tua
                    </a>
                    <a href="#tentang" class="btn btn-outline">
                        <i class="fas fa-info-circle"></i>
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Siswa Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15</div>
                        <div class="stat-label">Guru Terlatih</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" alt="Anak-anak belajar di PAUD">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="tentang">
        <div class="about-content">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" alt="Tentang PAUD Terpadu Cerdas">
            </div>

            <div class="about-text">
                <span class="section-badge">Tentang Kami</span>
                <h2>Pendidikan Anak Usia Dini yang Berkualitas</h2>
                <p>
                    PAUD Terpadu Cerdas adalah lembaga pendidikan anak usia dini yang berkomitmen untuk
                    memberikan pendidikan holistik dengan menggabungkan aspek kognitif, afektif, dan
                    psikomotorik dalam setiap kegiatan pembelajaran.
                </p>
                <p>
                    Dengan menerapkan Kurikulum 2013 yang dipadukan dengan metode pembelajaran berbasis
                    bermain, kami menciptakan lingkungan belajar yang aman, nyaman, dan menyenangkan
                    bagi setiap anak.
                </p>

                <div class="about-features">
                    <div class="about-feature">
                        <i class="fas fa-check"></i>
                        <span>Kurikulum Terpadu</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check"></i>
                        <span>Guru Bersertifikat</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check"></i>
                        <span>Fasilitas Lengkap</span>
                    </div>
                    <div class="about-feature">
                        <i class="fas fa-check"></i>
                        <span>Akreditasi B</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs" id="program">
        <div class="section-header">
            <span class="section-badge">Program Kami</span>
            <h2 class="section-title">Program Pendidikan Unggulan</h2>
            <p class="section-subtitle">
                Berbagai program pembelajaran yang dirancang khusus untuk mengembangkan potensi anak secara optimal
            </p>
        </div>

        <div class="programs-grid">
            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>Kelompok Bermain (KB)</h3>
                <p>
                    Program untuk anak usia 2-4 tahun dengan fokus pada stimulasi motorik, bahasa,
                    dan sosial-emosional melalui kegiatan bermain yang terarah.
                </p>
            </div>

            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Taman Kanak-kanak (TK)</h3>
                <p>
                    Program untuk anak usia 4-6 tahun dengan pembelajaran tematik terintegrasi
                    yang mempersiapkan anak memasuki jenjang pendidikan dasar.
                </p>
            </div>

            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-quran"></i>
                </div>
                <h3>Pendidikan Agama</h3>
                <p>
                    Program pengenalan nilai-nilai keagamaan dan moral sejak dini melalui
                    kegiatan yang menyenangkan dan sesuai usia anak.
                </p>
            </div>

            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Seni & Kreativitas</h3>
                <p>
                    Program pengembangan kreativitas melalui seni rupa, musik, dan tari
                    untuk mengasah bakat dan minat anak.
                </p>
            </div>

            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-running"></i>
                </div>
                <h3>Motorik & Olahraga</h3>
                <p>
                    Program pengembangan motorik kasar dan halus melalui berbagai
                    aktivitas fisik dan permainan outdoor.
                </p>
            </div>

            <div class="program-card">
                <div class="program-icon">
                    <i class="fas fa-language"></i>
                </div>
                <h3>Pengenalan Bahasa</h3>
                <p>
                    Program pengenalan bahasa Indonesia dan Inggris dasar untuk
                    membangun fondasi literasi sejak dini.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="layanan">
        <div class="section-header">
            <span class="section-badge" style="background: rgba(255,255,255,0.2); color: white;">Layanan</span>
            <h2 class="section-title">Sistem Tabungan & SPP Digital</h2>
            <p class="section-subtitle">
                Kemudahan bagi orang tua dalam mengelola keuangan pendidikan anak
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-piggy-bank"></i>
                <h4>Tabungan Siswa</h4>
                <p>Simpan tabungan anak dengan mudah dan pantau saldo kapan saja</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-file-invoice-dollar"></i>
                <h4>Pembayaran SPP</h4>
                <p>Bayar SPP secara online dengan berbagai metode pembayaran</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-history"></i>
                <h4>Riwayat Transaksi</h4>
                <p>Lihat catatan lengkap semua transaksi tabungan dan pembayaran</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-bell"></i>
                <h4>Notifikasi</h4>
                <p>Dapatkan pengingat untuk pembayaran SPP yang jatuh tempo</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h4>Laporan Keuangan</h4>
                <p>Akses laporan keuangan bulanan untuk transparansi</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-shield-alt"></i>
                <h4>Keamanan Terjamin</h4>
                <p>Data dan transaksi dilindungi dengan enkripsi tingkat tinggi</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-box">
            <h2>Siap Bergabung dengan Kami?</h2>
            <p>
                Daftarkan putra-putri Anda segera dan berikan pendidikan terbaik untuk masa depan mereka.
                Tim kami siap membantu proses pendaftaran Anda.
            </p>
            <div class="cta-buttons">
                <a href="#kontak" class="btn btn-white">
                    <i class="fas fa-phone"></i>
                    Hubungi Kami
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline" style="border-color: white; color: white;">
                    <i class="fas fa-sign-in-alt"></i>
                    Login Portal
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="kontak">
        <div class="section-header">
            <span class="section-badge">Kontak</span>
            <h2 class="section-title">Hubungi Kami</h2>
            <p class="section-subtitle">
                Kami siap membantu menjawab pertanyaan Anda seputar pendaftaran dan informasi lainnya
            </p>
        </div>

        <div class="contact-grid">
            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Alamat</h4>
                <p>Jl. Pendidikan No. 123<br>Kota, Provinsi 12345</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-phone-alt"></i>
                <h4>Telepon</h4>
                <p><a href="tel:+6281234567890">+62 812-3456-7890</a></p>
            </div>

            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h4>Email</h4>
                <p><a href="mailto:info@paudterpaducerdas.sch.id">info@paudterpaducerdas.sch.id</a></p>
            </div>

            <div class="contact-card">
                <i class="fas fa-clock"></i>
                <h4>Jam Operasional</h4>
                <p>Senin - Jumat<br>07:30 - 11:30 WIB</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <img src="{{ asset('logo-paud.png') }}" alt="Logo PAUD Terpadu Cerdas">
                <p>
                    PAUD Terpadu Cerdas berkomitmen untuk memberikan pendidikan berkualitas
                    bagi anak usia dini dengan metode pembelajaran yang menyenangkan dan
                    lingkungan yang kondusif.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h5>Navigasi</h5>
                <ul>
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#program">Program</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h5>Layanan</h5>
                <ul>
                    <li><a href="{{ route('login') }}">Portal Orang Tua</a></li>
                    <li><a href="#">Tabungan Siswa</a></li>
                    <li><a href="#">Pembayaran SPP</a></li>
                    <li><a href="#">Laporan Keuangan</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h5>Informasi</h5>
                <ul>
                    <li><a href="#">Pendaftaran</a></li>
                    <li><a href="#">Kalender Akademik</a></li>
                    <li><a href="#">Biaya Pendidikan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} PAUD Terpadu Cerdas. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.querySelector('.nav-links');

        mobileMenuBtn.addEventListener('click', () => {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });

        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.program-card, .feature-card, .contact-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>
