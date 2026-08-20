<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - Hidroponik Bagus</title>
    <link rel="icon" href="<?php echo e(asset('img/favicon.ico')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

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
            --info: #4299e1;
            --glass: rgba(255, 255, 255, 0.7);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
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
            opacity: 0.4;
            filter: blur(80px);
        }

        .bg-decoration::before {
            width: 600px; height: 600px;
            background: var(--primary);
            top: -200px; right: -100px;
            animation: float 20s infinite ease-in-out;
        }

        .bg-decoration::after {
            width: 500px; height: 500px;
            background: var(--secondary);
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

        .sidebar h2 span { font-size: 1.8rem; }

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
            left: 0; top: 0;
            height: 100%; width: 0;
            background: linear-gradient(90deg, var(--primary), transparent);
            transition: width 0.3s ease;
            opacity: 0.3;
        }

        .sidebar nav a:hover::before,
        .sidebar nav a.active::before { width: 100%; }

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
            width: 24px; height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Main */
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
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, var(--dark), var(--darker));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 26, 46, 0.3);
            border: none;
            cursor: pointer;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 26, 46, 0.4);
        }

        /* Alert */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
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

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .stat-icon.green { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
        .stat-icon.orange { background: linear-gradient(135deg, #fef3c7, #fde68a); }
        .stat-icon.pink { background: linear-gradient(135deg, #fce7f3, #fbcfe8); }

        .stat-info h4 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1;
        }

        .stat-info span {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Table Card */
        .table-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-header h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            width: 260px;
            background: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(207, 236, 243, 0.3);
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            opacity: 0.5;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: rgba(240, 244, 248, 0.6);
        }

        th {
            padding: 1rem 1.75rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        td {
            padding: 1rem 1.75rem;
            font-size: 0.9rem;
            color: var(--text);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            white-space: nowrap;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(207, 236, 243, 0.15);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ID Badge */
        .id-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--dark);
        }

        /* Value cells with indicators */
        .value-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .value-bar {
            width: 60px;
            height: 6px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: 3px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .value-bar-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.6s ease;
        }

        .value-bar-fill.temp { background: linear-gradient(90deg, #f56565, #ed8936); }
        .value-bar-fill.ph { background: linear-gradient(90deg, #48bb78, #4299e1); }
        .value-bar-fill.nutri { background: linear-gradient(90deg, #9f7aea, #ed64a6); }

        .value-text {
            font-weight: 600;
            min-width: 60px;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
        }

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

        /* Action buttons */
        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-view {
            background: rgba(66, 153, 225, 0.1);
            color: var(--info);
        }

        .btn-view:hover {
            background: var(--info);
            color: white;
            transform: scale(1.1);
        }

        .btn-edit {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning);
        }

        .btn-edit:hover {
            background: var(--warning);
            color: white;
            transform: scale(1.1);
        }

        .btn-delete {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: scale(1.1);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-light);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
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
        @media (max-width: 1024px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; max-width: 100%; padding: 1.5rem; }
            .stats-row { grid-template-columns: 1fr; }
            .table-header { flex-direction: column; align-items: stretch; }
            .search-box input { width: 100%; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--secondary); }
    </style>
</head>
<body>

    <div class="bg-decoration"></div>

    <div class="container">

        <aside class="sidebar">
            <img src="<?php echo e(asset('img/bagus hidrotext-01.png')); ?>" width=200px>

           <nav>
        <a href="<?php echo e(route('index.index')); ?>">
            <span class="nav-icon">
                <i data-lucide="layout-dashboard"></i>
            </span>
            Dashboard
        </a>

        <a href="<?php echo e(route('index.create')); ?>">
            <span class="nav-icon">
                <i data-lucide="file-plus-2"></i>
            </span>
            New Data
        </a>

        <a href="<?php echo e(route('data')); ?>" class="active">
            <span class="nav-icon">
                <i data-lucide="history"></i>
            </span>
            History
        </a>
         <a href="<?php echo e(url('/ai')); ?>">
                <span class="nav-icon">
                    <i data-lucide="scan-search"></i>
                </span>
                AI Detection
            </a>
    </nav>
        </aside>

        <main class="main">

            <header class="header fade-in delay-1">
                <div class="header-text">
                    <h1>Data Monitoring</h1>
                    <p>Manage and review all sensor readings</p>
                </div>
                <a href="<?php echo e(route('index.create')); ?>" class="btn-add">
                    <span>+</span> Add New Data
                </a>
            </header>

            <?php if(session('success')): ?>
                <div class="alert alert-success fade-in delay-1">
                    ✅ <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

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
                                
                            </tbody>
                        </table>
                </div>
            </div>
        </main>
    </div>
    <script>
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
<script>
    lucide.createIcons();
    </script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
    import {
    getDatabase,ref,onValue
    }
    from "https://www.gstatic.com/firebasejs/10.13.2/firebase-database.js";
    const firebaseConfig = {
    apiKey: "AIzaSyBedy4OHfbdi0jaBE2OrikqKbftqsnkvc0",
    authDomain: "esp32-hydroponic.firebaseapp.com",
    databaseURL:"https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId:"esp32-hydroponic",
    storageBucket:"esp32-hydroponic.firebasestorage.app",
    messagingSenderId:"655265559145",
    appId:"1:655265559145:web:7d0a0c0941d0877c8568f8"
    };

    const app=initializeApp(firebaseConfig);
    const db=getDatabase(app);
    const hydroRef=ref(db,"hydroponic");
    onValue(hydroRef,(snapshot)=>{
    const data=snapshot.val();
    document.getElementById("temperature").innerHTML=
    data.sensor.temperature.toFixed(1)+"°C";
    document.getElementById("phValue").innerHTML=
    data.sensor.phValue.toFixed(2);
    document.getElementById("tdsValue").innerHTML=
    data.sensor.tdsValue.toFixed(0);
    document.getElementById("totalRecords").innerHTML="1";
    document.getElementById("sensorTable").innerHTML=`
        <tr>
            <td><span class="id-badge">#001</span></td>
            <td>${data.sensor.temperature.toFixed(1)} °C</td>
            <td>${data.sensor.phValue.toFixed(2)}</td>
            <td>${data.sensor.tdsValue.toFixed(0)} ppm</td>
            <td>
                <span class="status-badge status-optimal">
                ${data.status.deviceOnline ? "Online" : "Offline"}
                </span>
            </td>
            <td>${new Date().toLocaleString()}</td>
            <td>-</td>
         </tr>
    `;
    });
</script>
</body>
</html><?php /**PATH C:\Users\Ell_27\Documents\Hidroponik_Bagus\hidroponik_project-main\hidroponik_project-main\resources\views/data.blade.php ENDPATH**/ ?>