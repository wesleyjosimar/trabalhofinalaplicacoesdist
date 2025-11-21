@echo off
echo ========================================
echo Corrigir Tabelas de Privilegios MySQL
echo ========================================
echo.
echo Este script vai corrigir o erro:
echo "Can't open and lock privilege tables: Incorrect file format 'db'"
echo.
echo ATENCAO: Execute como Administrador!
echo.
pause

echo.
echo Parando MySQL...
net stop mysql 2>nul
taskkill /F /IM mysqld.exe 2>nul
timeout /t 2 /nobreak > nul

echo.
echo Verificando se a pasta existe...
if not exist "C:\xampp\mysql\data\mysql" (
    echo [ERRO] Pasta C:\xampp\mysql\data\mysql nao encontrada!
    pause
    exit /b
)

echo.
echo Fazendo backup das tabelas de privilegios...
if not exist "C:\xampp\mysql\data\mysql_backup" (
    mkdir "C:\xampp\mysql\data\mysql_backup"
)

copy "C:\xampp\mysql\data\mysql\db.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul
copy "C:\xampp\mysql\data\mysql\user.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul
copy "C:\xampp\mysql\data\mysql\host.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul

echo.
echo Removendo arquivos corrompidos...
del /F /Q "C:\xampp\mysql\data\mysql\db.*" 2>nul
del /F /Q "C:\xampp\mysql\data\mysql\user.*" 2>nul
del /F /Q "C:\xampp\mysql\data\mysql\host.*" 2>nul

echo.
echo [OK] Arquivos removidos.
echo.
echo Agora vamos recriar as tabelas usando mysql_install_db...
echo.
echo IMPORTANTE: Se isso nao funcionar, voce precisara:
echo 1. Fazer backup dos seus bancos de dados
echo 2. Reinstalar o MySQL do XAMPP
echo.
pause

echo.
echo Tentando recriar tabelas de sistema...
cd /d "C:\xampp\mysql\bin"
mysql_install_db.exe --datadir="C:\xampp\mysql\data" --service=MySQL

echo.
echo [OK] Processo concluido!
echo.
echo Agora tente iniciar o MySQL no XAMPP Control Panel.
echo.
echo Se ainda nao funcionar, veja a Solucao 6 no SOLUCAO_MYSQL_XAMPP.md
echo.
pause

