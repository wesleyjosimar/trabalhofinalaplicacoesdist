@echo off
echo ========================================
echo Corrigir Permissoes MySQL XAMPP
echo ========================================
echo.
echo Este script vai corrigir as permissoes da pasta data do MySQL.
echo.
echo ATENCAO: Execute como Administrador!
echo.
pause

echo.
echo Parando MySQL (se estiver rodando)...
net stop mysql 2>nul

echo.
echo Verificando se a pasta existe...
if not exist "C:\xampp\mysql\data" (
    echo [ERRO] Pasta C:\xampp\mysql\data nao encontrada!
    echo Verifique se o XAMPP esta instalado em C:\xampp
    pause
    exit /b
)

echo.
echo Aplicando permissoes...
icacls "C:\xampp\mysql\data" /grant Administradores:F /T
icacls "C:\xampp\mysql\data" /grant "%USERNAME%":F /T
icacls "C:\xampp\mysql\data" /grant Sistema:F /T

echo.
echo [OK] Permissoes aplicadas!
echo.
echo Agora tente iniciar o MySQL no XAMPP Control Panel.
echo.
pause

