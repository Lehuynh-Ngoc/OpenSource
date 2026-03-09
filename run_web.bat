@echo off
TITLE Running WebBanHang
CLS

REM Try to automatically find PHP in Laragon
SET "PHP_EXE="
FOR /D %%D IN ("C:\laragon\bin\php\php-*") DO (
    IF EXIST "%%D\php.exe" (
        SET "PHP_EXE=%%D\php.exe"
    )
)

REM Fallback to a common path if not found automatically
IF "%PHP_EXE%"=="" SET "PHP_EXE=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"

REM Verify it exists just in case
IF NOT EXIST "%PHP_EXE%" (
    ECHO PHP executable not found at:
    ECHO %PHP_EXE%
    ECHO.
    ECHO Please check your Laragon installation.
    PAUSE
    EXIT /B
)

ECHO Starting PHP Server for WebBanHang...
ECHO Using PHP from: %PHP_EXE%
ECHO Server running at http://localhost:8000/
ECHO Press Ctrl+C to stop the server.
ECHO.

REM Open browser to the root URL
TIMEOUT /T 2 >NUL
start http://localhost:8000/

"%PHP_EXE%" -S localhost:8000 router.php