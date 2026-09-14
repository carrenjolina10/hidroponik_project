<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Monitoring Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =========================================================
           HARVEST-STYLE REDESIGN
           Blok ini menimpa/mendefinisikan ulang seluruh class yang
           dipakai halaman ini (sidebar, header, cards, chart-card,
           status-card, dst.) supaya tampilannya menyerupai Harvest
           Dashboard: kartu putih membulat, sidebar hijau tua + lime,
           topbar rounded, ikon dalam lingkaran warna. Ditaruh setelah
           <link css/style.css> sehingga otomatis menang di cascade
           tanpa perlu mengubah file css eksternal.
        ========================================================= */
        :root {
            --primary: #c6f24e;
            --secondary: #9be32e;
            --bg: #eef3e9;
            --card: #ffffff;
            --dark: #0e2913;
            --darker: #163a1c;
            --text: #14251a;
            --text-light: #7c8a80;
            --line: #e7ede2;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
            --info: #4299e1;
            --radius: 18px;
            --shadow: 0 1px 2px rgba(14, 41, 19, 0.05);
            --shadow-hover: 0 10px 26px rgba(14, 41, 19, 0.10);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--secondary); }

        /* soft background blobs, dijaga tetap ringan */
        .bg-decoration { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .bg-decoration::before,
        .bg-decoration::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.35;
            filter: blur(90px);
        }
        .bg-decoration::before {
            width: 560px; height: 560px;
            background: var(--primary);
            top: -220px; right: -120px;
        }
        .bg-decoration::after {
            width: 480px; height: 480px;
            background: var(--darker);
            bottom: -180px; left: -120px;
        }

        .container {
            display: flex;
            min-height: 100vh;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        /* ---------------- SIDEBAR ---------------- */
        .sidebar {
            width: 260px;
            background: var(--dark);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
        }

        .sidebar img {
            max-width: 165px;
            margin-bottom: 2.25rem;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar nav a {
            text-decoration: none;
            color: #b7c4b3;
            padding: 12px 14px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14.5px;
            transition: background .15s ease, color .15s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar nav a .nav-icon {
            width: 18px; height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            opacity: .9;
        }
        .sidebar nav a .nav-icon svg { width: 18px; height: 18px; }

        .sidebar nav a:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #eef3e9;
        }

        .sidebar nav a.active {
            background: var(--primary);
            color: var(--dark);
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(198, 242, 78, 0.25);
        }

        /* ---------------- MAIN ---------------- */
        .main {
            flex: 1;
            margin-left: 260px;
            padding: 26px 30px 34px;
            width: 100%;
            max-width: calc(100% - 260px);
        }

        /* ---------------- HEADER / TOPBAR ---------------- */
        .header {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px 26px;
            margin-bottom: 22px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
        }

        .header-text h1 {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.3px;
            margin-bottom: 3px;
        }

        .header-text p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 50px;
            background: rgba(72, 187, 120, 0.12);
            color: var(--success);
            font-weight: 700;
            font-size: 13px;
        }

        .status-badge::before {
            content: '';
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.5);
            animation: pulseDot 1.8s infinite;
        }

        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.45); }
            70% { box-shadow: 0 0 0 8px rgba(72, 187, 120, 0); }
            100% { box-shadow: 0 0 0 0 rgba(72, 187, 120, 0); }
        }

        .profile-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg);
            border-radius: 50px;
            padding: 6px 16px 6px 6px;
        }

        .profile-chip .avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f7b955, #f28c45);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
        }

        .profile-chip b { display: block; font-size: 13px; font-weight: 700; line-height: 1.15; }
        .profile-chip span { display: block; font-size: 11px; color: var(--text-light); }

        /* ---------------- STAT CARDS ---------------- */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: var(--shadow);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
            color: var(--dark);
        }
        .card-icon svg { width: 21px; height: 21px; }

        .cards .card:nth-child(1) .card-icon { background: linear-gradient(135deg, #ffe0c2, #ffc38a); }
        .cards .card:nth-child(2) .card-icon { background: linear-gradient(135deg, #cfe8ff, #a9d4ff); }
        .cards .card:nth-child(3) .card-icon { background: linear-gradient(135deg, #ead6ff, #d6b8ff); }
        .cards .card:nth-child(4) .card-icon { background: linear-gradient(135deg, #eaffb8, #c6f24e); }

        .card h3 {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .card h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .card-trend {
            font-size: 12.5px;
            font-weight: 600;
        }

        /* ---------------- CHART CARDS ---------------- */
        .dashboard-charts {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .chart-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .chart-header { margin-bottom: 18px; }

        .chart-header h3 {
            font-size: 16.5px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .chart-header p {
            font-size: 12.5px;
            color: var(--text-light);
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 320px;
        }

        /* ---------------- STATUS CARD ---------------- */
        .status-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .status-card h3 {
            font-size: 16.5px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 16px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .status-item {
            background: var(--bg);
            border-radius: 14px;
            padding: 16px 18px;
        }

        .status-item span {
            display: block;
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .status-item h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
        }

        /* ---------------- FADE-IN ---------------- */
        .fade-in { animation: fadeIn 0.5s ease-out forwards; opacity: 0; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: .05s; transform: translateY(14px); }
        .delay-2 { animation-delay: .1s; transform: translateY(14px); }
        .delay-3 { animation-delay: .15s; transform: translateY(14px); }
        .delay-4 { animation-delay: .2s; transform: translateY(14px); }

        /* ---------------- MOBILE MENU ---------------- */
        .mobile-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 10px;
            background: var(--dark);
            color: var(--primary);
            cursor: pointer;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(14, 41, 19, 0.25);
        }

        .mobile-menu-toggle:hover { background: var(--darker); }

        @media (max-width: 800px) {
            .mobile-menu-toggle {
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 1001;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(14, 41, 19, 0.45);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.active { display: block; opacity: 1; }

        /* =========================================================
           RESPONSIVE — SIDEBAR & LAYOUT UNTUK <= 800px
        ========================================================= */
        @media (max-width: 800px) {
            .container,
            .main,
            .content,
            .fade-in {
                transform: none !important;
                filter: none !important;
                perspective: none !important;
                will-change: auto !important;
            }

            .container { display: block !important; }

            .sidebar {
                position: fixed !important;
                top: 0 !important; left: 0 !important; bottom: 0 !important; right: auto !important;
                width: 78vw !important;
                max-width: 280px !important;
                height: 100vh !important;
                z-index: 99999 !important;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                overflow-y: auto;
                background: var(--dark) !important;
                opacity: 1 !important;
                backdrop-filter: none !important;
                box-shadow: 6px 0 30px rgba(0, 0, 0, 0.35);
            }

            .sidebar.active {
                transform: translateX(0);
                z-index: 99999 !important;
            }

            .main {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 18px 16px !important;
            }

            .mobile-menu-toggle { display: flex; }

            .header {
                padding: 16px 16px 16px 58px;
            }

            .header-text h1 { font-size: 19px; }
            .header-actions { width: 100%; }

            .cards { grid-template-columns: repeat(2, 1fr); gap: 14px; }

            .chart-card, .status-card { padding: 18px; }

            .status-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }

            .dashboard-charts { gap: 14px; }

            .chart-container { height: 260px; }
        }

        @media (max-width: 480px) {
            .cards { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr; }
            .chart-card, .status-card, .card { padding: 16px; border-radius: 14px; }
            .profile-chip span { display: none; }
        }
    </style>
</head>

<body>

    <div class="bg-decoration"></div>

    <!-- overlay gelap saat sidebar mobile terbuka -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container">

        <aside class="sidebar" id="sidebar">

        <img src="{{ asset('image/bagus_hidro_logo.png') }}" alt="Hidroponik BAGUS">


        <nav>

            <a href="{{ route('index.index') }}" class="active">
                    <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
                    Dashboard
                </a>
                <a href="{{ route('data') }}">
                    <span class="nav-icon"><i data-lucide="history"></i></span>
                    History
                </a>
                <a href="{{ url('/ai') }}">
                    <span class="nav-icon"><i data-lucide="scan-search"></i></span>
                    AI Detection
                </a>
                <a href="{{ url('/control') }}" >
                <span class="nav-icon">
                    <i data-lucide="sliders-horizontal"></i>
                </span>
                Control
                </a>
                <a href="{{ route('index.create') }}">
                    <span class="nav-icon"><i data-lucide="file-plus-2"></i></span>
                    New Data
                </a>
                <a href="{{ route('lettuce.guide') }}" >
                    <span class="nav-icon"><i data-lucide="sprout"></i></span>
                    Lettuce Guide
                </a>

        </nav>

    </aside>

        <main class="main">

            <header class="header fade-in delay-1">

                <button
                    type="button"
                    class="mobile-menu-toggle"
                    id="mobileMenuToggle"
                    aria-label="Buka menu"
                >
                    <i data-lucide="menu"></i>
                </button>

                <div class="header-text">
                    <h1>Hydroponic Monitoring</h1>
                    <p>Real-Time Plant Health Analysis</p>
                </div>
                <div class="header-actions">
                    <div class="status-badge">System Online</div>
                    <div class="profile-chip">
                        <div class="avatar">🧑‍🌾</div>
                        <div>
                            <b>Hidroponik Bagus</b>
                            <span>Greenhouse Monitor</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="cards">
                <div class="card fade-in delay-1">
                    <div class="card-icon"><i data-lucide="thermometer"></i></div>
                    <h3>Temperature</h3>
                    <h2 id="cardTemperature">-°C</h2>
                    <div class="card-trend" id="cardTemperatureTrend">-</div>
                </div>

                <div class="card fade-in delay-2">
                    <div class="card-icon"><i data-lucide="droplets"></i></div>
                    <h3>pH Water</h3>
                    <h2 id="cardPh">-</h2>
                    <div class="card-trend" id="cardPhTrend">-</div>
                </div>

                <div class="card fade-in delay-3">
                    <div class="card-icon"><i data-lucide="test-tube-diagonal"></i></div>
                    <h3>Nutrient</h3>
                    <h2 id="cardNutrient">- ppm</h2>
                    <div class="card-trend" id="cardNutrientTrend">-</div>
                </div>

                <div class="card fade-in delay-4">
                    <div class="card-icon"><i data-lucide="heart-pulse"></i></div>
                    <h3>Health Score</h3>
                    <h2 id="cardHealth">-%</h2>
                    <div class="card-trend" id="cardHealthTrend">-</div>
                </div>

            </section>

            <section class="dashboard-charts">

    <!-- HEALTH TREND -->
    <div class="chart-card fade-in delay-4">

        <div class="chart-header">
            <div>
                <h3>🌱 Plant Health Trend</h3>
                <p>Perkembangan kesehatan tanaman berdasarkan histori sensor</p>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="healthTrendChart"></canvas>
        </div>

    </div>


    <!-- SENSOR TREND -->
    <div class="chart-card fade-in delay-4">

        <div class="chart-header">
            <div>
                <h3>📊 Sensor Trend</h3>
                <p>Perubahan parameter lingkungan dari waktu ke waktu</p>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="sensorTrendChart"></canvas>
        </div>

    </div>

</section>

            

            <section class="status-card fade-in delay-4">
                <h3>Plant Status</h3>
                <div class="status-grid">
                    <div class="status-item">
                        <span>Growth Stage</span>
                        <h4>🌿 Vegetative</h4>
                    </div>
                    <div class="status-item">
                        <span>Plant Age</span>
                        <h4>📅 24 Days</h4>
                    </div>
                    <div class="status-item">
                        <span>Harvest Estimate</span>
                        <h4>🎯 11 Days</h4>
                    </div>
                </div>
            </section>

        </main>

    </div>

    <script>
        // Chart configuration
        // Digantung dengan pengecekan: kalau elemen canvas #growthChart
        // belum ada di halaman (mis. dihapus sementara), skip saja
        // daripada melempar error dan menghentikan sisa script di bawahnya.
        const chartEl = document.getElementById('growthChart');
        if (chartEl) {
            const ctx = chartEl.getContext('2d');

            // Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(198, 242, 78, 0.5)');
            gradient.addColorStop(1, 'rgba(198, 242, 78, 0.05)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Growth Index',
                        data: [55, 60, 66, 71, 78, 84, 89],
                        borderColor: '#0e2913',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0e2913',
                        pointBorderWidth: 3,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#0e2913',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(14, 41, 19, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Growth: ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 40,
                            max: 100,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#7c8a80',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 12
                                },
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#7c8a80',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }

        // Apply suggestion button interaction
        function applySuggestion(btn) {
            btn.innerHTML = '✓ Applied!';
            btn.style.background = 'linear-gradient(135deg, #c6f24e, #9be32e)';
            btn.style.boxShadow = '0 4px 15px rgba(198, 242, 78, 0.4)';

            setTimeout(() => {
                btn.innerHTML = 'Apply Suggestion';
                btn.style.background = '';
                btn.style.boxShadow = '';
            }, 3000);
        }

        // Card hover effects
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Satu-satunya definisi animateValue di seluruh file.
        // Mendukung nilai desimal (mis. pH 6.30) lewat parameter `decimals`.
        // Dipanggil oleh script Firebase di bawah setiap ada data baru,
        // BUKAN oleh window 'load' dengan angka statis.
        function animateValue(element, start, end, duration, suffix = '', decimals = 0) {
            if (!element) return; // guard: elemen belum tentu ada di setiap halaman
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = (progress * (end - start) + start).toFixed(decimals);
                element.innerHTML = value + suffix;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        (function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const container = document.querySelector('.container');
            const mq = window.matchMedia('(max-width: 800px)');

            function placeSidebar(e) {
                if (e.matches) {
                    // mobile: pindahkan ke body biar fixed-nya relatif ke layar
                    document.body.appendChild(sidebar);
                    document.body.appendChild(overlay);
                } else {
                    // desktop: kembalikan ke posisi semula di dalam .container
                    container.insertBefore(sidebar, container.firstChild);
                }
            }

            placeSidebar(mq);
            mq.addEventListener('change', placeSidebar);
        })();

        const sidebarEl = document.getElementById('sidebar');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarOverlayEl = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebarEl.classList.add('active');
            sidebarOverlayEl.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebarEl.classList.remove('active');
            sidebarOverlayEl.classList.remove('active');
            document.body.style.overflow = '';
        }

        mobileMenuToggle.addEventListener('click', function () {

            if (sidebarEl.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }

        });

        sidebarOverlayEl.addEventListener('click', closeSidebar);

        sidebarEl.querySelectorAll('nav a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 800) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 800) {
                closeSidebar();
            }
        });
    </script>
    <script>
        lucide.createIcons();
    </script>

    <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
    import {
        getDatabase, ref, onValue
    } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-database.js";

    const firebaseConfig = {
        apiKey: "AIzaSyBedy4OHfbdi0jaBE2OrikqKbftqsnkvc0",
        authDomain: "esp32-hydroponic.firebaseapp.com",
        databaseURL: "https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "esp32-hydroponic",
        storageBucket: "esp32-hydroponic.firebasestorage.app",
        messagingSenderId: "655265559145",
        appId: "1:655265559145:web:7d0a0c0941d0877c8568f8"
    };

    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);
    const hydroRef = ref(db, "hydroponic");

    // Rentang ideal untuk hitung Health Score & arah trend
    const IDEAL = {
    temp: {
        min: 18,
        max: 24
    },

    ph: {
        min: 5.5,
        max: 6.5
    },

    tds: {
        min: 560,
        max: 840
    }
};


    // Simpan nilai sebelumnya supaya bisa hitung trend naik/turun
    let prev = { temp: null, ph: null, tds: null };

    function trendHTML(current, previous, unit = '') {
        if (previous === null || current === previous) {
            return `<span style="color: var(--text-light, #7c8a80);">→ stabil</span>`;
        }
        const diff = current - previous;
        const arrow = diff > 0 ? '↑' : '↓';
        const color = diff > 0 ? 'var(--success, #48bb78)' : 'var(--danger, #f56565)';
        return `<span style="color:${color};">${arrow} ${Math.abs(diff).toFixed(2)}${unit} dari sebelumnya</span>`;
    }

    function statusTrendHTML(value, range, unitLabel) {
        if (value < range.min) {
            return `<span style="color: var(--danger, #f56565);">↓ di bawah optimal (${unitLabel})</span>`;
        }
        if (value > range.max) {
            return `<span style="color: var(--warning, #ed8936);">↑ di atas optimal (${unitLabel})</span>`;
        }
        return `<span style="color: var(--success, #48bb78);">✓ optimal</span>`;
    }

    function calcHealthScore(temp, ph, tds) {
        const score = (value, range) => {
            if (value >= range.min && value <= range.max) return 100;
            const distance = value < range.min ? range.min - value : value - range.max;
            const span = (range.max - range.min) || 1;
            return Math.max(0, 100 - (distance / span) * 100);
        };
        const tempScore = score(temp, IDEAL.temp);
        const phScore = score(ph, IDEAL.ph);
        const tdsScore = score(tds, IDEAL.tds);
        return Math.round((tempScore + phScore + tdsScore) / 3);
    }

    onValue(hydroRef, (snapshot) => {
        const data = snapshot.val();
        if (!data || !data.sensor) return;

        const temp = data.sensor.temperature;
        const ph = data.sensor.phValue;
        const tds = data.sensor.tdsValue;

        // Catatan: baris-baris yang dulu mengisi #temperature, #phValue,
        // #tdsValue, #totalRecords, dan #sensorTable SUDAH DIHAPUS dari
        // sini karena elemen-elemen itu adalah milik halaman History
        // (data.blade.php), bukan halaman Dashboard/index ini. Sebelumnya
        // baris itu melempar error "Cannot set properties of null" yang
        // menghentikan seluruh callback sebelum sempat mengisi card
        // cardTemperature/cardPh/cardNutrient/cardHealth di bawah ini.

        const healthScore = calcHealthScore(temp, ph, tds);

        animateValue(document.getElementById('cardTemperature'), prev.temp ?? temp, temp, 800, '°C', 1);
        animateValue(document.getElementById('cardPh'), prev.ph ?? ph, ph, 800, '', 2);
        animateValue(document.getElementById('cardNutrient'), prev.tds ?? tds, tds, 800, ' ppm', 0);
        animateValue(document.getElementById('cardHealth'), 0, healthScore, 800, '%', 0);

        const tempTrendEl = document.getElementById('cardTemperatureTrend');
        if (tempTrendEl) {
            tempTrendEl.innerHTML =
                prev.temp !== null ? trendHTML(temp, prev.temp, '°C') : statusTrendHTML(temp, IDEAL.temp, 'suhu');
        }

        const phTrendEl = document.getElementById('cardPhTrend');
        if (phTrendEl) {
            phTrendEl.innerHTML = statusTrendHTML(ph, IDEAL.ph, 'pH');
        }

        const nutrientTrendEl = document.getElementById('cardNutrientTrend');
        if (nutrientTrendEl) {
            nutrientTrendEl.innerHTML = statusTrendHTML(tds, IDEAL.tds, 'ppm');
        }

        const healthTrendEl = document.getElementById('cardHealthTrend');
        if (healthTrendEl) {
            healthTrendEl.innerHTML =
                healthScore >= 80
                    ? `<span style="color: var(--success, #48bb78);">↑ kondisi baik</span>`
                    : `<span style="color: var(--warning, #ed8936);">↓ perlu perhatian</span>`;
        }

        // update nilai sebelumnya untuk perbandingan trend berikutnya
        prev = { temp, ph, tds };
    });
    </script>

    <script>

const historyData = @json($histories);


/*
|--------------------------------------------------------------------------
| IDEAL RANGE
|--------------------------------------------------------------------------
*/

const IDEAL = {
    temp: {
        min: 18,
        max: 24
    },

    ph: {
        min: 5.5,
        max: 6.5
    },

    tds: {
        min: 560,
        max: 840
    }
};



/*
|--------------------------------------------------------------------------
| HITUNG SCORE PARAMETER
|--------------------------------------------------------------------------
*/

function calculateParameterScore(value, range)
{
    if (value >= range.min && value <= range.max) {
        return 100;
    }

    let distance;

    if (value < range.min) {
        distance = range.min - value;
    } else {
        distance = value - range.max;
    }

    const rangeSize = range.max - range.min;

    return Math.max(
        0,
        100 - ((distance / rangeSize) * 100)
    );
}


/*
|--------------------------------------------------------------------------
| HITUNG HEALTH SCORE
|--------------------------------------------------------------------------
*/

function calculateHealthScore(temp, ph, tds)
{
    const tempScore =
        calculateParameterScore(temp, IDEAL.temp);

    const phScore =
        calculateParameterScore(ph, IDEAL.ph);

    const tdsScore =
        calculateParameterScore(tds, IDEAL.tds);

    return Math.round(
        (tempScore + phScore + tdsScore) / 3
    );
}


/*
|--------------------------------------------------------------------------
| PREPARE HISTORY
|--------------------------------------------------------------------------
*/

const labels = [];

const temperatureData = [];
const phData = [];
const nutrientData = [];
const healthData = [];


historyData.forEach(item => {

    const temp = Number(item.suhu);
    const ph = Number(item.pH);
    const tds = Number(item.nutrisi);

    labels.push(item.created_at);

    temperatureData.push(temp);

    phData.push(ph);

    nutrientData.push(tds);

    const health = calculateHealthScore(
        temp,
        ph,
        tds
    );

    healthData.push(health);

});


/*
|--------------------------------------------------------------------------
| HEALTH TREND CHART
|--------------------------------------------------------------------------
*/

const healthCanvas =
    document.getElementById('healthTrendChart');

if (healthCanvas) {

    new Chart(
        healthCanvas,
        {
            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    {
                        label: 'Health Score',

                        data: healthData,

                        borderColor: '#0e2913',

                        backgroundColor:
                            'rgba(198, 242, 78, 0.18)',

                        borderWidth: 3,

                        fill: true,

                        tension: 0.35,

                        pointRadius: 4,

                        pointBackgroundColor: '#c6f24e',

                        pointBorderColor: '#0e2913',

                        pointHoverRadius: 7
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: 'rgba(14, 41, 19, 0.9)',

                        callbacks: {

                            label: function(context) {

                                return 'Health: ' +
                                    context.parsed.y +
                                    '%';

                            }

                        }

                    }

                },

                scales: {

                    y: {

                        min: 0,

                        max: 100,

                        ticks: {

                            callback: function(value) {

                                return value + '%';

                            }

                        }

                    },

                    x: {

                        type: 'time',

                        time: {

                            unit: 'hour',

                            tooltipFormat:
                                'dd/MM/yyyy HH:mm'

                        }

                    }

                }

            }

        }
    );

}


/*
|--------------------------------------------------------------------------
| SENSOR TREND CHART
|--------------------------------------------------------------------------
*/

const sensorCanvas =
    document.getElementById('sensorTrendChart');

if (sensorCanvas) {

    new Chart(
        sensorCanvas,
        {

            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    {
                        label: 'Temperature (°C)',

                        data: temperatureData,

                        borderColor: '#f56565',

                        backgroundColor:
                            'transparent',

                        borderWidth: 2,

                        tension: 0.35,

                        yAxisID: 'temperature'

                    },

                    {
                        label: 'pH',

                        data: phData,

                        borderColor: '#4299e1',

                        backgroundColor:
                            'transparent',

                        borderWidth: 2,

                        tension: 0.35,

                        yAxisID: 'ph'

                    },

                    {
                        label: 'Nutrient (ppm)',

                        data: nutrientData,

                        borderColor: '#9b7de0',

                        backgroundColor:
                            'transparent',

                        borderWidth: 2,

                        tension: 0.35,

                        yAxisID: 'nutrient'

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {

                    intersect: false,

                    mode: 'index'

                },

                scales: {

                    temperature: {

                        type: 'linear',

                        position: 'left',

                        title: {

                            display: true,

                            text: 'Temperature °C'

                        }

                    },

                    ph: {

                        type: 'linear',

                        position: 'right',

                        min: 4,

                        max: 8,

                        title: {

                            display: true,

                            text: 'pH'

                        },

                        grid: {

                            drawOnChartArea: false

                        }

                    },

                    nutrient: {

                        type: 'linear',

                        position: 'right',

                        display: false,

                        min: 0

                    },

                    x: {

                        type: 'time',

                        time: {

                            unit: 'hour',

                            tooltipFormat:
                                'dd/MM/yyyy HH:mm'

                        }

                    }

                }

            }

        }
    );

}

</script>

</body>
</html>