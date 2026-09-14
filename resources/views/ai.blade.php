<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Plant Disease Detection</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =========================================================
           HARVEST-STYLE REDESIGN
           Sidebar hijau tua + lime, kartu putih rounded, konsisten
           dengan halaman lain (Dashboard, History, New Data, Guide).
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

        .bg-decoration { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .bg-decoration::before,
        .bg-decoration::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.35;
            filter: blur(90px);
        }
        .bg-decoration::before { width: 560px; height: 560px; background: var(--primary); top: -220px; right: -120px; }
        .bg-decoration::after { width: 480px; height: 480px; background: var(--darker); bottom: -180px; left: -120px; }

        .container { display: flex; min-height: 100vh; width: 100%; position: relative; z-index: 1; }

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

        .header-text h1 { font-size: 1.55rem; font-weight: 800; color: var(--dark); letter-spacing: -0.3px; margin-bottom: 3px; }
        .header-text p { font-size: 0.9rem; color: var(--text-light); }

        .header-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

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

        /* ---------------- AI CONTENT (upload + result) ---------------- */
        .ai-content {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 20px;
            margin-bottom: 22px;
        }

        .ai-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 26px;
            box-shadow: var(--shadow);
        }

        .ai-card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; }

        .ai-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: var(--primary);
            color: var(--dark);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .ai-card-header h3 { margin: 0; font-size: 17px; color: var(--dark); font-weight: 800; }
        .ai-card-header p { margin: 4px 0 0; color: var(--text-light); font-size: 13px; }

        /* Upload area */
        .upload-area {
            border: 2px dashed var(--line);
            border-radius: 16px;
            min-height: 320px;
            background: var(--bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px;
            transition: 0.25s ease;
        }

        .upload-area:hover {
            border-color: var(--secondary);
            background: rgba(198, 242, 78, 0.08);
        }

        .upload-icon {
            width: 68px; height: 68px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 18px;
            background: var(--primary);
            color: var(--dark);
            margin-bottom: 18px;
        }

        .upload-area h4 { margin: 0 0 8px; font-size: 16.5px; color: var(--dark); font-weight: 700; }
        .upload-area p { color: var(--text-light); font-size: 13px; margin-bottom: 20px; }

        .file-input { display: none; }

        .upload-button {
            border: none;
            cursor: pointer;
            padding: 12px 22px;
            border-radius: 10px;
            background: var(--dark);
            color: var(--primary);
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(14, 41, 19, 0.25);
            transition: 0.2s ease;
        }

        .upload-button:hover { transform: translateY(-2px); }

        .file-name { margin-top: 14px; font-size: 12px; color: var(--text-light); }

        /* Image preview */
        .image-preview { display: none; margin-top: 20px; }

        .image-preview img {
            width: 100%; max-height: 280px;
            object-fit: contain;
            border-radius: 14px;
            background: var(--bg);
        }

        .predict-button {
            width: 100%;
            margin-top: 18px;
            border: none;
            cursor: pointer;
            padding: 14px;
            border-radius: 11px;
            background: var(--dark);
            color: var(--primary);
            font-size: 14px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .predict-button:hover { background: var(--darker); transform: translateY(-1px); }

        /* Result empty */
        .result-empty {
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .result-empty-icon {
            width: 62px; height: 62px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 18px;
            background: var(--bg);
            color: var(--text-light);
            margin-bottom: 16px;
        }

        .result-empty h4 { margin: 0 0 8px; color: var(--dark); }
        .result-empty p { color: var(--text-light); font-size: 13px; max-width: 260px; }

        /* Result box */
        .result-box { min-height: 320px; }

        .prediction-label {
            color: var(--text-light);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 700;
        }

        .prediction-name {
            margin: 8px 0 22px;
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
            text-transform: capitalize;
        }

        .confidence-container { margin-top: 20px; }

        .confidence-header {
            display: flex; justify-content: space-between;
            margin-bottom: 9px;
            font-size: 13px;
        }

        .confidence-value { color: var(--success); font-weight: 700; }

        .confidence-bar {
            height: 10px;
            border-radius: 10px;
            background: var(--line);
            overflow: hidden;
        }

        .confidence-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--secondary), var(--success));
            border-radius: 10px;
        }

        .result-info {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        .result-row {
            display: flex; justify-content: space-between;
            padding: 8px 0;
            font-size: 13px;
        }

        .result-row span:first-child { color: var(--text-light); }
        .result-row span:last-child { font-weight: 700; color: var(--dark); }

        .ai-status {
            display: flex; align-items: center; gap: 8px;
            margin-top: 24px;
            font-size: 12px;
            color: var(--success);
            font-weight: 600;
        }

        .status-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 0 4px rgba(72, 187, 120, 0.15);
        }

        @media (max-width: 900px) {
            .ai-content { grid-template-columns: 1fr; }
        }

        /* ---------------- AI PREDICTION HISTORY ---------------- */
        .history-card {
            background: var(--card);
            border-radius: var(--radius);
            margin-bottom: 22px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .history-header {
            padding: 22px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid var(--line);
            flex-wrap: wrap;
        }

        .history-title { display: flex; align-items: center; gap: 14px; }

        .history-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: var(--primary);
            color: var(--dark);
            display: flex; align-items: center; justify-content: center;
        }

        .history-title h3 { margin: 0; font-size: 17px; color: var(--dark); font-weight: 800; }
        .history-title p { margin: 4px 0 0; color: var(--text-light); font-size: 13px; }

        .history-search-wrapper { position: relative; width: 300px; }

        .history-search-wrapper i {
            position: absolute; left: 15px; top: 50%;
            transform: translateY(-50%);
            width: 18px; color: var(--text-light);
        }

        .history-search-wrapper input {
            width: 100%; height: 46px;
            padding: 0 16px 0 44px;
            border: 2px solid var(--line);
            border-radius: 50px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            outline: none;
            box-sizing: border-box;
            background: var(--bg);
            transition: all 0.2s ease;
        }

        .history-search-wrapper input:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(198, 242, 78, 0.3);
        }

        .history-table-wrapper { width: 100%; overflow-x: auto; }
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table thead { background: var(--bg); }

        .history-table th {
            padding: 16px 24px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-light);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .history-table td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
            color: var(--text);
        }

        .history-table tbody tr { transition: background 0.2s ease; }
        .history-table tbody tr:hover { background: rgba(198, 242, 78, 0.1); }
        .history-table tbody tr:last-child td { border-bottom: none; }

        .prediction-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 9px;
            background: rgba(72, 187, 120, 0.12);
            color: var(--success);
            font-weight: 700;
            text-transform: capitalize;
        }

        .history-table .confidence-value { font-weight: 700; color: var(--dark); }

        .history-empty { padding: 60px 20px; text-align: center; }
        .history-empty i { width: 42px; height: 42px; margin-bottom: 15px; color: var(--text-light); }
        .history-empty h3 { margin: 0 0 8px; font-size: 19px; color: var(--dark); }
        .history-empty p { margin: 0; font-size: 14px; color: var(--text-light); }

        @media (max-width: 900px) {
            .history-header { align-items: stretch; flex-direction: column; }
            .history-search-wrapper { width: 100%; }
            .history-table th, .history-table td { padding: 13px 16px; }
        }

        /* ---------------- INFO / STATUS CARD ---------------- */
        .status-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .status-card h3 { font-size: 16.5px; font-weight: 700; color: var(--dark); margin-bottom: 16px; }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .status-item { background: var(--bg); border-radius: 14px; padding: 16px 18px; }
        .status-item span { display: block; font-size: 12px; color: var(--text-light); font-weight: 600; margin-bottom: 6px; }
        .status-item h4 { font-size: 16px; font-weight: 700; color: var(--dark); }

        /* ---------------- FADE-IN ---------------- */
        .fade-in { animation: fadeIn 0.5s ease-out forwards; opacity: 0; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: .05s; transform: translateY(14px); }
        .delay-2 { animation-delay: .1s; transform: translateY(14px); }
        .delay-3 { animation-delay: .15s; transform: translateY(14px); }
        .delay-4 { animation-delay: .2s; transform: translateY(14px); }
        .delay-5 { animation-delay: .25s; transform: translateY(14px); }

        /* ---------------- MOBILE MENU ---------------- */
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

        @media (max-width: 800px) {
            .mobile-menu-toggle { position: fixed; top: 16px; left: 16px; z-index: 1001; }
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

            .sidebar.active { transform: translateX(0); z-index: 99999 !important; }

            .main { margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 18px 16px !important; }

            .mobile-menu-toggle { display: flex; }

            .header { padding: 16px 16px 16px 58px; }

            .header-text h1 { font-size: 20px; }
            .header-actions { width: 100%; }

            .ai-content { gap: 16px; margin-top: 20px; }
            .ai-card { padding: 20px; }
            .status-card { margin-top: 16px; padding: 20px; }
            .status-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }

            .upload-area, .result-empty, .result-box { min-height: 260px; }
        }

        @media (max-width: 480px) {
            .status-grid { grid-template-columns: 1fr; }
            .ai-card { padding: 16px; border-radius: 14px; }
            .prediction-name { font-size: 21px; }
        }
    </style>
