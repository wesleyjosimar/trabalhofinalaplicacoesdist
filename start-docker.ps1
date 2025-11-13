# Script PowerShell para iniciar o Docker Compose
# Execute este script a partir do diretório do projeto

Write-Host "=== Sistema CBF - Iniciando Docker Compose ===" -ForegroundColor Green

# Verificar se estamos no diretório correto
if (-Not (Test-Path "docker-compose.yml")) {
    Write-Host "ERRO: Arquivo docker-compose.yml não encontrado!" -ForegroundColor Red
    Write-Host "Certifique-se de estar no diretório do projeto: C:\trabalhofinalaplicacoesdist" -ForegroundColor Yellow
    exit 1
}

Write-Host "Arquivo docker-compose.yml encontrado!" -ForegroundColor Green

# Verificar se o Docker está rodando
try {
    docker version | Out-Null
    Write-Host "Docker está rodando!" -ForegroundColor Green
} catch {
    Write-Host "ERRO: Docker não está rodando!" -ForegroundColor Red
    Write-Host "Por favor, inicie o Docker Desktop e tente novamente." -ForegroundColor Yellow
    exit 1
}

# Tentar usar docker compose (versão mais recente)
Write-Host "`nIniciando serviços com Docker Compose..." -ForegroundColor Cyan
try {
    docker compose up -d
    Write-Host "`n=== Serviços iniciados com sucesso! ===" -ForegroundColor Green
    Write-Host "Frontend: http://localhost:3000" -ForegroundColor Cyan
    Write-Host "Backend: http://localhost:3001" -ForegroundColor Cyan
    Write-Host "PostgreSQL: localhost:5432" -ForegroundColor Cyan
    Write-Host "`nPara ver os logs, execute: docker compose logs -f" -ForegroundColor Yellow
} catch {
    # Se falhar, tentar com docker-compose (versão antiga)
    Write-Host "Tentando com docker-compose..." -ForegroundColor Yellow
    try {
        docker-compose up -d
        Write-Host "`n=== Serviços iniciados com sucesso! ===" -ForegroundColor Green
        Write-Host "Frontend: http://localhost:3000" -ForegroundColor Cyan
        Write-Host "Backend: http://localhost:3001" -ForegroundColor Cyan
        Write-Host "PostgreSQL: localhost:5432" -ForegroundColor Cyan
        Write-Host "`nPara ver os logs, execute: docker-compose logs -f" -ForegroundColor Yellow
    } catch {
        Write-Host "ERRO: Não foi possível iniciar os serviços!" -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
        exit 1
    }
}

