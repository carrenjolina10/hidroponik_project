<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hydroponic Control</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon"
        href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =========================================================
           HARVEST-STYLE REDESIGN
           Mandiri (tidak bergantung isi css/style.css eksternal untuk
           bagian ini) supaya konsisten dengan halaman lain: sidebar
           hijau tua + lime, kartu putih rounded, mobile drawer.
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

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            margin: 0;
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

        /* ---------------- CONTROL CARDS ---------------- */
        .control-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
        }

        .control-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 26px;
            box-shadow: var(--shadow);
        }

        .control-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 22px;
        }

        .control-header h2 { margin: 0; font-size: 18px; color: var(--dark); font-weight: 800; }
        .control-header p { margin-top: 5px; color: var(--text-light); font-size: 13px; }

        /* ---------------- MODE SELECTOR ---------------- */
        .mode-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .mode-button {
            border: none;
            border-radius: 15px;
            padding: 18px;
            cursor: pointer;
            background: var(--bg);
            color: var(--text-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: all .2s ease;
        }

        .mode-button:hover { transform: translateY(-2px); }

        .mode-button.active {
            background: var(--dark);
            color: var(--primary);
            box-shadow: 0 5px 18px rgba(14, 41, 19, .3);
        }

        .mode-icon { display: block; margin-bottom: 7px; }

        /* ---------------- DISPENSER ---------------- */
        .dispenser-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .dispenser-card {
            background: var(--bg);
            border-radius: 16px;
            padding: 22px;
            border: 1px solid var(--line);
            text-align: center;
            transition: all .2s ease;
        }

        .dispenser-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .dispenser-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            background: var(--primary);
            color: var(--dark);
        }

        .dispenser-card h3 { margin: 0 0 5px; font-size: 16px; color: var(--dark); font-weight: 700; }
        .dispenser-card p { margin: 0 0 18px; font-size: 12px; color: var(--text-light); }

        /* ---------------- TOGGLE ---------------- */
        .switch {
            position: relative;
            display: inline-block;
            width: 58px;
            height: 32px;
        }

        .switch input { opacity: 0; width: 0; height: 0; }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #cbd5e0;
            border-radius: 30px;
            transition: .25s;
        }

        .slider:before {
            content: "";
            position: absolute;
            width: 24px;
            height: 24px;
            left: 4px;
            top: 4px;
            background: white;
            border-radius: 50%;
            transition: .25s;
            box-shadow: 0 2px 5px rgba(0,0,0,.2);
        }

        input:checked + .slider { background: var(--primary); }
        input:checked + .slider:before { transform: translateX(26px); }

        .manual-disabled { opacity: .45; pointer-events: none; }

        /* ---------------- STATUS ---------------- */
        .system-status {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            border-radius: 12px;
            background: rgba(72, 187, 120, 0.12);
            color: var(--success);
            font-size: 13px;
            font-weight: 700;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--success);
        }

        .status-message {
            margin-top: 18px;
            min-height: 20px;
            font-size: 13px;
            color: var(--text-light);
        }

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

            .dispenser-grid { grid-template-columns: repeat(2, 1fr); }
            .control-card { padding: 20px; }
        }

        @media (max-width: 480px) {
            .dispenser-grid { grid-template-columns: 1fr; }
            .mode-container { grid-template-columns: 1fr; }
            .control-card { padding: 16px; border-radius: 14px; }
        }
    </style>

</head>


<body>

