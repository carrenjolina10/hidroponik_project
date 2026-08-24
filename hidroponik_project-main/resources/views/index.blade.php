<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Monitoring Dashboard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .mobile-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;

            width: 42px;
            height: 42px;

            border: none;
            border-radius: 10px;

            background: #1a202c;
            color: white;

            cursor: pointer;
            flex-shrink: 0;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Di layar <=800px, tombol ini lepas dari alur header dan
           menempel tetap di pojok kiri atas layar, tidak nabrak judul */
        @media (max-width: 800px) {
            .mobile-menu-toggle {
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 1001;
            }
        }

        .mobile-menu-toggle:hover {
            background: #2d3748;
        }

        .sidebar-overlay {
            display: none;

            position: fixed;
            inset: 0;

            background: rgba(0, 0, 0, 0.45);
            z-index: 999;

            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* =========================================================
           RESPONSIVE FIX — SIDEBAR & CARD UNTUK <= 800px
           Hanya CSS baru, tidak menghapus/mengubah rule yang lama
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

            .container {
                display: block !important;
            }

            .sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                right: auto !important;

                width: 78vw !important;
                max-width: 280px !important;
                height: 100vh !important;

                z-index: 99999 !important;

                transform: translateX(-100%);
                transition: transform 0.3s ease;

                overflow-y: auto;

                /* dipaksa solid supaya tidak transparan / konten di
                   belakangnya tidak tembus terlihat */
                background: #ffffff !important;
                opacity: 1 !important;
                backdrop-filter: none !important;

                box-shadow: 6px 0 30px rgba(0, 0, 0, 0.25);
            }

            .sidebar.active {
                transform: translateX(0);
                z-index: 99999 !important;
            }

            .main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 18px 16px !important;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 14px;

                /* ruang kosong di kiri supaya judul tidak ketiban
                   tombol hamburger yang sekarang mengambang fixed */
                padding-left: 58px;
            }

            .header-text {
                flex: 1 1 auto;
                min-width: 0;
            }

            .header-text h1 {
                font-size: 20px;
            }

            .header-actions {
                width: 100%;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .content {
                gap: 16px;
                margin-top: 20px;
            }

            .chart-card,
            .recommendation {
                padding: 20px;
            }

            .status-card {
                margin-top: 16px;
                padding: 20px;
            }

            .status-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .status-grid {
                grid-template-columns: 1fr;
            }

            .chart-card,
            .recommendation,
            .card {
                padding: 16px;
                border-radius: 14px;
            }
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
                <span class="nav-icon">
                    <i data-lucide="layout-dashboard"></i>
                </span>
                Dashboard
            </a>

            <a href="{{ route('index.create') }}">
                <span class="nav-icon">
                    <i data-lucide="file-plus-2"></i>
                </span>
                New Data
            </a>

            <a href="{{ route('data') }}">
                <span class="nav-icon">
                    <i data-lucide="history"></i>
                </span>
                History
            </a>

            <a href="{{ url('/ai') }}" >
                <span class="nav-icon">
                    <i data-lucide="scan-search"></i>
                </span>
                AI Detection
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
                </div>
            </header>

            <section class="cards">
                <div class="card fade-in delay-1">
                    <div class="card-icon"><i data-lucide="thermometer"></i></div>
                    <h3>Temperature</h3>
                    <h2>28°C</h2>
                    <div class="card-trend">↑ 2.3% from yesterday</div>
                </div>

                <div class="card fade-in delay-2">
                    <div class="card-icon"><i data-lucide="droplets"></i></div>
                    <h3>pH Water</h3>
                    <h2>6.3</h2>
                    <div class="card-trend" style="color: var(--warning);">↓ 0.1 from optimal</div>
                </div>

                <div class="card fade-in delay-3">
                    <div class="card-icon"><i data-lucide="test-tube-diagonal"></i></div>
                    <h3>Nutrient</h3>
                    <h2>1450 ppm</h2>
                    <div class="card-trend" style="color: var(--danger);">↓ 5% below target</div>
                </div>

                <div class="card fade-in delay-4">
                    <div class="card-icon"><i data-lucide="heart-pulse"></i></div>
                    <h3>Health Score</h3>
                    <h2>92%</h2>
                    <div class="card-trend">↑ 3% this week</div>
                </div>
            </section>

            <section class="content">
                <div class="chart-card fade-in delay-2">
                    <h3>Plant Growth Trend</h3>
                    <div class="chart-wrapper">
                        <canvas id="growthChart"></canvas>
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
        const ctx = document.getElementById('growthChart').getContext('2d');
        
        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(207, 236, 243, 0.6)');
        gradient.addColorStop(1, 'rgba(207, 236, 243, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Growth Index',
                    data: [55, 60, 66, 71, 78, 84, 89],
                    borderColor: '#48bb78',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#48bb78',
                    pointBorderWidth: 3,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#48bb78',
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
                        backgroundColor: 'rgba(26, 26, 46, 0.9)',
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
                            color: '#718096',
                            font: {
                                family: 'Inter',
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
                            color: '#718096',
                            font: {
                                family: 'Inter',
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

        // Apply suggestion button interaction
        function applySuggestion(btn) {
            btn.innerHTML = '✓ Applied!';
            btn.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
            btn.style.boxShadow = '0 4px 15px rgba(72, 187, 120, 0.4)';
            
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

        // Animate numbers on load
        function animateValue(element, start, end, duration, suffix = '') {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.innerHTML = value + suffix;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Trigger number animations after load
        window.addEventListener('load', () => {
            const cards = document.querySelectorAll('.card h2');
            const values = [28, 6.3, 1450, 92];
            const suffixes = ['°C', '', ' ppm', '%'];
            
            cards.forEach((card, index) => {
                if (index === 1) { // pH value
                    card.innerHTML = '6.3';
                    return;
                }
                const endValue = values[index];
                const suffix = suffixes[index];
                animateValue(card, 0, endValue, 1500, suffix);
            });
        });

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

</body>
</html>