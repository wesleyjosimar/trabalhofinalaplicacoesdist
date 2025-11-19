@echo off
echo ========================================
echo  Instalacao CBF Antidoping - Laravel
echo ========================================
echo.

REM Verificar se PHP esta instalado
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERRO] PHP nao encontrado!
    echo.
    echo Por favor, instale o PHP 8.1 ou superior.
    echo Opcoes:
    echo 1. XAMPP: https://www.apachefriends.org/
    echo 2. PHP direto: https://windows.php.net/download/
    echo.
    echo Apos instalar, adicione o PHP ao PATH do Windows.
    echo.
    pause
    exit /b 1
)

REM Verificar se Composer esta instalado
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERRO] Composer nao encontrado!
    echo.
    echo Por favor, instale o Composer: https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)

echo [OK] PHP e Composer encontrados!
echo.

echo [1/5] Instalando dependencias do Composer...
call composer install
if %errorlevel% neq 0 (
    echo [ERRO] Falha ao instalar dependencias!
    pause
    exit /b 1
)
echo.

echo [2/5] Gerando chave da aplicacao...
php artisan key:generate
if %errorlevel% neq 0 (
    echo [AVISO] Nao foi possivel gerar a chave automaticamente.
    echo Configure manualmente no arquivo .env
)
echo.

echo [3/5] Configurando banco de dados...
echo.
echo IMPORTANTE: Configure o banco de dados no arquivo .env antes de continuar!
echo Edite o arquivo .env e configure:
echo   DB_DATABASE=cbf_antidoping
echo   DB_USERNAME=seu_usuario
echo   DB_PASSWORD=sua_senha
echo.
pause

echo [4/5] Criando tabelas no banco de dados...
php artisan migrate
if %errorlevel% neq 0 (
    echo [ERRO] Falha ao criar tabelas!
    echo Verifique se o banco de dados esta configurado corretamente.
    pause
    exit /b 1
)
echo.

echo [5/5] Criando usuarios padrao...
php artisan db:seed
if %errorlevel% neq 0 (
    echo [AVISO] Nao foi possivel criar usuarios padrao.
)
echo.

echo ========================================
echo  Instalacao concluida!
echo ========================================
echo.
echo Para iniciar o servidor, execute:
echo   php artisan serve
echo.
echo Acesse: http://localhost:8000
echo.
echo Login padrao:
echo   Email: admin@cbf.com.br
echo   Senha: admin123
echo.
pause