<div class="bg-decoration"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="container">

    <!-- SIDEBAR -->

    <aside class="sidebar" id="sidebar">

        <img src="{{ asset('image/bagus_hidro_logo.png') }}"
             alt="Hidroponik BAGUS">

        <nav>

            <a href="{{ route('index.index') }}">
                <span class="nav-icon">
                    <i data-lucide="layout-dashboard"></i>
                </span>
                Dashboard
            </a>

            <a href="{{ route('data') }}">
                <span class="nav-icon">
                    <i data-lucide="history"></i>
                </span>
                History
            </a>

            <a href="{{ url('/ai') }}">
                <span class="nav-icon">
                    <i data-lucide="scan-search"></i>
                </span>
                AI Detection
            </a>

            <a href="{{ url('/control') }}" class="active">
                <span class="nav-icon">
                    <i data-lucide="sliders-horizontal"></i>
                </span>
                Control
            </a>

            <a href="{{ route('index.create') }}">
                <span class="nav-icon">
                    <i data-lucide="file-plus-2"></i>
                </span>
                New Data
            </a>

            <a href="{{ route('lettuce.guide') }}">
                <span class="nav-icon">
                    <i data-lucide="sprout"></i>
                </span>
                Lettuce Guide
            </a>

            

        </nav>

    </aside>


    <!-- MAIN -->

    <main class="main">

        <header class="header">

            <button
                type="button"
                class="mobile-menu-toggle"
                id="mobileMenuToggle"
                aria-label="Buka menu"
            >
                <i data-lucide="menu"></i>
            </button>

            <div class="header-text">

                <h1>Hydroponic Control</h1>

                <p>
                    Control pH and nutrient dispensing system
                </p>

            </div>

            <div class="header-actions">

                <div class="status-badge">
                    System Online
                </div>

            </div>

        </header>


        <div class="control-container">


            <!-- ==========================
                 SYSTEM MODE
            =========================== -->

            <section class="control-card">

                <div class="control-header">

                    <div>

                        <h2>Control Mode</h2>

                        <p>
                            Pilih mode pengoperasian sistem
                        </p>

                    </div>

                    <div class="system-status">

                        <span class="status-dot"></span>

                        <span id="firebaseStatus">
                            Connected
                        </span>

                    </div>

                </div>


                <div class="mode-container">

                    <button
                        id="autoButton"
                        class="mode-button"
                        onclick="setMode('auto')">

                        <span class="mode-icon">
                            <i data-lucide="cpu"></i>
                        </span>

                        AUTO

                    </button>


                    <button
                        id="manualButton"
                        class="mode-button"
                        onclick="setMode('manual')">

                        <span class="mode-icon">
                            <i data-lucide="hand"></i>
                        </span>

                        MANUAL

                    </button>

                </div>

            </section>



            <!-- ==========================
                 MANUAL CONTROL
            =========================== -->

            <section class="control-card">

                <div class="control-header">

                    <div>

                        <h2>Manual Dispenser Control</h2>

                        <p>
                            Aktifkan dispenser secara manual.
                            ESP32 akan mematikan dispenser setelah 1.5 detik.
                        </p>

                    </div>

                </div>


                <div
                    id="manualControls"
                    class="dispenser-grid manual-disabled">


                    <!-- PH UP -->

                    <div class="dispenser-card">

                        <div class="dispenser-icon">

                            <i data-lucide="plus"></i>

                        </div>

                        <h3>pH Up</h3>

                        <p>
                            Menambah pH air
                        </p>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="phUpToggle"
                                onchange="triggerDispenser('phUp', this)">

                            <span class="slider"></span>

                        </label>

                    </div>



                    <!-- PH DOWN -->

                    <div class="dispenser-card">

                        <div class="dispenser-icon">

                            <i data-lucide="minus"></i>

                        </div>

                        <h3>pH Down</h3>

                        <p>
                            Menurunkan pH air
                        </p>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="phDownToggle"
                                onchange="triggerDispenser('phDown', this)">

                            <span class="slider"></span>

                        </label>

                    </div>



                    <!-- MIX A -->

                    <div class="dispenser-card">

                        <div class="dispenser-icon">

                            <i data-lucide="flask-conical"></i>

                        </div>

                        <h3>AB Mix A</h3>

                        <p>
                            Dispenser nutrisi A
                        </p>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="mixAToggle"
                                onchange="triggerDispenser('mixA', this)">

                            <span class="slider"></span>

                        </label>

                    </div>



                    <!-- MIX B -->

                    <div class="dispenser-card">

                        <div class="dispenser-icon">

                            <i data-lucide="flask-conical"></i>

                        </div>

                        <h3>AB Mix B</h3>

                        <p>
                            Dispenser nutrisi B
                        </p>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="mixBToggle"
                                onchange="triggerDispenser('mixB', this)">

                            <span class="slider"></span>

                        </label>

                    </div>


                </div>


                <div
                    id="statusMessage"
                    class="status-message">

                    Pilih mode MANUAL untuk mengaktifkan dispenser.

                </div>

            </section>

        </div>

    </main>

</div>



<!-- ==============================
     FIREBASE
================================ -->


<script type="module">

import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";

import {
    getDatabase,
    ref,
    set,
    onValue
} from "https://www.gstatic.com/firebasejs/10.13.2/firebase-database.js";


/*
|--------------------------------------------------------------------------
| FIREBASE CONFIG
|--------------------------------------------------------------------------
*/

