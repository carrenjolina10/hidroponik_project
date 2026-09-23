@echo off
REM ============================================
REM  Hidroponik Bagus - stop all dev services
REM  Stops Laravel (8001), AI backend (8000), MySQL (3306)
REM ============================================

echo Stopping Laravel (port 8001)...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr /R /C:":8001 .*LISTENING"') do taskkill /F /PID %%a >nul 2>&1

echo Stopping AI backend (port 8000)...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr /R /C:":8000 .*LISTENING"') do taskkill /F /PID %%a >nul 2>&1

echo Stopping scheduler...
for /f "tokens=2" %%a in ('tasklist /FI "IMAGENAME eq php.exe" ^| findstr /R /C:"^ *[0-9]"') do (
    wmic process where "ProcessId=%%a and CommandLine like '%%schedule:work%%'" get ProcessId 2>nul | findstr /R /C:"[0-9]" >nul && taskkill /F /PID %%a >nul 2>&1
)

echo Stopping MySQL...
C:\xampp\mysql\bin\mysqladmin.exe -u root shutdown >nul 2>&1

echo.
echo ============================================
echo   All services stopped.
echo ============================================
