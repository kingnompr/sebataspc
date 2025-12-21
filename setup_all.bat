@echo off
echo ============================================
echo SETUP SEBATAS PC DATABASE
echo ============================================
echo.

cd /d "C:\Users\Nomensen Pardosi\Documents\sebatas_pc"

echo [1/3] Running migrations...
php artisan migrate --force
if errorlevel 1 goto error

echo.
echo [2/3] Seeding database...
php artisan db:seed --force
if errorlevel 1 goto error

echo.
echo [3/3] Setting up admin user...
php setup_admin.php
if errorlevel 1 goto error

echo.
echo ============================================
echo SUCCESS! Database setup completed.
echo ============================================
echo.
echo Admin credentials:
echo Email: admin@sebataspc.com
echo Password: admin123
echo.
echo Now open: http://127.0.0.1:8000/admin
echo.
pause
goto end

:error
echo.
echo ============================================
echo ERROR! Setup failed.
echo ============================================
echo.
pause

:end
