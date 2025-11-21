@echo off
echo ========================================
echo Verificador de Porta MySQL (3306)
echo ========================================
echo.

echo Verificando se a porta 3306 esta em uso...
echo.

netstat -ano | findstr :3306

if %errorlevel% equ 0 (
    echo.
    echo [AVISO] Porta 3306 esta em uso!
    echo.
    echo Deseja finalizar o processo? (S/N)
    set /p resposta=
    
    if /i "%resposta%"=="S" (
        echo.
        echo Digite o PID do processo (numero da ultima coluna):
        set /p pid=
        taskkill /PID %pid% /F
        echo.
        echo Processo finalizado! Tente iniciar o MySQL novamente.
    ) else (
        echo.
        echo Nenhum processo foi finalizado.
    )
) else (
    echo.
    echo [OK] Porta 3306 esta livre!
    echo O problema pode ser outro. Verifique:
    echo - Permissoes da pasta data
    echo - Arquivos de lock
    echo - Logs do MySQL
)

echo.
echo Pressione qualquer tecla para sair...
pause > nul

