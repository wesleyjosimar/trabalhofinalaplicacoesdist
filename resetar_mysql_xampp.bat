@echo off
echo ========================================
echo Resetar MySQL XAMPP - Reconstruir Tudo
echo ========================================
echo.
echo Este script vai:
echo 1. Parar o MySQL
echo 2. Fazer backup da pasta mysql
echo 3. Apagar a pasta mysql (tabelas de privilegios)
echo 4. O MySQL vai recriar automaticamente ao iniciar
echo.
echo ATENCAO: Isso vai recriar as tabelas de privilegios,
echo mas seus bancos de dados serao preservados!
echo.
echo Deseja continuar? (S/N)
set /p resposta=
if /i not "%resposta%"=="S" (
    echo Operacao cancelada.
    pause
    exit /b
)

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
echo Fazendo backup da pasta mysql completa...
if exist "C:\xampp\mysql\data\mysql_backup_completo" (
    echo Removendo backup antigo...
    rmdir /S /Q "C:\xampp\mysql\data\mysql_backup_completo"
)
xcopy /E /I /Y "C:\xampp\mysql\data\mysql" "C:\xampp\mysql\data\mysql_backup_completo\"
echo [OK] Backup completo feito em: C:\xampp\mysql\data\mysql_backup_completo\

echo.
echo Removendo pasta mysql (sera recriada automaticamente)...
rmdir /S /Q "C:\xampp\mysql\data\mysql"
echo [OK] Pasta mysql removida.

echo.
echo ========================================
echo PRONTO!
echo ========================================
echo.
echo Agora:
echo 1. Inicie o MySQL no XAMPP Control Panel
echo 2. O MySQL vai recriar a pasta mysql automaticamente
echo 3. As tabelas de privilegios serao criadas do zero
echo.
echo IMPORTANTE: Apos iniciar, voce precisara:
echo - Recriar o usuario root (se necessario)
echo - Ou usar: mysql.exe -u root (sem senha)
echo.
echo Seus bancos de dados (cbf_antidoping, etc) estao seguros!
echo.
pause