</head>

<body>

<div class="bg-decoration"></div>

<!-- overlay gelap saat sidebar mobile terbuka (elemen baru, tidak mengganggu logic AI) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="container">

    <!-- SIDEBAR -->

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
                <a href="{{ url('/ai') }}" class="active">
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


    <!-- MAIN -->

    <main class="main">

        <!-- HEADER -->

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

                <h1>AI Plant Detection</h1>

                <p>
                    Detect lettuce diseases using Artificial Intelligence
                </p>

            </div>

            <div class="header-actions">

                <div class="status-badge">
                    AI System Online
                </div>

            </div>

        </header>


        <!-- AI CONTENT -->

        <section class="ai-content">


            <!-- UPLOAD CARD -->

            <div class="ai-card fade-in delay-2">

                <div class="ai-card-header">

                    <div class="ai-icon">
                        <i data-lucide="image-up"></i>
                    </div>

                    <div>
                        <h3>Plant Image</h3>

                        <p>
                            Upload a lettuce image for analysis
                        </p>
                    </div>

                </div>


                <form
                    action="{{ route('ai.predict') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="aiForm"
                >

                    @csrf

                    <div class="upload-area">

                        <div class="upload-icon">
                            <i data-lucide="camera" size="32"></i>
                        </div>

                        <h4>
                            Upload Plant Image
                        </h4>

                        <p>
                            JPG, JPEG or PNG image
                        </p>

                        <label for="file" class="upload-button">
                            Choose Image
                        </label>

                        <input
                            id="file"
                            name="file"
                            type="file"
                            class="file-input"
                            accept="image/*"
                            required
                        >

                        <div
                            class="file-name"
                            id="fileName"
                        >
                            No image selected
                        </div>

                    </div>


                    <!-- IMAGE PREVIEW -->

                    <div
                        class="image-preview"
                        id="imagePreview"
                    >
                        <img
                            id="preview"
                            src=""
                            alt="Plant Preview"
                        >
                    </div>


                    <button
                        type="submit"
                        class="predict-button"
                        id="predictButton"
                    >
                        <i data-lucide="sparkles"></i>
                        Analyze Plant
                    </button>

                </form>

            </div>


            <!-- RESULT CARD -->

            <div class="ai-card fade-in delay-3">

                <div class="ai-card-header">

                    <div class="ai-icon">
                        <i data-lucide="brain"></i>
                    </div>

                    <div>
                        <h3>AI Analysis</h3>

                        <p>
                            Machine learning prediction result
                        </p>
                    </div>

                </div>


                @if(isset($result))

                    <div class="result-box">

                        <span class="prediction-label">
                            Detected Condition
                        </span>

                        <div class="prediction-name">
                            {{ str_replace('_', ' ', $result['prediction']) }}
                        </div>


                        <div class="confidence-container">

                            <div class="confidence-header">

                                <span>
                                    Confidence
                                </span>

                                <span class="confidence-value">
                                    {{ number_format($result['confidence'] * 100, 2) }}%
                                </span>

                            </div>


                            <div class="confidence-bar">

                                <div
                                    class="confidence-progress"
                                    style="width: {{ $result['confidence'] * 100 }}%"
                                ></div>

                            </div>

                        </div>


                        <div class="result-info">

                            <div class="result-row">

                                <span>
                                    Image
                                </span>

                                <span>
                                    {{ $result['filename'] }}
                                </span>

                            </div>

                            <div class="result-row">

                                <span>
                                    AI Model
                                </span>

                                <span>
                                    EfficientNet-B0
                                </span>

                            </div>

                            <div class="result-row">

                                <span>
                                    Status
                                </span>

                                <span style="color: var(--success);">
                                    Analysis Complete
                                </span>

                            </div>

                        </div>


                        <div class="ai-status">

                            <div class="status-dot"></div>

                            AI analysis completed successfully

                        </div>

                    </div>

                @else

                    <div class="result-empty">

                        <div class="result-empty-icon">
                            <i data-lucide="scan-line" size="30"></i>
                        </div>

                        <h4>
                            Waiting for Analysis
                        </h4>

                        <p>
                            Upload a lettuce image and click
                            <strong>Analyze Plant</strong>
                            to see the AI prediction.
                        </p>

                    </div>

                @endif

            </div>

        </section>

        <!-- AI PREDICTION HISTORY -->
