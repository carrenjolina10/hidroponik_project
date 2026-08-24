<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Monitoring Data - PlantAI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        :root {
            --primary: #CFECF3;
            --secondary: #F9B2D7;
            --accent: #F6FFDC;
            --dark: #1a1a2e;
            --darker: #16213e;
            --light: #ffffff;
            --gray: #f0f4f8;
            --text: #2d3748;
            --text-light: #718096;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
            --glass: rgba(255, 255, 255, 0.7);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated background */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bg-decoration::before,
        .bg-decoration::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.4;
            filter: blur(80px);
        }

        .bg-decoration::before {
            width: 600px;
            height: 600px;
            background: var(--primary);
            top: -200px;
            right: -100px;
            animation: float 20s infinite ease-in-out;
        }

        .bg-decoration::after {
            width: 500px;
            height: 500px;
            background: var(--secondary);
            bottom: -150px;
            left: -100px;
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

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.5px;
        }

        .sidebar h2 span {
            font-size: 1.8rem;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar nav a {
            text-decoration: none;
            color: var(--text-light);
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--primary), transparent);
            transition: width 0.3s ease;
            opacity: 0.3;
        }

        .sidebar nav a:hover::before,
        .sidebar nav a.active::before {
            width: 100%;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            color: var(--dark);
            background: rgba(207, 236, 243, 0.3);
            transform: translateX(5px);
        }

        .sidebar nav a.active {
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(207, 236, 243, 0.4);
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem 2.5rem;
            max-width: calc(100% - 260px);
        }

        /* Header */
        .header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-text h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .header-text p {
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            background: rgba(255, 255, 255, 0.9);
        }

        /* Form Card */
        .form-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
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
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header .icon-wrapper {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(207, 236, 243, 0.4);
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group label .label-icon {
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(207, 236, 243, 0.3);
        }

        .form-group input::placeholder {
            color: var(--text-light);
            opacity: 0.6;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            bottom: 0.875rem;
            font-size: 1.2rem;
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .form-group input:focus + .input-icon,
        .form-group input:not(:placeholder-shown) + .input-icon {
            opacity: 1;
        }

        /* Input hints */
        .input-hint {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .input-hint.warning {
            color: var(--warning);
        }

        /* Submit Button */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-submit {
            flex: 1;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, var(--dark), var(--darker));
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(26, 26, 46, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 26, 46, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-reset {
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            color: var(--text);
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: var(--text-light);
        }

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

@media (max-width: 800px) {
    .mobile-menu-toggle {
        position: fixed;
        top: 16px;
        left: 16px;
        z-index: 1001;
    }

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
}

        /* Validation states */
        .form-group.has-error input {
            border-color: var(--danger);
            background: rgba(245, 101, 101, 0.05);
        }



        .form-group.has-error .error-message {
            display: flex;
        }

        .error-message {
            display: none;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 0.375rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 0.1s; transform: translateY(20px); }
        .delay-2 { animation-delay: 0.2s; transform: translateY(20px); }
        .delay-3 { animation-delay: 0.3s; transform: translateY(20px); }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main {
                margin-left: 0;
                max-width: 100%;
                padding: 1.5rem;
            }
            
            .form-card {
                padding: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>
</head>
<body>

    <div class="bg-decoration"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="container">

        <aside class="sidebar" id="sidebar">

        <img src="{{ asset('image/bagus_hidro_logo.png') }}" alt="Hidroponik BAGUS">

        <nav>

            <a href="{{ route('index.index') }}" >
                <span class="nav-icon">
                    <i data-lucide="layout-dashboard"></i>
                </span>
                Dashboard
            </a>

            <a href="{{ route('index.create') }}" class="active">
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
                    <h2>New Sensor Reading</h2>
                    <p>Fill in the details below to record a new data point</p>
                </div>

                <form action="{{ route('index.store') }}" method="POST">
                    @csrf

                    <!-- ID Input -->
                    <div class="form-group fade-in delay-1">
                        <label for="idTumbuhan"> Plant ID
                        </label>
                        <input 
                            type="text" 
                            id="idTumbuhan" 
                            name="idTumbuhan" 
                            placeholder="Unique Characters"
                            required
                        >
                    </div>

                    <!-- Suhu Input -->
                    <div class="form-group fade-in delay-2">
                        <label for="suhu"> Temperature
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
                    </div>

                    <!-- pH Input -->
                    <div class="form-group fade-in delay-2">
                        <label for="pH"> pH Level
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
                    </div>

                    <!-- Nutrisi Input -->
                    <div class="form-group fade-in delay-3">
                        <label for="nutrisi"> Nutritient
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