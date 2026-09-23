@echo off
REM ============================================
REM  Hidroponik Bagus - local dev starter
REM  Starts MySQL, AI backend, and Laravel app
REM ============================================

REM 1. MySQL - XAMPP's MariaDB (skipped if already running)
tasklist /FI "IMAGENAME eq mysqld.exe" 2>nul | find /I "mysqld.exe" >nul
if errorlevel 1 (
    echo Starting XAMPP MySQL...
    start "MySQL" /MIN "C:\xampp\mysql\bin\mysqld.exe" --defaults-file=C:\xampp\mysql\bin\my.ini
    timeout /t 8 /nobreak >nul
) else (
    echo MySQL already running.
)

REM 2. AI backend (FastAPI + YOLOv8 on port 8000)
start "AI Backend" /MIN cmd /c "cd /d %~dp0backend_ai && venv\Scripts\python.exe -m uvicorn main:app --host 127.0.0.1 --port 8000"
echo AI backend starting on http://127.0.0.1:8000 (takes ~20s to load models)

REM 3. Laravel web app (port 8001)
start "Laravel" /MIN cmd /c "cd /d %~dp0hidroponik_project-main && C:\php83\php.exe artisan serve --host=127.0.0.1 --port=8001"
echo Laravel app starting on http://127.0.0.1:8001

REM 4. Laravel scheduler - records sensor data from Firebase every 1 minute
REM    (change the interval in hidroponik_project-main/app/Console/Kernel.php)
start "Scheduler" /MIN cmd /c "cd /d %~dp0hidroponik_project-main && C:\php83\php.exe artisan schedule:work"
echo Scheduler starting (sensor:record every 1 minute)

echo.
echo ============================================
echo   Web app : http://127.0.0.1:8001
echo   AI API  : http://127.0.0.1:8000
echo   MySQL   : 127.0.0.1:3306 (XAMPP MariaDB)
echo             db: hidroponik  user: hidroponik
echo   phpMyAdmin: http://localhost/phpmyadmin (needs Apache running in XAMPP)
echo ============================================
