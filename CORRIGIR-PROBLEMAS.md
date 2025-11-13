# 🔧 Correção de Problemas - Sistema CBF

## Problema: Backend dando 404 e Frontend não responde

### Correções Aplicadas

1. **Backend agora escuta em `0.0.0.0`** (aceita conexões externas no Docker)
2. **CORS configurado para permitir todas as origens** (em desenvolvimento)
3. **Rota raiz adicionada no backend** (`/` e `/health`)
4. **Frontend configurado para usar proxy corretamente**
5. **Vite configurado para escutar em `0.0.0.0`**

### Como Aplicar as Correções

#### 1. Parar os containers

```powershell
docker compose down
```

#### 2. Reconstruir as imagens

```powershell
docker compose build
```

#### 3. Reiniciar os serviços

```powershell
docker compose up -d
```

#### 4. Verificar os logs

```powershell
# Backend
docker compose logs backend -f

# Frontend
docker compose logs frontend -f
```

### Testar se está funcionando

#### 1. Testar o Backend

Abra o navegador e acesse:
- **http://localhost:3001** - Deve retornar informações da API
- **http://localhost:3001/health** - Deve retornar `{"status":"ok"}`

#### 2. Testar o Frontend

Abra o navegador e acesse:
- **http://localhost:3000** - Deve carregar a aplicação React

#### 3. Testar o Login

1. Acesse http://localhost:3000
2. Faça login com:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

### Se ainda não funcionar

#### Verificar se os containers estão rodando

```powershell
docker compose ps
```

Você deve ver 3 containers com status "Up":
- `cbf-postgres`
- `cbf-backend`
- `cbf-frontend`

#### Verificar os logs de erro

```powershell
# Ver todos os logs
docker compose logs

# Ver logs do backend
docker compose logs backend

# Ver logs do frontend
docker compose logs frontend

# Ver logs do postgres
docker compose logs postgres
```

#### Verificar se as portas estão acessíveis

```powershell
# Testar backend
curl http://localhost:3001/health

# Ou abra no navegador
# http://localhost:3001/health
```

#### Reiniciar tudo do zero

```powershell
# Parar e remover tudo
docker compose down -v

# Reconstruir
docker compose build --no-cache

# Iniciar
docker compose up -d

# Aguardar alguns segundos e verificar logs
docker compose logs -f
```

### Problemas Comuns

#### Problema: Backend não conecta ao banco

**Solução:**
1. Verifique se o PostgreSQL está rodando:
   ```powershell
   docker compose ps postgres
   ```
2. Verifique os logs do PostgreSQL:
   ```powershell
   docker compose logs postgres
   ```
3. Verifique se as variáveis de ambiente estão corretas no `docker-compose.yml`

#### Problema: Frontend não consegue fazer requisições ao backend

**Solução:**
1. Verifique se o proxy está configurado corretamente no `vite.config.ts`
2. Verifique se o backend está acessível:
   ```powershell
   curl http://localhost:3001/health
   ```
3. Verifique o console do navegador (F12) para ver erros de CORS

#### Problema: Porta já em uso

**Solução:**
1. Verifique qual processo está usando a porta:
   ```powershell
   netstat -ano | findstr :3000
   netstat -ano | findstr :3001
   netstat -ano | findstr :5432
   ```
2. Pare o processo ou mude as portas no `docker-compose.yml`

### Comandos Úteis

```powershell
# Ver status dos containers
docker compose ps

# Ver logs em tempo real
docker compose logs -f

# Reiniciar um serviço específico
docker compose restart backend
docker compose restart frontend

# Parar todos os serviços
docker compose down

# Parar e remover volumes (limpar dados)
docker compose down -v

# Reconstruir uma imagem específica
docker compose build backend
docker compose build frontend

# Executar comandos dentro do container
docker compose exec backend sh
docker compose exec frontend sh
```

### Próximos Passos

1. ✅ Aplicar as correções (parar, reconstruir, reiniciar)
2. ✅ Testar o backend (http://localhost:3001/health)
3. ✅ Testar o frontend (http://localhost:3000)
4. ✅ Criar dados iniciais (seed)
5. ✅ Fazer login na aplicação

### Ainda com Problemas?

Se ainda não funcionar após seguir todos os passos:

1. **Verifique os logs completos:**
   ```powershell
   docker compose logs > logs.txt
   ```
   E compartilhe o conteúdo do arquivo `logs.txt`

2. **Verifique a versão do Docker:**
   ```powershell
   docker --version
   docker compose version
   ```

3. **Verifique se o Docker Desktop está rodando**

4. **Tente executar manualmente (sem Docker):**
   - Backend: `cd backend && npm install && npm run start:dev`
   - Frontend: `cd frontend && npm install && npm run dev`

