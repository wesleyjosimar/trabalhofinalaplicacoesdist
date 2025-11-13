# Script PowerShell para parar o Docker Compose
# Execute este script a partir do diretório do projeto

Write-Host "=== Sistema CBF - Parando Docker Compose ===" -ForegroundColor Yellow

# Tentar usar docker compose (versão mais recente)
try {
    docker compose down
    Write-Host "`n=== Serviços parados com sucesso! ===" -ForegroundColor Green
} catch {
    # Se falhar, tentar com docker-compose (versão antiga)
    try {
        docker-compose down
        Write-Host "`n=== Serviços parados com sucesso! ===" -ForegroundColor Green
    } catch {
        Write-Host "ERRO: Não foi possível parar os serviços!" -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
        exit 1
    }
}

