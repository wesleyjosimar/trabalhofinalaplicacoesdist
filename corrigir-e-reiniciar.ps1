# Script para corrigir problemas e reiniciar os serviços

Write-Host "=== Corrigindo e Reiniciando Sistema CBF ===" -ForegroundColor Green

# Parar os containers
Write-Host "`n1. Parando containers..." -ForegroundColor Yellow
docker compose down

# Reconstruir as imagens
Write-Host "`n2. Reconstruindo imagens..." -ForegroundColor Yellow
docker compose build --no-cache

# Iniciar os serviços
Write-Host "`n3. Iniciando serviços..." -ForegroundColor Yellow
docker compose up -d

# Aguardar alguns segundos
Write-Host "`n4. Aguardando serviços iniciarem..." -ForegroundColor Yellow
Start-Sleep -Seconds 10

# Verificar status
Write-Host "`n5. Verificando status..." -ForegroundColor Yellow
docker compose ps

# Mostrar logs
Write-Host "`n6. Últimos logs do backend:" -ForegroundColor Cyan
docker compose logs backend --tail 20

Write-Host "`n7. Últimos logs do frontend:" -ForegroundColor Cyan
docker compose logs frontend --tail 20

Write-Host "`n=== Concluído! ===" -ForegroundColor Green
Write-Host "`nAcesse:" -ForegroundColor Cyan
Write-Host "  - Frontend: http://localhost:3000" -ForegroundColor White
Write-Host "  - Backend: http://localhost:3001" -ForegroundColor White
Write-Host "  - Backend Health: http://localhost:3001/health" -ForegroundColor White
Write-Host "`nPara ver os logs em tempo real:" -ForegroundColor Yellow
Write-Host "  docker compose logs -f" -ForegroundColor White

