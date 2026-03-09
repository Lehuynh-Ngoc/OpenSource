@echo off
TITLE Setup Database - HUTECH Shop
CLS

REM Tim duong dan PHP trong Laragon
SET "PHP_EXE="
FOR /D %%D IN ("C:\laragon\bin\php\php-*") DO (
    IF EXIST "%%D\php.exe" (
        SET "PHP_EXE=%%D\php.exe"
    )
)

REM Fallback neu khong tim thay tu dong
IF "%PHP_EXE%"=="" SET "PHP_EXE=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"

REM Kiem tra file PHP co ton tai khong
IF NOT EXIST "%PHP_EXE%" (
    ECHO [LOI] Khong tim thay PHP tai: %PHP_EXE%
    ECHO Vui long kiem tra lai duong dan Laragon cua ban.
    PAUSE
    EXIT /B
)

ECHO --------------------------------------------------
ECHO    DANG KHOI TAO CO SO DU LIEU VÀ ADMIN...
ECHO --------------------------------------------------
ECHO.

REM Chay file create_admin.php thong qua PHP CLI
"%PHP_EXE%" create_admin.php > nul

ECHO [OK] Da khoi tao cac bang: users, products, categories, cart.
ECHO [OK] Da tao tai khoan Admin duy nhat:
ECHO      - Username: admin
ECHO      - Password: admin123
ECHO.
ECHO --------------------------------------------------
ECHO CAI DAT HOAN TAT! Bay gio ban co the chay run_web.bat
ECHO --------------------------------------------------
ECHO.
PAUSE
