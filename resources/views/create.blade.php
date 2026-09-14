<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Monitoring Data - PlantAI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* =========================================================
           HARVEST-STYLE REDESIGN
           Menimpa/mendefinisikan ulang seluruh class halaman ini
           (sidebar, header, form-card, input, tombol) supaya tampilan
           konsisten dengan Harvest Dashboard: hijau tua + lime, kartu
           putih rounded, tanpa bergantung isi css/style.css eksternal.
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
            --radius: 18px;
            --shadow: 0 1px 2px rgba(14, 41, 19, 0.05);
            --shadow-hover: 0 10px 26px rgba(14, 41, 19, 0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* soft background blobs */
        .bg-decoration {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bg-decoration::before,
        .bg-decoration::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.35;
            filter: blur(80px);
        }

        .bg-decoration::before {
            width: 560px; height: 560px;
            background: var(--primary);
            top: -200px; right: -100px;
            animation: float 20s infinite ease-in-out;
        }

        .bg-decoration::after {
            width: 480px; height: 480px;
            background: var(--darker);
            bottom: -150px; left: -100px;
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ---------------- SIDEBAR ---------------- */
        .sidebar {
            width: 260px;
            background: var(--dark);
            padding: 2rem 1.25rem;
            display: flex;
            flex-direction: column;
            position: fixed;
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
            padding: 0.75rem 1.1rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: background .15s ease, color .15s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .nav-icon svg { width: 18px; height: 18px; }

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
            padding: 2rem 2.5rem;
            max-width: calc(100% - 260px);
            width: 100%;
        }

        /* ---------------- HEADER ---------------- */
        .header {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px 26px;
            margin-bottom: 22px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .header-text h1 {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.3px;
            margin-bottom: 3px;
        }

        .header-text p {
            color: var(--text-light);
            font-size: 0.9rem;
            font-weight: 400;
        }

        /* ---------------- FORM CARD ---------------- */
        .form-card {
            background: var(--card);
            border-radius: 22px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--dark), var(--primary));
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header .icon-wrapper {
            width: 60px;
            height: 60px;
            background: var(--dark);
            color: var(--primary);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(14, 41, 19, 0.25);
        }

        .form-header h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.4rem;
        }

        .form-header p {
            color: var(--text-light);
            font-size: 0.88rem;
        }

        /* ---------------- FORM GROUP ---------------- */
        .form-group {
            margin-bottom: 1.4rem;
            position: relative;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.9rem;
            border: 2px solid var(--line);
            border-radius: 14px;
            font-size: 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background: var(--bg);
            transition: all 0.25s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(198, 242, 78, 0.3);
        }

        .form-group input::placeholder {
            color: var(--text-light);
            opacity: 0.7;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            bottom: 0.85rem;
            font-size: 1.1rem;
            opacity: 0.55;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .form-group input:focus + .input-icon,
        .form-group input:not(:placeholder-shown) + .input-icon {
            opacity: 1;
        }

        .input-hint {
            font-size: 0.78rem;
            color: var(--text-light);
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .input-hint.warning { color: var(--warning); }

        /* ---------------- BUTTONS ---------------- */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-submit {
            flex: 1;
            padding: 1rem 1.5rem;
            background: var(--dark);
            color: var(--primary);
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(14, 41, 19, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 41, 19, 0.4);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-reset {
            padding: 1rem 1.5rem;
            background: var(--bg);
            color: var(--text);
            border: 2px solid var(--line);
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-reset:hover {
            background: #ffffff;
            border-color: var(--text-light);
        }

        /* ---------------- VALIDATION ---------------- */
        .form-group.has-error input {
            border-color: var(--danger);
            background: rgba(245, 101, 101, 0.05);
        }

        .form-group.has-error .error-message { display: flex; }

        .error-message {
            display: none;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 0.375rem;
        }

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

            .header-text h1 { font-size: 20px; }
            .header-actions { width: 100%; }

            .form-card { padding: 1.5rem; }
            .form-actions { flex-direction: column; }
        }

        /* ---------------- ANIMATIONS ---------------- */
        .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; transform: translateY(20px); }
        .delay-2 { animation-delay: 0.2s; transform: translateY(20px); }
        .delay-3 { animation-delay: 0.3s; transform: translateY(20px); }

        /* ---------------- SCROLLBAR ---------------- */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--secondary); }
    </style>
</head>
<body>

    <div class="bg-decoration"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="container">

        <aside class="sidebar" id="sidebar">

        <img src="{{ asset('image/bagus_hidro_logo.png') }}" alt="Hidroponik BAGUS">

        <nav>

            <a href="{{ route('index.index') }}">
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
                <a href="{{ url('/control') }}">
                <span class="nav-icon">
                    <i data-lucide="sliders-horizontal"></i>
                </span>
                Control
                </a>
                <a href="{{ route('index.create') }}" class="active">
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
                 <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Buka menu">
                <i data-lucide="menu"></i>
            </button>

                <div class="header-text">
                    <h1>Add Monitoring Data</h1>
                    <p>Input new sensor readings for your hydroponic system</p>
                </div>
        
            </header>

            <div class="form-card fade-in delay-2">
                <div class="form-header">
                    <div class="icon-wrapper"><i data-lucide="sprout"></i></div>
                    <h2>New Sensor Reading</h2>
                    <p>Fill in the details below to record a new data point</p>
                </div>

                <form action="{{ route('index.store') }}" method="POST">
                    @csrf

                    <!-- ID Input -->
                    <div class="form-group fade-in delay-1">
                        <label for="idTumbuhan"><i data-lucide="tag" style="width:15px;height:15px;"></i> Plant ID
                        </label>
                        <input 
                            type="text" 
                            id="idTumbuhan" 
                            name="idTumbuhan" 
                            placeholder="Unique Characters"
                            required
                        >
                        <span class="input-icon">🌱</span>
                    </div>

                    <!-- Suhu Input -->
                    <div class="form-group fade-in delay-2">
                        <label for="suhu"><i data-lucide="thermometer" style="width:15px;height:15px;"></i> Temperature
                        </label>
                        <input 
                            type="number" 
                            id="suhu" 
                            name="suhu" 
                            placeholder="0-100"
                            step="0.1"
                            min="0"
                            max="100"
                            required
                        >
                        <span class="input-icon">🌡️</span>
                    </div>

                    <!-- pH Input -->
                    <div class="form-group fade-in delay-2">
                        <label for="pH"><i data-lucide="droplets" style="width:15px;height:15px;"></i> pH Level
                        </label>
                        <input 
                            type="number" 
                            id="pH" 
                            name="pH" 
                            placeholder="0-14"
                            step="0.1"
                            min="0"
                            max="14"
                            required
                        >
                        <span class="input-icon">💧</span>
                    </div>

                    <!-- Nutrisi Input -->
                    <div class="form-group fade-in delay-3">
                        <label for="nutrisi"><i data-lucide="test-tube-diagonal" style="width:15px;height:15px;"></i> Nutritient
                        </label>
                        <input 
                            type="number" 
                            id="nutrisi" 
                            name="nutrisi" 
                            placeholder="e.g. 1450"
                            step="1"
                            min="0"
                            required
                        >
                        <span class="input-icon">🧪</span>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn-reset">Reset</button>
                        <button type="submit" class="btn-submit">
                             Save Data
                        </button>
                    </div>
                </form>
            </div>

        </main>

    </div>

    <script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const container = document.querySelector('.container');
        const mq = window.matchMedia('(max-width: 800px)');

        function placeSidebar(e) {
            if (e.matches) {
                document.body.appendChild(sidebar);
                document.body.appendChild(overlay);
            } else {
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
    <script>

        

        // Form validation feedback
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('blur', function() {
                const group = this.closest('.form-group');
                if (this.value && !this.checkValidity()) {
                    group.classList.add('has-error');
                } else {
                    group.classList.remove('has-error');
                }
            });

            input.addEventListener('input', function() {
                const group = this.closest('.form-group');
                if (this.checkValidity()) {
                    group.classList.remove('has-error');
                }
            });
        });

        // Submit button loading state
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-submit');
            btn.innerHTML = 'Saving...';
            btn.disabled = true;
            btn.style.opacity = '0.7';
        });
    </script>
<script>
    lucide.createIcons();
    </script>

</body>
</html>