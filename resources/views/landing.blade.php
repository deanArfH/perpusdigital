<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            
            /* Light Mode Variables (Default) */
            --bg-color: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #475569;
            --nav-bg: rgba(255, 255, 255, 0.7);
            --nav-border: rgba(0, 0, 0, 0.05);
            --brand-color: #4F46E5;
            --hero-title: #0F172A;
            --overlay-gradient: linear-gradient(to right, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.6) 100%);
            --card-bg: rgba(255, 255, 255, 0.6);
            --card-border: rgba(255, 255, 255, 0.8);
            --card-hover-bg: rgba(255, 255, 255, 0.9);
            --btn-outline-color: var(--primary);
            --btn-outline-border: rgba(79, 70, 229, 0.3);
            --btn-outline-bg: transparent;
            --btn-outline-hover-bg: rgba(79, 70, 229, 0.05);
        }

        html.dark {
            /* Dark Mode Variables */
            --bg-color: #0F172A;
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --nav-bg: rgba(15, 23, 42, 0.4);
            --nav-border: rgba(255, 255, 255, 0.1);
            --brand-color: #FFFFFF;
            --hero-title: #FFFFFF;
            --overlay-gradient: linear-gradient(to right, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.7) 100%);
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.1);
            --card-hover-bg: rgba(255, 255, 255, 0.08);
            --btn-outline-color: #FFFFFF;
            --btn-outline-border: rgba(255, 255, 255, 0.2);
            --btn-outline-bg: rgba(255, 255, 255, 0.1);
            --btn-outline-hover-bg: rgba(255, 255, 255, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Image with Overlay */
        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: -2;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--overlay-gradient);
            z-index: -1;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 8%;
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--nav-border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 800;
            color: var(--brand-color);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .brand svg {
            width: 32px;
            height: 32px;
            color: var(--primary);
        }
        html.dark .brand svg { color: #818CF8; }

        .nav-links {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            transition: all 0.2s;
        }
        .theme-toggle:hover {
            background: rgba(128, 128, 128, 0.1);
            color: var(--text-main);
        }
        
        .icon-sun { display: none; }
        .icon-moon { display: block; }
        html.dark .icon-sun { display: block; }
        html.dark .icon-moon { display: none; }

        .btn {
            padding: 12px 28px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-outline {
            color: var(--btn-outline-color);
            background: var(--btn-outline-bg);
            border: 1px solid var(--btn-outline-border);
        }

        .btn-outline:hover {
            background: var(--btn-outline-hover-bg);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 8%;
            max-width: 1400px;
            margin: 0 auto;
            gap: 60px;
        }

        .hero-content {
            flex: 1;
            max-width: 650px;
            animation: slideRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 32px;
            letter-spacing: 0.5px;
        }
        html.dark .badge {
            background: rgba(129, 140, 248, 0.15);
            color: #818CF8;
            border-color: rgba(129, 140, 248, 0.3);
        }
        
        .badge span {
            display: block;
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary);
        }
        html.dark .badge span { background: #818CF8; box-shadow: 0 0 10px #818CF8; }

        .hero h1 {
            font-size: clamp(48px, 5.5vw, 72px);
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 24px;
            letter-spacing: -1.5px;
            color: var(--hero-title);
        }

        .hero h1 span {
            background: linear-gradient(135deg, #4F46E5 0%, #0EA5E9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        html.dark .hero h1 span { background: linear-gradient(135deg, #818CF8 0%, #C084FC 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .hero p {
            font-size: clamp(16px, 1.5vw, 20px);
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 48px;
            font-weight: 400;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-buttons .btn {
            padding: 20px 48px;
            font-size: 20px;
        }

        /* Feature Cards (Preview) */
        .hero-visual {
            flex: 1;
            display: grid;
            gap: 24px;
            animation: slideLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes slideLeft {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .feature-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 32px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .feature-card:hover {
            background: var(--card-hover-bg);
            transform: translateY(-5px);
            border-color: rgba(79, 70, 229, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        html.dark .feature-card { box-shadow: none; }
        html.dark .feature-card:hover { border-color: rgba(129, 140, 248, 0.5); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        html.dark .feature-icon { background: rgba(129, 140, 248, 0.2); color: #818CF8; }
        
        .feature-icon svg {
            width: 28px;
            height: 28px;
        }

        .feature-text h3 {
            color: var(--text-main);
            font-size: 20px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .feature-text p {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        @media (max-width: 1024px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 40px;
            }
            .hero-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .hero-buttons {
                justify-content: center;
            }
            .feature-card {
                text-align: left;
            }
        }

        @media (max-width: 640px) {
            nav {
                flex-direction: column;
                gap: 16px;
                padding: 16px;
            }
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }
            .hero-buttons .btn {
                width: 100%;
            }
            .feature-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    
    <script>
        // Check local storage for Filament theme preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <nav>
        <a href="/" class="brand">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 17.25c1.74 0 3.336.599 4.5 1.581v-14.3Zm8.5-1.533a9.707 9.707 0 0 0-5.25 1.533v14.3c1.164-.982 2.76-1.581 4.5-1.581a8.237 8.237 0 0 1 2.75.467 1 1 0 0 0 1-.707V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 19.75 3Z" /></svg>
            Perpustakaan Cerdas
        </a>
        <div class="nav-links">
            <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle Theme">
                <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
            </button>
            <a href="/admin/login" class="btn btn-outline">Masuk</a>
            <a href="/siswa/register" class="btn btn-primary">Daftar Sekarang</a>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <div class="badge"><span></span> Platform Edukasi Digital</div>
            <h1>Buka Gerbang <span>Ilmu Pengetahuan</span></h1>
            <p>Sistem Informasi Perpustakaan revolusioner yang dirancang khusus untuk mempermudah pengalaman membaca Anda. Cari, pesan, dan pinjam buku favorit Anda tanpa perlu antre panjang.</p>
            <div class="hero-buttons">
                <a href="/admin/login" class="btn btn-primary">Mulai Akses Buku</a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="feature-card" style="animation-delay: 0.2s;">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="feature-text">
                    <h3>Koleksi Terbaik</h3>
                    <p>Akses ribuan buku digital dan fisik dari berbagai kategori yang terus diperbarui setiap harinya.</p>
                </div>
            </div>
            
            <div class="feature-card" style="animation-delay: 0.4s;">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="feature-text">
                    <h3>Peminjaman Instan</h3>
                    <p>Sistem pencatatan terotomatisasi membuat proses pinjam meminjam buku selesai dalam hitungan detik.</p>
                </div>
            </div>
            
            <div class="feature-card" style="animation-delay: 0.6s;">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2.25m0 0v2.25m0-2.25h2.25m-2.25 0H9.75m10.125-9.75a.75.75 0 0 0-1.5 0v2.25a.75.75 0 0 0 1.5 0v-2.25Zm-10.125 0a.75.75 0 0 0-1.5 0v2.25a.75.75 0 0 0 1.5 0v-2.25Z"/></svg>
                </div>
                <div class="feature-text">
                    <h3>Denda</h3>
                    <p>Sistem manajemen denda yang dikalkulasi secara otomatis, akurat, dan transparan untuk setiap keterlambatan.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>
