@echo off
echo ========================================
echo  INSTALACAO CBF ANTIDOPING - XAMPP
echo ========================================
echo.

REM Verificar se XAMPP esta instalado
if not exist "C:\xampp\htdocs" (
    echo [ERRO] XAMPP nao encontrado em C:\xampp\htdocs
    echo.
    echo Por favor, instale o XAMPP em C:\xampp
    echo Download: https://www.apachefriends.org/
    echo.
    pause
    exit /b 1
)

echo [OK] XAMPP encontrado!
echo.

echo [1/4] Copiando arquivos para C:\xampp\htdocs\cbf...
if not exist "C:\xampp\htdocs\cbf" mkdir "C:\xampp\htdocs\cbf"
xcopy /E /I /Y *.* "C:\xampp\htdocs\cbf\" >nul 2>&1
echo [OK] Arquivos copiados!
echo.

echo [2/4] Configurando banco de dados...
echo.
echo IMPORTANTE:
echo 1. Abra o phpMyAdmin: http://localhost/phpmyadmin
echo 2. Crie o banco: cbf_antidoping
echo 3. Execute o arquivo database.sql
echo 4. Execute o arquivo inserir_usuarios.sql
echo.
pause

echo [3/4] Criando usuarios...
cd C:\xampp\htdocs\cbf
php criar_usuarios.php
if %errorlevel% neq 0 (
    echo [AVISO] Nao foi possivel criar usuarios automaticamente.
    echo Execute manualmente: php criar_usuarios.php
)
echo.

echo [4/4] Instalacao concluida!
echo.
echo ========================================
echo  ACESSE A APLICACAO:
echo  http://localhost/cbf/login.php
echo.
echo  LOGIN:
echo  Email: admin@cbf.com.br
echo  Senha: admin123
echo ========================================
echo.
pause

