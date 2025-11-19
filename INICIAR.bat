@echo off
echo ========================================
echo  Iniciando CBF Antidoping
echo ========================================
echo.

REM Verificar se PHP esta instalado
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERRO] PHP nao encontrado!
    echo Execute INSTALAR_PHP.md para instalar o PHP.
    pause
    exit /b 1
)

echo Iniciando servidor em http://localhost:8000
echo.
echo Pressione Ctrl+C para parar o servidor
echo.
php artisan serve

