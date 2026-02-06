@echo off
TITLE Running WebBanHang
CLS

REM Set path to specific PHP installation found
SET "PHP_EXE=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"

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
ECHO Server running at http://localhost:8000/Project1/product/index
ECHO Press Ctrl+C to stop the server.
ECHO.

REM Open browser to the products page with the Project1 prefix
TIMEOUT /T 2 >NUL
start http://localhost:8000/Project1/product/index

cd WebBanHang\Project1
"%PHP_EXE%" -S localhost:8000 router.php