const firebaseConfig = {

    apiKey: "AIzaSyBedy4OHfbdi0jaBE2OrikqKbftqsnkvc0",

    authDomain:
        "esp32-hydroponic.firebaseapp.com",

    databaseURL:
        "https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app",

    projectId:
        "esp32-hydroponic",

    storageBucket:
        "esp32-hydroponic.firebasestorage.app",

    messagingSenderId:
        "655265559145",

    appId:
        "1:655265559145:web:7d0a0c0941d0877c8568f8"

};


/*
|--------------------------------------------------------------------------
| INITIALIZE FIREBASE
|--------------------------------------------------------------------------
*/

const app = initializeApp(firebaseConfig);
const db = getDatabase(app);


/*
|--------------------------------------------------------------------------
| ELEMENT
|--------------------------------------------------------------------------
*/

const autoButton =
    document.getElementById("autoButton");

const manualButton =
    document.getElementById("manualButton");

const manualControls =
    document.getElementById("manualControls");

const statusMessage =
    document.getElementById("statusMessage");

const firebaseStatus =
    document.getElementById("firebaseStatus");


/*
|--------------------------------------------------------------------------
| CURRENT MODE
|--------------------------------------------------------------------------
*/

let currentMode = null;


/*
|--------------------------------------------------------------------------
| DISPENSER STATE
|--------------------------------------------------------------------------
*/

let dispenserBusy = {
    phUp: false,
    phDown: false,
    mixA: false,
    mixB: false
};




function updateModeUI(mode)
{

    currentMode = mode;


    /*
    |--------------------------------------------------------------------------
    | RESET ACTIVE BUTTON
    |--------------------------------------------------------------------------
    */

    autoButton.classList.remove("active");
    manualButton.classList.remove("active");


    /*
    |--------------------------------------------------------------------------
    | AUTO
    |--------------------------------------------------------------------------
    */

    if (mode === "auto") {

        autoButton.classList.add("active");

        manualControls.classList.add(
            "manual-disabled"
        );

        resetToggles();

        statusMessage.innerText =
            "Mode AUTO aktif. ESP32 menjalankan logic otomatis.";

    }


    /*
    |--------------------------------------------------------------------------
    | MANUAL
    |--------------------------------------------------------------------------
    */

    else if (mode === "manual") {

        manualButton.classList.add("active");

        manualControls.classList.remove(
            "manual-disabled"
        );

        statusMessage.innerText =
            "Mode MANUAL aktif. Pilih dispenser.";

    }

}


/*
|--------------------------------------------------------------------------
| SET MODE
|--------------------------------------------------------------------------
*/

window.setMode = async function(mode)
{

    /*
    |--------------------------------------------------------------------------
    | Jangan kirim request kalau mode sama
    |--------------------------------------------------------------------------
    */

    if (currentMode === mode) {
        return;
    }


    try {

        statusMessage.innerText =
            "Mengubah mode...";


        await set(
            ref(
                db,
                "hydroponic/control/mode"
            ),
            mode
        );


        updateModeUI(mode);


    }

    catch(error) {

        console.error(
            "Firebase mode error:",
            error
        );

        statusMessage.innerText =
            "Gagal mengubah mode.";

    }

};


/*
|--------------------------------------------------------------------------
| TRIGGER DISPENSER
|--------------------------------------------------------------------------
|
| Klik toggle:
|
| OFF → ON
| Firebase = true
|
| ESP32:
| ON selama 1.5 detik
| kemudian Firebase = false
|
| Firebase false akan membuat toggle kembali OFF.
|
|--------------------------------------------------------------------------
*/

