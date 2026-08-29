<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hydroponic Control</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon"
        href="{{ asset('image/bagus.ico') }}">

    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>

        .control-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 24px;
        }

        .control-card {
            background: rgba(255,255,255,0.78);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }

        .control-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .control-header h2 {
            margin: 0;
            font-size: 20px;
            color: #1a202c;
        }

        .control-header p {
            margin-top: 5px;
            color: #718096;
            font-size: 13px;
        }

        /* ==============================
           MODE SELECTOR
        ============================== */

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
            background: #edf2f7;
            color: #4a5568;
            font-family: Inter, sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: all .2s ease;
        }

        .mode-button:hover {
            transform: translateY(-2px);
        }

        .mode-button.active {
            background: #48bb78;
            color: white;
            box-shadow: 0 5px 18px rgba(72,187,120,.3);
        }

        .mode-icon {
            display: block;
            margin-bottom: 7px;
        }

        /* ==============================
           DISPENSER
        ============================== */

        .dispenser-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .dispenser-card {
            background: #f7fafc;
            border-radius: 16px;
            padding: 22px;
            border: 1px solid #edf2f7;
            text-align: center;
            transition: all .2s ease;
        }

        .dispenser-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,.06);
        }

        .dispenser-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            background: #e6fffa;
            color: #319795;
        }

        .dispenser-card h3 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #1a202c;
        }

        .dispenser-card p {
            margin: 0 0 18px;
            font-size: 12px;
            color: #718096;
        }

        /* ==============================
           TOGGLE
        ============================== */

        .switch {
            position: relative;
            display: inline-block;
            width: 58px;
            height: 32px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

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

        input:checked + .slider {
            background: #48bb78;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .manual-disabled {
            opacity: .45;
            pointer-events: none;
        }

        /* ==============================
           STATUS
        ============================== */

        .system-status {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            border-radius: 12px;
            background: #f0fff4;
            color: #276749;
            font-size: 13px;
            font-weight: 600;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #48bb78;
        }

        .status-message {
            margin-top: 18px;
            min-height: 20px;
            font-size: 13px;
            color: #718096;
        }

        @media (max-width: 800px) {

            .dispenser-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .control-card {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {

            .dispenser-grid {
                grid-template-columns: 1fr;
            }

            .mode-container {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>


<body>

<div class="bg-decoration"></div>


<div class="container">

    <!-- SIDEBAR -->

    <aside class="sidebar">

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

```html
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


/*
|--------------------------------------------------------------------------
| UPDATE MODE UI
|--------------------------------------------------------------------------
*/

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
    // Hanya bisa digunakan dalam mode MANUAL
    if (currentMode !== "manual") {
        toggle.checked = false;
        return;
    }

    // Kalau user mencoba menyalakan
    if (toggle.checked === true) {

        try {

            // Disable sementara supaya tidak bisa diklik berkali-kali
            toggle.disabled = true;

            statusMessage.innerText =
                dispenser + " ON — dispensing...";

            /*
            |--------------------------------------------------------------------------
            | 1. Firebase ON
            |--------------------------------------------------------------------------
            */

            await set(
                ref(
                    db,
                    "hydroponic/control/" + dispenser
                ),
                true
            );


            /*
            |--------------------------------------------------------------------------
            | 2. Tunggu 1.5 detik
            |--------------------------------------------------------------------------
            */

            await new Promise(resolve => {
                setTimeout(resolve, 1500);
            });


            /*
            |--------------------------------------------------------------------------
            | 3. Firebase OFF
            |--------------------------------------------------------------------------
            */

            await set(
                ref(
                    db,
                    "hydroponic/control/" + dispenser
                ),
                false
            );


            /*
            |--------------------------------------------------------------------------
            | 4. Toggle OFF
            |--------------------------------------------------------------------------
            */

            toggle.checked = false;

            statusMessage.innerText =
                dispenser + " OFF";


        }
        catch(error) {

            console.error(
                "Dispenser error:",
                error
            );

            toggle.checked = false;

            statusMessage.innerText =
                "Gagal mengontrol " + dispenser;

        }
        finally {

            /*
            |--------------------------------------------------------------------------
            | Aktifkan kembali toggle
            |--------------------------------------------------------------------------
            */

            toggle.disabled = false;

        }

    }

    // Kalau toggle dicoba di-OFF secara manual,
    // kita paksa tetap OFF dan Firebase OFF.
    else {

        try {

            await set(
                ref(
                    db,
                    "hydroponic/control/" + dispenser
                ),
                false
            );

        }
        catch(error) {

            console.error(error);

        }

        toggle.checked = false;

    }
};




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

</script>


</body>

</html>

