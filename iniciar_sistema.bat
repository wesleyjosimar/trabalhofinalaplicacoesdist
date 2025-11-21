@echo off
echo ========================================
echo Iniciar Sistema CBF Antidoping
echo ========================================
echo.

echo Verificando XAMPP...
if not exist "C:\xampp\xampp-control.exe" (
    echo [ERRO] XAMPP nao encontrado em C:\xampp
    echo Por favor, instale o XAMPP ou ajuste o caminho.
    pause
    exit /b
)

echo.
echo Iniciando Apache e MySQL...
start "" "C:\xampp\xampp-control.exe"

echo.
echo Aguardando 5 segundos para os servicos iniciarem...
timeout /t 5 /nobreak > nul

echo.
echo Verificando se os arquivos estao no lugar...
if not exist "C:\xampp\htdocs\cbf\login.php" (
    echo [AVISO] Arquivos nao encontrados em C:\xampp\htdocs\cbf\
    echo Copiando arquivos...
    xcopy /E /I /Y "%~dp0*" "C:\xampp\htdocs\cbf\" /EXCLUDE:exclude.txt
    if errorlevel 1 (
        echo [ERRO] Falha ao copiar arquivos. Copie manualmente.
    ) else (
        echo [OK] Arquivos copiados!
    )
) else (
    echo [OK] Arquivos encontrados!
)

echo.
echo ========================================
echo Sistema pronto!
echo ========================================
echo.
echo Acesse: http://localhost/cbf/login.php
echo.
echo Credenciais:
echo - Admin: admin@cbf.com.br / admin123
echo - Operador: operador@cbf.com.br / operador123
echo.
echo Pressione qualquer tecla para abrir no navegador...
pause > nul

start http://localhost/cbf/login.php

