<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lettuce Growing Guide - Hidroponik Bagus</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <style>
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

        .container { display: flex; min-height: 100vh; position: relative; z-index: 1; }

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

        .sidebar img { max-width: 165px; margin-bottom: 2.25rem; }

        .sidebar nav { display: flex; flex-direction: column; gap: 4px; }

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

        .nav-icon {
            width: 20px; height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .nav-icon svg { width: 18px; height: 18px; }

        /* ---------------- MAIN ---------------- */
        .main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem 2.5rem;
            max-width: calc(100% - 260px);
            width: 100%;
        }

        .header {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px 26px;
            margin-bottom: 26px;
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

        .header-text p { color: var(--text-light); font-size: 0.9rem; }

        /* Section heading */
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dark);
            margin: 2.1rem 0 1rem;
        }

        .section-title .nav-icon { width: 20px; height: 20px; color: var(--dark); }
        .section-title:first-of-type { margin-top: 0; }

        .section-sub {
            color: var(--text-light);
            font-size: 0.88rem;
            margin-top: -0.65rem;
            margin-bottom: 1.2rem;
        }

        /* ---------------- QUICK STAT CARDS ---------------- */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.1rem;
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
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--dark);
        }
        .stat-icon svg { width: 20px; height: 20px; }

        .stat-icon.blue { background: linear-gradient(135deg, #cfe8ff, #a9d4ff); }
        .stat-icon.green { background: linear-gradient(135deg, #eaffb8, #c6f24e); }
        .stat-icon.orange { background: linear-gradient(135deg, #ffe0c2, #ffc38a); }
        .stat-icon.pink { background: linear-gradient(135deg, #ead6ff, #d6b8ff); }

        .stat-info h4 { font-size: 1.2rem; font-weight: 800; color: var(--dark); line-height: 1.2; }
        .stat-info span { font-size: 0.76rem; color: var(--text-light); font-weight: 500; }

        /* ---------------- GROWTH STAGE TIMELINE ---------------- */
        .stage-track {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.1rem;
        }

        .stage-card {
            background: var(--card);
            border-radius: 16px;
            padding: 1.4rem;
            box-shadow: var(--shadow);
            position: relative;
        }

        .stage-card .stage-day {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--dark);
            background: var(--primary);
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            margin-bottom: 0.85rem;
        }

        .stage-card h4 { font-size: 0.98rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
        .stage-card p { font-size: 0.83rem; color: var(--text-light); line-height: 1.5; }

        /* ---------------- DICTIONARY ---------------- */
        .dict-list { display: flex; flex-direction: column; gap: 0.85rem; }

        .dict-item {
            background: var(--card);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .dict-item summary {
            list-style: none;
            cursor: pointer;
            padding: 1.05rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .dict-item summary::-webkit-details-marker { display: none; }

        .dict-item summary .dict-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--primary);
            color: var(--dark);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dict-item summary .dict-icon svg { width: 18px; height: 18px; }

        .dict-item summary .dict-term { flex: 1; }

        .dict-item summary .dict-range {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--success);
            background: rgba(72, 187, 120, 0.1);
            padding: 0.3rem 0.7rem;
            border-radius: 50px;
        }

        .dict-item summary .chevron {
            transition: transform 0.25s ease;
            color: var(--text-light);
        }

        .dict-item[open] summary .chevron { transform: rotate(180deg); }
        .dict-item[open] summary { border-bottom: 1px solid var(--line); }

        .dict-body {
            padding: 1rem 1.5rem 1.25rem 4.25rem;
            font-size: 0.87rem;
            color: var(--text-light);
            line-height: 1.65;
        }

        .dict-body b { color: var(--text); }

        /* ---------------- PROBLEM CARDS ---------------- */
        .problem-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.1rem;
        }

        .problem-card {
            background: var(--card);
            border-radius: 16px;
            padding: 1.35rem 1.45rem;
            box-shadow: var(--shadow);
        }

        .problem-card h4 {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.8rem;
        }

        .problem-card h4 .nav-icon { color: var(--danger); }

        .problem-card .row { margin-bottom: 0.55rem; font-size: 0.84rem; color: var(--text-light); }
        .problem-card .row b { color: var(--text); font-weight: 600; }

        /* ---------------- HARVEST NOTE ---------------- */
        .note-card {
            background: var(--card);
            border-radius: 16px;
            padding: 1.4rem 1.7rem;
            box-shadow: var(--shadow);
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .note-card .nav-icon { color: var(--success); flex-shrink: 0; margin-top: 0.2rem; }
        .note-card p { font-size: 0.89rem; color: var(--text-light); line-height: 1.6; }
        .note-card p + p { margin-top: 0.5rem; }

        /* ---------------- MOBILE SIDEBAR ---------------- */
        .mobile-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 42px; height: 42px;
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
            .mobile-menu-toggle { position: fixed; top: 16px; left: 16px; z-index: 1001; display: flex; }

            .container { display: block !important; }

            .sidebar {
                position: fixed !important;
                top: 0; left: 0; bottom: 0; right: auto;
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

            .sidebar.active { transform: translateX(0); }

            .main { margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 18px 16px !important; }

            .header { padding-left: 58px; }
            .header-text h1 { font-size: 20px; }

            .stats-row, .stage-track, .problem-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 560px) {
            .stats-row, .stage-track, .problem-grid { grid-template-columns: 1fr; }
            .dict-body { padding-left: 1.5rem; }
        }

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
                <a href="{{ route('lettuce.guide') }}" class="active">
                    <span class="nav-icon"><i data-lucide="sprout"></i></span>
                    Lettuce Guide
                </a>
            </nav>
        </aside>

        <main class="main">

            <header class="header">
                <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Buka menu">
                    <i data-lucide="menu"></i>
                </button>
                <div class="header-text">
                    <h1>🥬 Lettuce Growing Guide</h1>
                    <p>Kamus lengkap kebutuhan menanam selada (lettuce) secara hidroponik</p>
                </div>
            </header>

            <!-- Quick reference -->
            <div class="section-title"><i data-lucide="gauge" class="nav-icon"></i> Rentang Ideal (Ringkas)</div>
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon green"><i data-lucide="thermometer"></i></div>
                    <div class="stat-info">
                        <h4>18 – 24°C</h4>
                        <span>Suhu Air &amp; Udara</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i data-lucide="droplets"></i></div>
                    <div class="stat-info">
                        <h4>5.5 – 6.5</h4>
                        <span>pH Larutan Nutrisi</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange"><i data-lucide="test-tube-diagonal"></i></div>
                    <div class="stat-info">
                        <h4>560 – 840 ppm</h4>
                        <span>Nutrisi / TDS (EC 0.8–1.2)</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pink"><i data-lucide="sun"></i></div>
                    <div class="stat-info">
                        <h4>14 – 16 jam</h4>
                        <span>Lama Penyinaran / Hari</span>
                    </div>
                </div>
            </div>

            <!-- Growth stages -->
            <div class="section-title"><i data-lucide="calendar-days" class="nav-icon"></i> Tahapan Pertumbuhan</div>
            <p class="section-sub">Total masa tanam selada hidroponik umumnya 35–45 hari sejak semai, tergantung varietas.</p>
            <div class="stage-track">
                <div class="stage-card">
                    <span class="stage-day">HARI 0–3</span>
                    <h4>🌱 Perkecambahan</h4>
                    <p>Benih disemai di rockwool lembap, suhu 18–22°C, tempat teduh/gelap sampai berkecambah. Jaga rockwool tetap lembap, jangan tergenang.</p>
                </div>
                <div class="stage-card">
                    <span class="stage-day">HARI 3–14</span>
                    <h4>🌿 Pembibitan (Seedling)</h4>
                    <p>Setelah muncul daun sejati, mulai kena cahaya 12–14 jam/hari. Berikan nutrisi encer (EC 0.4–0.8) agar akar tidak "kaget".</p>
                </div>
                <div class="stage-card">
                    <span class="stage-day">HARI 14–35</span>
                    <h4>🥬 Vegetatif</h4>
                    <p>Pindah ke sistem NFT/DWC dengan jarak tanam 15–20 cm. Nutrisi dinaikkan bertahap ke EC 1.0–1.6, cahaya 14–16 jam/hari.</p>
                </div>
                <div class="stage-card">
                    <span class="stage-day">HARI 35–45</span>
                    <h4>✂️ Panen</h4>
                    <p>Panen saat daun terluar sudah lebar dan renyah, sebelum tanaman bolting (berbunga). Panen pagi hari untuk kesegaran maksimal.</p>
                </div>
            </div>

            <!-- Dictionary -->
            <div class="section-title"><i data-lucide="book-open" class="nav-icon"></i> Kamus Kebutuhan Tanam</div>
            <p class="section-sub">Klik tiap istilah untuk melihat penjelasan lengkapnya.</p>
            <div class="dict-list">

                <details class="dict-item" open>
                    <summary>
                        <span class="dict-icon"><i data-lucide="thermometer"></i></span>
                        <span class="dict-term">Suhu (Temperature)</span>
                        <span class="dict-range">18–24°C</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Selada adalah tanaman iklim sejuk. Suhu air ideal <b>18–24°C</b>, suhu udara siang <b>20–24°C</b> dan malam <b>15–18°C</b>.
                        Di atas 26–28°C, selada mudah stres, daun pahit, dan cepat <b>bolting</b> (berbunga sebelum waktunya). Gunakan chiller atau
                        naungan/shading net bila suhu lingkungan panas.
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="droplets"></i></span>
                        <span class="dict-term">pH Larutan Nutrisi</span>
                        <span class="dict-range">5.5–6.5</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        pH ideal ada di <b>5.5–6.5</b>, dengan titik optimal sekitar <b>6.0</b>. Di luar rentang ini, akar sulit menyerap unsur hara
                        tertentu meski nutrisinya cukup (disebut <b>nutrient lockout</b>) — misalnya besi (Fe) sulit diserap saat pH &gt; 6.5,
                        sedangkan pH &lt; 5.5 bisa merusak akar halus. Cek dan sesuaikan pH minimal 1–2 kali sehari.
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="test-tube-diagonal"></i></span>
                        <span class="dict-term">Nutrisi (EC / TDS / PPM)</span>
                        <span class="dict-range">560–840 ppm</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Gunakan pupuk AB Mix khusus sayuran daun. Target EC (electrical conductivity) naik bertahap sesuai umur tanaman:
                        <b>bibit 0.4–0.8 EC (± 280–560 ppm)</b>, <b>vegetatif 1.0–1.6 EC (± 700–1120 ppm)</b>. Selada termasuk tanaman yang
                        sensitif terhadap nutrisi berlebih — kelebihan EC membuat ujung daun terbakar (<b>tip burn</b>).
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="sun"></i></span>
                        <span class="dict-term">Cahaya (Light / DLI)</span>
                        <span class="dict-range">14–16 jam</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Selada butuh <b>14–16 jam cahaya/hari</b> dengan intensitas (PPFD) <b>150–250 µmol/m²/s</b>, setara DLI (Daily Light
                        Integral) <b>12–17 mol/m²/hari</b>. Bila memakai grow light LED full-spectrum, jaga jarak lampu ke daun 30–40 cm agar
                        tidak terlalu panas maupun terlalu redup.
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="droplet"></i></span>
                        <span class="dict-term">Kelembapan Udara (Humidity)</span>
                        <span class="dict-range">50–70%</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Kelembapan relatif ideal <b>50–70%</b>. Kelembapan yang terlalu tinggi (&gt;80%) memicu jamur dan penyakit daun,
                        sedangkan yang terlalu rendah (&lt;40%) mempercepat transpirasi berlebih sehingga memperbesar risiko <b>tip burn</b>
                        karena kalsium tidak sempat terdistribusi ke ujung daun.
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="wind"></i></span>
                        <span class="dict-term">Oksigen Terlarut (Dissolved Oxygen)</span>
                        <span class="dict-range">&gt; 5 mg/L</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Akar selada butuh oksigen terlarut minimal <b>5 mg/L</b> dalam larutan nutrisi. Gunakan air pump + air stone
                        (untuk sistem DWC) atau pastikan aliran air terus mengalir (untuk sistem NFT) agar akar tidak kekurangan oksigen,
                        yang bisa memicu <b>busuk akar (root rot)</b>.
                    </div>
                </details>

                <details class="dict-item">
                    <summary>
                        <span class="dict-icon"><i data-lucide="layout-grid"></i></span>
                        <span class="dict-term">Jarak Tanam &amp; Media</span>
                        <span class="dict-range">15–20 cm</span>
                        <i data-lucide="chevron-down" class="chevron"></i>
                    </summary>
                    <div class="dict-body">
                        Jarak antar lubang net pot <b>15–20 cm</b> agar daun tidak saling menaungi. Media tanam yang umum dipakai:
                        <b>rockwool</b> untuk semai, dipindah ke <b>net pot</b> berisi sedikit media (rockwool/hidroton) saat masuk sistem
                        NFT/DWC/Wick.
                    </div>
                </details>
            </div>

            <!-- Common problems -->
            <div class="section-title"><i data-lucide="alert-triangle" class="nav-icon"></i> Masalah Umum &amp; Solusinya</div>
            <div class="problem-grid">
                <div class="problem-card">
                    <h4><i data-lucide="flame" class="nav-icon"></i> Tip Burn (Ujung Daun Cokelat/Kering)</h4>
                    <div class="row"><b>Penyebab:</b> Kekurangan kalsium di ujung daun akibat kelembapan rendah, suhu tinggi, atau EC terlalu tinggi.</div>
                    <div class="row"><b>Solusi:</b> Turunkan suhu &amp; naikkan kelembapan, pastikan sirkulasi udara baik, jangan menaikkan EC terlalu cepat.</div>
                </div>
                <div class="problem-card">
                    <h4><i data-lucide="droplet" class="nav-icon"></i> Busuk Akar (Root Rot)</h4>
                    <div class="row"><b>Penyebab:</b> Suhu air &gt; 26°C, oksigen terlarut rendah, atau air jarang diganti sehingga bakteri/jamur berkembang.</div>
                    <div class="row"><b>Solusi:</b> Turunkan suhu air, tambah aerasi (air stone), ganti/kuras larutan nutrisi secara berkala.</div>
                </div>
                <div class="problem-card">
                    <h4><i data-lucide="flower-2" class="nav-icon"></i> Bolting (Berbunga Dini)</h4>
                    <div class="row"><b>Penyebab:</b> Suhu terlalu panas dan/atau durasi cahaya terlalu panjang, biasanya dipicu stres panas berkepanjangan.</div>
                    <div class="row"><b>Solusi:</b> Jaga suhu tetap sejuk, gunakan varietas tahan panas (heat-tolerant) bila menanam di iklim panas, panen tepat waktu.</div>
                </div>
                <div class="problem-card">
                    <h4><i data-lucide="leaf" class="nav-icon"></i> Daun Menguning</h4>
                    <div class="row"><b>Penyebab:</b> Kekurangan nitrogen, atau pH di luar rentang ideal sehingga nutrisi tidak terserap (nutrient lockout).</div>
                    <div class="row"><b>Solusi:</b> Cek dan koreksi pH ke 5.5–6.5 dahulu, lalu evaluasi konsentrasi nutrisi (EC) sebelum menambah pupuk.</div>
                </div>
                <div class="problem-card">
                    <h4><i data-lucide="move-vertical" class="nav-icon"></i> Bibit Kurus &amp; Melar (Etiolasi)</h4>
                    <div class="row"><b>Penyebab:</b> Cahaya kurang saat fase pembibitan sehingga batang memanjang mencari cahaya.</div>
                    <div class="row"><b>Solusi:</b> Dekatkan/tambah intensitas grow light, pastikan durasi cahaya minimal 12–14 jam sejak muncul daun sejati.</div>
                </div>
                <div class="problem-card">
                    <h4><i data-lucide="bug" class="nav-icon"></i> Hama Daun (Kutu/Ulat)</h4>
                    <div class="row"><b>Penyebab:</b> Sistem terbuka tanpa penghalang (net/insect screen), terutama pada greenhouse semi-terbuka.</div>
                    <div class="row"><b>Solusi:</b> Pasang insect net, gunakan pestisida nabati (mis. ekstrak nimba) bila diperlukan, jaga kebersihan area tanam.</div>
                </div>
            </div>

            <!-- Harvest note -->
            <div class="section-title"><i data-lucide="scissors" class="nav-icon"></i> Tips Panen</div>
            <div class="note-card">
                <i data-lucide="check-circle-2" class="nav-icon"></i>
                <div>
                    <p><b>Ciri siap panen:</b> daun terluar sudah lebar, renyah, dan berwarna hijau segar (belum menguning), biasanya pada hari ke-35–45 tergantung varietas.</p>
                    <p><b>Waktu terbaik:</b> panen di pagi hari saat suhu masih sejuk agar daun tetap renyah dan tidak cepat layu.</p>
                    <p><b>Cara panen:</b> untuk sistem NFT/DWC, angkat seluruh net pot lalu potong akar di pangkal batang; untuk panen bertahap, ambil daun terluar saja dan biarkan bagian tengah terus tumbuh.</p>
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
                if (window.innerWidth <= 800) closeSidebar();
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 800) closeSidebar();
        });

        lucide.createIcons();
    </script>
</body>
</html>