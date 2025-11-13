# 🚀 Solução Rápida - Corrigir Problemas

## Problema: Backend 404 e Frontend não responde

### Correções Aplicadas ✅

1. ✅ Backend agora escuta em `0.0.0.0:3001` (aceita conexões do Docker)
2. ✅ CORS configurado para permitir todas as origens
3. ✅ Rota raiz adicionada no backend (`/` e `/health`)
4. ✅ Frontend configurado para usar proxy corretamente
5. ✅ Vite configurado para escutar em `0.0.0.0`

## 🔧 Como Aplicar as Correções

### Opção 1: Script Automático (Recomendado)

```powershell
.\corrigir-e-reiniciar.ps1
```

### Opção 2: Manual

```powershell
# 1. Parar containers
docker compose down

# 2. Reconstruir imagens
docker compose build --no-cache

# 3. Iniciar serviços
docker compose up -d

# 4. Aguardar alguns segundos
Start-Sleep -Seconds 10

# 5. Verificar logs
docker compose logs -f
```

## ✅ Testar se Está Funcionando

### 1. Testar Backend

Abra o navegador e acesse:
- **http://localhost:3001** - Deve mostrar informações da API
- **http://localhost:3001/health** - Deve retornar `{"status":"ok"}`

### 2. Testar Frontend

Abra o navegador e acesse:
- **http://localhost:3000** - Deve carregar a aplicação React

### 3. Verificar Logs

```powershell
# Ver logs do backend
docker compose logs backend -f

# Ver logs do frontend
docker compose logs frontend -f
```

## 🐛 Se Ainda Não Funcionar

### Verificar Status dos Containers

```powershell
docker compose ps
```

Você deve ver 3 containers com status "Up":
- `cbf-postgres` (healthy)
- `cbf-backend` (running)
- `cbf-frontend` (running)

### Verificar se o Backend Está Respondendo

```powershell
# No PowerShell
curl http://localhost:3001/health

# Ou abra no navegador
# http://localhost:3001/health
```

### Verificar se o Frontend Está Rodando

```powershell
# Ver logs do frontend
docker compose logs frontend --tail 50
```

Você deve ver mensagens do Vite indicando que o servidor está rodando.

### Reiniciar um Serviço Específico

```powershell
# Reiniciar backend
docker compose restart backend

# Reiniciar frontend
docker compose restart frontend
```

## 📋 Checklist

- [ ] Executei `docker compose down`
- [ ] Executei `docker compose build --no-cache`
- [ ] Executei `docker compose up -d`
- [ ] Aguardei alguns segundos
- [ ] Testei http://localhost:3001/health (deve retornar `{"status":"ok"}`)
- [ ] Testei http://localhost:3000 (deve carregar a aplicação)
- [ ] Verifiquei os logs (`docker compose logs -f`)

## 🎯 Próximos Passos

1. ✅ Aplicar as correções
2. ✅ Testar o backend (http://localhost:3001/health)
3. ✅ Testar o frontend (http://localhost:3000)
4. ✅ Criar dados iniciais (seed)
5. ✅ Fazer login na aplicação

## 📞 Ainda com Problemas?

Se ainda não funcionar:

1. **Compartilhe os logs:**
   ```powershell
   docker compose logs > logs.txt
   ```

2. **Verifique a versão do Docker:**
   ```powershell
   docker --version
   docker compose version
   ```

3. **Verifique se o Docker Desktop está rodando**

4. **Tente executar manualmente (sem Docker):**
   - Backend: `cd backend && npm install && npm run start:dev`
   - Frontend: `cd frontend && npm install && npm run dev`

