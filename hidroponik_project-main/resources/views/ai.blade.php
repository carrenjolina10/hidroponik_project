<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Plant Disease Detection</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =========================
           AI PAGE
        ========================= */

        .ai-content {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 24px;
            margin-top: 28px;
            margin-bottom: 28px;
        }

        .ai-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .ai-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .ai-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(72, 187, 120, 0.12);
            color: #48bb78;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-card-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .ai-card-header p {
            margin: 4px 0 0;
            color: #718096;
            font-size: 13px;
        }

        /* Upload area */

        .upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 16px;
            min-height: 330px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            text-align: center;
            padding: 30px;

            transition: 0.3s;
        }

        .upload-area:hover {
            border-color: #48bb78;
            background: rgba(72, 187, 120, 0.025);
        }

        .upload-icon {
            width: 70px;
            height: 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background: #f0fff4;
            color: #48bb78;

            margin-bottom: 18px;
        }

        .upload-area h4 {
            margin: 0 0 8px;
            font-size: 17px;
        }

        .upload-area p {
            color: #718096;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .file-input {
            display: none;
        }

        .upload-button {
            border: none;
            cursor: pointer;

            padding: 12px 22px;
            border-radius: 10px;

            background: linear-gradient(
                135deg,
                #48bb78,
                #38a169
            );

            color: white;
            font-weight: 600;

            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.25);

            transition: 0.2s;
        }

        .upload-button:hover {
            transform: translateY(-2px);
        }

        .file-name {
            margin-top: 14px;
            font-size: 12px;
            color: #718096;
        }

        /* Image preview */

        .image-preview {
            display: none;
            margin-top: 20px;
        }

        .image-preview img {
            width: 100%;
            max-height: 280px;
            object-fit: contain;

            border-radius: 14px;
            background: #f7fafc;
        }

        .predict-button {
            width: 100%;
            margin-top: 18px;

            border: none;
            cursor: pointer;

            padding: 14px;

            border-radius: 11px;

            background: #1a202c;
            color: white;

            font-size: 14px;
            font-weight: 600;

            transition: 0.2s;
        }

        .predict-button:hover {
            background: #2d3748;
            transform: translateY(-1px);
        }

        /* Result */

        .result-empty {
            min-height: 330px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            text-align: center;
        }

        .result-empty-icon {
            width: 64px;
            height: 64px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background: #f7fafc;
            color: #a0aec0;

            margin-bottom: 16px;
        }

        .result-empty h4 {
            margin: 0 0 8px;
        }

        .result-empty p {
            color: #718096;
            font-size: 13px;
            max-width: 260px;
        }

        /* Result */

        .result-box {
            min-height: 330px;
        }

        .prediction-label {
            color: #718096;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .prediction-name {
            margin: 8px 0 22px;

            font-size: 25px;
            font-weight: 700;

            color: #1a202c;
        }

        .confidence-container {
            margin-top: 20px;
        }

        .confidence-header {
            display: flex;
            justify-content: space-between;

            margin-bottom: 9px;

            font-size: 13px;
        }

        .confidence-value {
            color: #38a169;
            font-weight: 700;
        }

        .confidence-bar {
            height: 10px;
            border-radius: 10px;

            background: #edf2f7;

            overflow: hidden;
        }

        .confidence-progress {
            height: 100%;

            background: linear-gradient(
                90deg,
                #68d391,
                #38a169
            );

            border-radius: 10px;
        }

        .result-info {
            margin-top: 25px;

            padding-top: 20px;

            border-top: 1px solid #edf2f7;
        }

        .result-row {
            display: flex;
            justify-content: space-between;

            padding: 8px 0;

            font-size: 13px;
        }

        .result-row span:first-child {
            color: #718096;
        }

        .result-row span:last-child {
            font-weight: 600;
        }

        /* AI status */

        .ai-status {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-top: 24px;

            font-size: 12px;
            color: #48a868;
        }

        .status-dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;
            background: #48bb78;

            box-shadow: 0 0 0 4px rgba(72, 187, 120, 0.12);
        }

        /* Responsive (tablet) */

        @media (max-width: 900px) {
            .ai-content {
                grid-template-columns: 1fr;
            }
        }

        /* =========================================================
           MOBILE MENU TOGGLE (hamburger) — hanya tampilan baru,
           tidak ada perubahan pada class / route / PHP logic
        ========================================================= */

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

            .ai-content {
                gap: 16px;
                margin-top: 20px;
            }

            .ai-card {
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

            .upload-area,
            .result-empty,
            .result-box {
                min-height: 260px;
            }
        }

        @media (max-width: 480px) {
            .status-grid {
                grid-template-columns: 1fr;
            }

            .ai-card {
                padding: 16px;
                border-radius: 14px;
            }

            .prediction-name {
                font-size: 21px;
            }
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

            <a href="{{ url('/ai') }}" class="active">
                <span class="nav-icon">
                    <i data-lucide="scan-search"></i>
                </span>
                AI Detection
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

                                <span style="color:#38a169;">
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


        <!-- INFORMATION CARD -->

        <section class="status-card fade-in delay-4">

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