window.triggerDispenser = async function(
    dispenser,
    toggle
){

    /*
    |--------------------------------------------------------------------------
    | Hanya boleh digunakan pada MANUAL
    |--------------------------------------------------------------------------
    */

    if (currentMode !== "manual") {

        toggle.checked = false;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Kalau sedang proses, jangan trigger lagi
    |--------------------------------------------------------------------------
    */

    if (dispenserBusy[dispenser]) {

        toggle.checked = false;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | User sedang mencoba ON
    |--------------------------------------------------------------------------
    */

    if (toggle.checked === true) {

        try {

            dispenserBusy[dispenser] = true;


            /*
            |--------------------------------------------------------------------------
            | Disable toggle selama proses
            |--------------------------------------------------------------------------
            */

            toggle.disabled = true;


            statusMessage.innerText =
                dispenser +
                " aktif. Menunggu ESP32...";


            /*
            |--------------------------------------------------------------------------
            | Kirim TRUE
            |--------------------------------------------------------------------------
            */

            await set(

                ref(
                    db,
                    "hydroponic/control/" +
                    dispenser
                ),

                true

            );


        }

        catch(error) {

            console.error(
                "Firebase dispenser error:",
                error
            );


            toggle.checked = false;

            toggle.disabled = false;

            dispenserBusy[dispenser] = false;


            statusMessage.innerText =
                "Gagal mengirim perintah.";

        }

    }

};


/*
|--------------------------------------------------------------------------
| RESET TOGGLES
|--------------------------------------------------------------------------
*/

function resetToggles()
{

    const toggles = [

        "phUpToggle",
        "phDownToggle",
        "mixAToggle",
        "mixBToggle"

    ];


    toggles.forEach(id => {

        const toggle =
            document.getElementById(id);

        if (toggle) {

            toggle.checked = false;

            toggle.disabled = false;

        }

    });


    dispenserBusy = {

        phUp: false,
        phDown: false,
        mixA: false,
        mixB: false

    };

}


/*
|--------------------------------------------------------------------------
| LISTEN MODE
|--------------------------------------------------------------------------
*/

onValue(

    ref(
        db,
        "hydroponic/control/mode"
    ),

    (snapshot) => {

        const mode =
            snapshot.val();


        if (!mode) {

            /*
            |--------------------------------------------------------------------------
            | Default
            |--------------------------------------------------------------------------
            */

            updateModeUI("auto");

            return;

        }


        updateModeUI(mode);

    }

);


/*
|--------------------------------------------------------------------------
| LISTEN DISPENSER STATUS
|--------------------------------------------------------------------------
|
| Firebase menjadi sumber kebenaran status dispenser.
|
| true  = ESP32 sedang menjalankan dispenser
| false = ESP32 sudah selesai
|
|--------------------------------------------------------------------------
*/

const dispensers = [
    "phUp",
    "phDown",
    "mixA",
    "mixB"
];



window.triggerDispenser = async function(dispenser, toggle)
{
   const firebasePaths = {
    phUp: "hydroponic/control/manualCommand/phUpPulse",
    phDown: "hydroponic/control/manualCommand/phDownPulse",
    mixA: "hydroponic/control/manualCommand/nutrisiAPulse",
    mixB: "hydroponic/control/manualCommand/nutrisiBPulse"
};

window.triggerDispenser = async function(dispenser, toggle) {

    if (currentMode !== "manual") {
        toggle.checked = false;
        return;
    }

    const firebasePath = firebasePaths[dispenser];

    if (!firebasePath) {
        toggle.checked = false;
        return;
    }

    // User menekan ON
    if (toggle.checked) {

        try {

            toggle.disabled = true;

            statusMessage.innerText =
                dispenser + " ON — menunggu ESP32...";

            // Kirim pulse
            await set(
                ref(db, firebasePath),
                true
            );

        } catch (error) {

            console.error(error);

            toggle.checked = false;
            toggle.disabled = false;

            statusMessage.innerText =
                "Gagal mengirim perintah.";

        }
        
    }
};
};


onValue(
    ref(db, "hydroponic/control/manualCommand"),
    (snapshot) => {

        const command = snapshot.val();

        if (!command) return;

        const states = {
            phUp: command.phUpPulse === true,
            phDown: command.phDownPulse === true,
            mixA: command.nutrisiAPulse === true,
            mixB: command.nutrisiBPulse === true
        };

        document.getElementById("phUpToggle").checked =
            states.phUp;

        document.getElementById("phDownToggle").checked =
            states.phDown;

        document.getElementById("mixAToggle").checked =
            states.mixA;

        document.getElementById("mixBToggle").checked =
            states.mixB;

    }
);


/*
|--------------------------------------------------------------------------
| TOGGLE ID
|--------------------------------------------------------------------------
*/

function getToggleId(dispenser)
{

    const ids = {

        phUp: "phUpToggle",

        phDown: "phDownToggle",

        mixA: "mixAToggle",

        mixB: "mixBToggle"

    };


    return ids[dispenser];

}


/*
|--------------------------------------------------------------------------
| FIREBASE CONNECTION
|--------------------------------------------------------------------------
*/

onValue(

    ref(
        db,
        ".info/connected"
    ),

    (snapshot) => {

        const connected =
            snapshot.val() === true;


        if (connected) {

            firebaseStatus.innerText =
                "Firebase Connected";

        }

        else {

            firebaseStatus.innerText =
                "Firebase Disconnected";

        }

    }

);

</script>


<script>

lucide.createIcons();

/* =========================================================
   MOBILE SIDEBAR TOGGLE
   (tambahan baru, konsisten dengan halaman lain, tidak
   mengubah logic Firebase/kontrol dispenser di atas)
========================================================= */

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


</body>

</html>