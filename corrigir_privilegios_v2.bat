@echo off
echo ========================================
echo Corrigir Tabelas de Privilegios MySQL v2
echo ========================================
echo.
echo Este script vai tentar uma abordagem diferente:
echo 1. Iniciar MySQL em modo de recuperacao
echo 2. Recriar as tabelas de privilegios
echo.
echo ATENCAO: Execute como Administrador!
echo.
pause

echo.
echo Parando MySQL...
net stop mysql 2>nul
taskkill /F /IM mysqld.exe 2>nul
timeout /t 3 /nobreak > nul

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
echo Tentando iniciar MySQL em modo skip-grant-tables...
echo Isso permite acesso sem verificar privilegios.
echo.
pause

echo.
echo Iniciando MySQL em modo de recuperacao...
cd /d "C:\xampp\mysql\bin"
start /B mysqld.exe --skip-grant-tables --skip-networking --datadir="C:\xampp\mysql\data"

echo.
echo Aguardando MySQL iniciar...
timeout /t 5 /nobreak > nul

echo.
echo Tentando conectar e recriar tabelas...
mysql.exe -u root mysql < "%~dp0recriar_tabelas_privilegios.sql"

if %errorlevel% equ 0 (
    echo.
    echo [OK] Tabelas recriadas com sucesso!
) else (
    echo.
    echo [AVISO] Nao foi possivel executar o SQL automaticamente.
    echo.
    echo Tente manualmente:
    echo 1. Abra outro terminal
    echo 2. Execute: cd C:\xampp\mysql\bin
    echo 3. Execute: mysql.exe -u root mysql
    echo 4. Execute o arquivo: recriar_tabelas_privilegios.sql
    echo 5. Digite: FLUSH PRIVILEGES;
    echo 6. Digite: exit
    echo.
    pause
)

echo.
echo Parando MySQL em modo de recuperacao...
taskkill /F /IM mysqld.exe 2>nul
timeout /t 2 /nobreak > nul

echo.
echo [OK] Processo concluido!
echo.
echo Agora tente iniciar o MySQL normalmente no XAMPP Control Panel.
echo.
pause

