@echo off
echo ========================================
echo Correcao Simples - XAMPP MySQL
echo ========================================
echo.
echo Este script vai:
echo 1. Parar o MySQL
echo 2. Remover arquivos corrompidos
echo 3. Preparar para recriacao manual
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
echo Fazendo backup...
if not exist "C:\xampp\mysql\data\mysql_backup" (
    mkdir "C:\xampp\mysql\data\mysql_backup"
)
copy "C:\xampp\mysql\data\mysql\db.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul
copy "C:\xampp\mysql\data\mysql\user.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul
copy "C:\xampp\mysql\data\mysql\host.*" "C:\xampp\mysql\data\mysql_backup\" 2>nul
echo [OK] Backup feito em: C:\xampp\mysql\data\mysql_backup\

echo.
echo Removendo arquivos corrompidos...
del /F /Q "C:\xampp\mysql\data\mysql\db.*" 2>nul
del /F /Q "C:\xampp\mysql\data\mysql\user.*" 2>nul
del /F /Q "C:\xampp\mysql\data\mysql\host.*" 2>nul
echo [OK] Arquivos removidos.

echo.
echo ========================================
echo PROXIMOS PASSOS MANUAIS:
echo ========================================
echo.
echo 1. Abra um Prompt de Comando
echo 2. Execute:
echo    cd C:\xampp\mysql\bin
echo    mysqld.exe --skip-grant-tables --skip-networking
echo.
echo 3. Abra OUTRO Prompt de Comando
echo 4. Execute:
echo    cd C:\xampp\mysql\bin
echo    mysql.exe -u root mysql
echo.
echo 5. Execute os comandos SQL do arquivo:
echo    recriar_tabelas_privilegios.sql
echo.
echo 6. Digite: FLUSH PRIVILEGES;
echo 7. Digite: exit;
echo 8. Pare o MySQL (Ctrl+C no primeiro terminal)
echo 9. Inicie normalmente no XAMPP
echo.
echo OU veja o arquivo: SOLUCAO_XAMPP_DIRETA.md
echo.
pause

