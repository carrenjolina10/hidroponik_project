<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - Hidroponik Bagus</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* =========================================================
           HARVEST-STYLE REDESIGN (kartu solid putih, konsisten
           dengan Dashboard, AI Detection, Control, dst.)
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

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
            filter: blur(90px);
        }

        .bg-decoration::before {
            width: 560px; height: 560px;
            background: var(--primary);
            top: -220px; right: -120px;
            animation: float 20s infinite ease-in-out;
        }

        .bg-decoration::after {
            width: 480px; height: 480px;
            background: var(--darker);
            bottom: -180px; left: -120px;
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
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar img { max-width: 165px; margin-bottom: 2.25rem; }

        .sidebar nav { display: flex; flex-direction: column; gap: 4px; }

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

        .nav-icon { width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; opacity: .9; }
        .nav-icon svg { width: 18px; height: 18px; }

        .sidebar nav a:hover { background: rgba(255, 255, 255, 0.07); color: #eef3e9; }

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

        /* ---------------- HEADER ---------------- */
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

        .header-text p { color: var(--text-light); font-size: 0.9rem; }

        .header-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.4rem;
            background: var(--dark);
            color: var(--primary);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(14, 41, 19, 0.25);
            border: none;
            cursor: pointer;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 41, 19, 0.35);
        }

        /* ---------------- RECORD CONTROL ---------------- */
        .record-control {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.65rem 1rem;
            background: var(--bg);
            border-radius: 12px;
        }

        .record-info { display: flex; flex-direction: column; gap: 2px; }
        .record-label { font-size: 0.8rem; font-weight: 700; color: var(--dark); }
        .record-status { font-size: 0.72rem; color: var(--text-light); }
        .record-status.active { color: var(--success); }
        .record-status.inactive { color: var(--danger); }

        /* Toggle */
        .switch { position: relative; width: 48px; height: 26px; display: inline-block; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute; cursor: pointer; inset: 0;
            background: #cbd5e0; border-radius: 50px; transition: 0.3s;
        }
        .slider::before {
            content: "";
            position: absolute; width: 20px; height: 20px;
            left: 3px; top: 3px;
            background: white; border-radius: 50%;
            transition: 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .switch input:checked + .slider { background: var(--primary); }
        .switch input:checked + .slider::before { transform: translateX(22px); }

        /* ---------------- ALERT ---------------- */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            animation: slideIn 0.4s ease-out;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
            border: 1px solid rgba(72, 187, 120, 0.2);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ---------------- STATS ROW ---------------- */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.1rem;
            margin-bottom: 22px;
        }

        .stat-card {
            background: var(--card);
            border-radius: 16px;
            padding: 1.2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.25s ease;
        }

        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #cfe8ff, #a9d4ff); }
        .stat-icon.green { background: linear-gradient(135deg, #eaffb8, #c6f24e); }
        .stat-icon.orange { background: linear-gradient(135deg, #ffe0c2, #ffc38a); }
        .stat-icon.pink { background: linear-gradient(135deg, #ead6ff, #d6b8ff); }

        .stat-info h4 { font-size: 1.4rem; font-weight: 800; color: var(--dark); line-height: 1; }
        .stat-info span { font-size: 0.78rem; color: var(--text-light); font-weight: 500; }

        /* ---------------- TABLE CARD ---------------- */
        .table-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            padding: 22px 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .table-header h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-box { position: relative; }

        .search-box input {
            padding: 0.65rem 1rem 0.65rem 2.5rem;
            border: 2px solid var(--line);
            border-radius: 50px;
            font-size: 0.875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 260px;
            background: var(--bg);
            transition: all 0.25s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(198, 242, 78, 0.3);
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            opacity: 0.5;
        }

        /* ---------------- TABLE ---------------- */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--bg); }

        th {
            padding: 15px 26px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        td {
            padding: 15px 26px;
            font-size: 0.88rem;
            color: var(--text);
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        tbody tr { transition: background 0.2s ease; }
        tbody tr:hover { background: rgba(198, 242, 78, 0.1); }
        tbody tr:last-child td { border-bottom: none; }

        .id-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.35rem 0.85rem;
            background: var(--primary);
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.83rem;
            color: var(--dark);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }

        .status-optimal {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
            border: 1px solid rgba(72, 187, 120, 0.2);
        }
        .status-optimal::before { background: var(--success); }

        .status-warning {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning);
            border: 1px solid rgba(237, 137, 54, 0.2);
        }
        .status-warning::before { background: var(--warning); }

        .status-danger {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger);
            border: 1px solid rgba(245, 101, 101, 0.2);
        }
        .status-danger::before { background: var(--danger); }

        /* ---------------- EMPTY STATE ---------------- */
        .empty-state { text-align: center; padding: 3rem; color: var(--text-light); }
        .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .empty-state h3 { font-size: 1.2rem; color: var(--dark); margin-bottom: 0.5rem; }

        /* pagination links (Laravel default) */
        .table-card nav { font-size: 13px; }

        /* ---------------- FADE-IN ---------------- */
        .fade-in { animation: fadeIn 0.5s ease-out forwards; opacity: 0; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: .05s; transform: translateY(14px); }
        .delay-2 { animation-delay: .1s; transform: translateY(14px); }
        .delay-3 { animation-delay: .15s; transform: translateY(14px); }

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
            .mobile-menu-toggle { position: fixed; top: 16px; left: 16px; z-index: 1001; }

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

            .sidebar.active { transform: translateX(0); z-index: 99999 !important; }

            .main { margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 18px 16px !important; }

            .mobile-menu-toggle { display: flex; }

            .header { padding: 16px 16px 16px 58px; }

            .header-text h1 { font-size: 20px; }
            .header-actions { width: 100%; }

            .stats-row { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        }

        @media (max-width: 1024px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .stats-row { grid-template-columns: 1fr; }
            .table-header { flex-direction: column; align-items: stretch; }
            .search-box input { width: 100%; }
        }

        /* ---------------- SCROLLBAR ---------------- */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
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
                <a href="{{ route('data') }}" class="active">
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
                <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Buka menu">
                    <i data-lucide="menu"></i>
                </button>
                <div class="header-text">
                    <h1>Data Monitoring</h1>
                    <p>Manage and review all sensor readings</p>
                </div>
                <div class="header-actions">

                    <div class="record-control">

                        <div class="record-info">
                            <span class="record-label">
                                Automatic Recording
                            </span>

                            <span class="record-status" id="recordStatus">
                                Checking...
                            </span>
                        </div>

                        <label class="switch">
                            <input type="checkbox" id="recordToggle">
                            <span class="slider"></span>
                        </label>

                    </div>

                    <a href="{{ route('index.create') }}" class="btn-add">
                        <span>+</span> Add New Data
                    </a>

                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success fade-in delay-1">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Stats Row -->
            <div class="stats-row fade-in delay-1">
                <div class="stat-card">
                    <div class="stat-icon blue">📊</div>
                    <div class="stat-info">
                        <h4 id="totalRecords">1</h4>
                        <span>Total Records</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">🌡️</div>
                    <div class="stat-info">
                        <h4 id="temperature">-°C</h4>
                        <span>Avg Temperature</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">💧</div>
                    <div class="stat-info">
                        <h4 id="phValue">-</h4>
                        <span>Avg pH Level</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pink">🧪</div>
                    <div class="stat-info">
                        <h4 id="tdsValue">-</h4>
                        <span>Avg Nutrient (ppm)</span>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card fade-in delay-2">
                <div class="table-header">
                    <h3>📋 All Sensor Readings</h3>
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search by ID or value...">
                    </div>
                </div>

                <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Temperature</th>
                                    <th>pH Level</th>
                                    <th>Nutrient</th>
                                    <th>Status</th>
                                    <th>Recorded</th>
                                </tr>
                            </thead>
                            <tbody id="sensorTable">
                                @forelse($histories as $h)
                                    <tr>
                                        <td><span class="id-badge">#{{ str_pad($h->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                        <td>{{ number_format($h->suhu, 1) }} °C</td>
                                        <td>{{ number_format($h->pH, 2) }}</td>
                                        <td>{{ number_format($h->nutrisi, 0) }} ppm</td>
                                        <td>
                                            <span class="status-badge status-optimal">Recorded</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($h->created_at)->format('d/m/Y, H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <div class="empty-state-icon">📭</div>
                                            <h3>Belum ada data history</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="padding: 1rem 1.75rem;">
                            {{ $histories->links() }}
                        </div>
                </div>
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

    lucide.createIcons();

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Animate progress bars on load
    window.addEventListener('load', () => {
        document.querySelectorAll('.value-bar-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
    });
</script>


<script type="module">

    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";

    import {
        getDatabase,
        ref,
        onValue,
        set
    } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-database.js";


    // ==========================================
    // FIREBASE CONFIGURATION
    // ==========================================

    const firebaseConfig = {
        apiKey: "AIzaSyBedy4OHfbdi0jaBE2OrikqKbftqsnkvc0",
        authDomain: "esp32-hydroponic.firebaseapp.com",
        databaseURL: "https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "esp32-hydroponic",
        storageBucket: "esp32-hydroponic.firebasestorage.app",
        messagingSenderId: "655265559145",
        appId: "1:655265559145:web:7d0a0c0941d0877c8568f8"
    };


    // ==========================================
    // INITIALIZE FIREBASE
    // ==========================================

    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);


    // ==========================================
    // FIREBASE REFERENCES
    // ==========================================

    const hydroRef = ref(db, "hydroponic");
    const recordingRef = ref(db, "hydroponic/recording/enabled");


    // ==========================================
    // ELEMENTS
    // ==========================================

    const recordToggle =
        document.getElementById("recordToggle");

    const recordStatus =
        document.getElementById("recordStatus");

    const temperatureElement =
        document.getElementById("temperature");

    const phElement =
        document.getElementById("phValue");

    const tdsElement =
        document.getElementById("tdsValue");


    // ==========================================
    // DATA SENSOR TERAKHIR
    // ==========================================

    let latestSensorData = {
        suhu: null,
        pH: null,
        nutrisi: null
    };


    // ==========================================
    // REAL-TIME SENSOR DATA
    // ==========================================

    onValue(hydroRef, (snapshot) => {

        const data = snapshot.val();

        console.log("📡 Firebase data:", data);


        // Tidak ada data Firebase
        if (!data || !data.sensor) {

            console.warn("❌ Sensor data tidak ditemukan.");

            return;
        }


        // ======================================
        // TEMPERATURE
        // ======================================

        if (data.sensor.temperature !== undefined) {

            const temperature =
                Number(data.sensor.temperature);

            if (!isNaN(temperature)) {

                // SIMPAN NILAI TERAKHIR
                latestSensorData.suhu = temperature;

                // Tampilkan ke dashboard
                temperatureElement.innerHTML =
                    temperature.toFixed(1) + "°C";
            }
        }


        // ======================================
        // pH
        // ======================================

        if (data.sensor.phValue !== undefined) {

            const ph =
                Number(data.sensor.phValue);

            if (!isNaN(ph)) {

                // SIMPAN NILAI TERAKHIR
                latestSensorData.pH = ph;

                // Tampilkan ke dashboard
                phElement.innerHTML =
                    ph.toFixed(2);
            }
        }


        // ======================================
        // TDS / NUTRIENT
        // ======================================

        if (data.sensor.tdsValue !== undefined) {

            const tds =
                Number(data.sensor.tdsValue);

            if (!isNaN(tds)) {

                // SIMPAN NILAI TERAKHIR
                latestSensorData.nutrisi = tds;

                // Tampilkan ke dashboard
                tdsElement.innerHTML =
                    tds.toFixed(0);
            }
        }


        // ======================================
        // CEK DATA TERAKHIR
        // ======================================

        console.log(
            "📊 Latest Sensor Data:",
            latestSensorData
        );

    });


    // ==========================================
    // RECORDING STATUS
    // ==========================================

    onValue(recordingRef, (snapshot) => {

        const enabled =
            snapshot.val() === true;


        // Sinkronkan toggle
        recordToggle.checked = enabled;


        // Update status
        if (enabled) {

            recordStatus.textContent =
                "Recording ON";

            recordStatus.className =
                "record-status active";

        } else {

            recordStatus.textContent =
                "Recording OFF";

            recordStatus.className =
                "record-status inactive";
        }


        console.log(
            "🎥 Recording status:",
            enabled ? "ON" : "OFF"
        );

    });


    // ==========================================
    // AUTO RECORDING
    // SETIAP 1 MENIT
    // ==========================================



    // ==========================================
    // RECORDING TOGGLE
    // ==========================================

    recordToggle.addEventListener(
        "change",
        async function () {

            const enabled =
                this.checked;


            try {

                // Simpan status ke Firebase
                await set(
                    recordingRef,
                    enabled
                );


                console.log(
                    "🎥 Recording:",
                    enabled
                        ? "ON"
                        : "OFF"
                );


            } catch (error) {

                console.error(
                    "❌ Recording error:",
                    error
                );


                // Kembalikan toggle
                this.checked =
                    !enabled;
            }

        }
    );

</script>



</body>
</html>