<section class="history-card fade-in delay-4">

    <div class="history-header">

        <div class="history-title">

            <div class="history-icon">
                <i data-lucide="clipboard-list"></i>
            </div>

            <div>
                <h3>All AI Predictions</h3>

                <p>
                    History of lettuce disease detection
                </p>
            </div>

        </div>


        <div class="history-search-wrapper">

            <i data-lucide="search"></i>

            <input
                type="text"
                id="predictionSearch"
                placeholder="Search by ID or value..."
            >

        </div>

    </div>


    @if(isset($predictions) && $predictions->count() > 0)

        <div class="history-table-wrapper">

            <table class="history-table">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>IMAGE</th>
                        <th>PREDICTION</th>
                        <th>CONFIDENCE</th>
                        <th>MODEL</th>
                        <th>RECORDED</th>
                    </tr>

                </thead>


                <tbody id="predictionTable">

                    @foreach($predictions as $prediction)

                        <tr>

                            <td>
                                {{ $prediction->id }}
                            </td>

                            <td>
                                {{ $prediction->filename }}
                            </td>

                            <td>

                                <span class="prediction-badge">
                                    {{ str_replace('_', ' ', $prediction->prediction) }}
                                </span>

                            </td>

                            <td>

                                <span class="confidence-value">
                                    {{ number_format($prediction->confidence * 100, 2) }}%
                                </span>

                            </td>

                            <td>
                                {{ $prediction->model }}
                            </td>

                            <td>
                                {{ $prediction->created_at->format('d M Y, H:i') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="history-empty">

            <i data-lucide="mail-open"></i>

            <h3>Belum ada data history</h3>

            <p>
                Hasil analisis AI akan muncul di sini.
            </p>

        </div>

    @endif

</section>


        <!-- INFORMATION CARD -->

        <section class="status-card fade-in delay-5">

            <h3>
                AI Detection Information
            </h3>

            <div class="status-grid">

                <div class="status-item">

                    <span>
                        Model
                    </span>

                    <h4>
                        🤖 EfficientNet-B0
                    </h4>

                </div>


                <div class="status-item">

                    <span>
                        Supported
                    </span>

                    <h4>
                        🌱 Lettuce Disease
                    </h4>

                </div>


                <div class="status-item">

                    <span>
                        Backend
                    </span>

                    <h4>
                        ⚡ FastAPI
                    </h4>

                </div>

            </div>

        </section>

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

    lucide.createIcons();


    // ==========================
    // IMAGE PREVIEW
    // ==========================

    const fileInput = document.getElementById('file');
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            fileName.textContent = 'No image selected';

            imagePreview.style.display = 'none';

            return;
        }

        fileName.textContent = file.name;

        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;

            imagePreview.style.display = 'block';

        };

        reader.readAsDataURL(file);

    });


    // ==========================
    // LOADING STATE
    // ==========================

    document
        .getElementById('aiForm')
        .addEventListener('submit', function () {

            const button =
                document.getElementById('predictButton');

            button.innerHTML =
                '⏳ Analyzing Plant...';

            button.disabled = true;

            button.style.opacity = '0.7';

        });


    // ==========================
    // MOBILE SIDEBAR TOGGLE
    // (tambahan baru, tidak mengubah logic form/AI di atas)
    // ==========================

    const sidebar = document.getElementById('sidebar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('active');
        sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileMenuToggle.addEventListener('click', function () {

        if (sidebar.classList.contains('active')) {
            closeSidebar();
        } else {
            openSidebar();
        }

    });

    sidebarOverlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('nav a').forEach(function (link) {
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

</body>
</html>