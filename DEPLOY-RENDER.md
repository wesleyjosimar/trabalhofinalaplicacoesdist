# 🚀 Deploy no Render - Guia Simples

## 📋 Passo a Passo

### 1. PostgreSQL

1. No Render: **New +** → **PostgreSQL**
2. Configure:
   - Name: `cbf-postgres`
   - Database: `cbf_db`
   - Plan: Free (90 dias) ou Starter ($7/mês)
3. **Anote as credenciais** (aparecem na tela)

### 2. Backend

1. No Render: **New +** → **Web Service**
2. Conecte seu repositório GitHub
3. Configure:
   ```
   Name: cbf-backend
   Root Directory: backend
   Build Command: npm install && npm run build
   Start Command: npm run start:prod
   Instance Type: Free ou Starter ($7/mês)
   ```
4. **Variáveis de Ambiente**:
   ```env
   DB_HOST=[HOST DO POSTGRES]
   DB_PORT=5432
   DB_USER=[USUÁRIO]
   DB_PASSWORD=[SENHA]
   DB_NAME=cbf_db
   JWT_SECRET=[GERAR: openssl rand -base64 32]
   JWT_EXPIRES_IN=24h
   PORT=3001
   NODE_ENV=production
   FRONTEND_URL=[URL DO FRONTEND - CONFIGURAR DEPOIS]
   ```
5. Deploy automático após push

### 3. Frontend

1. No Render: **New +** → **Static Site**
2. Conecte o mesmo repositório
3. Configure:
   ```
   Name: cbf-frontend
   Root Directory: frontend
   Build Command: npm install && npm run build
   Publish Directory: dist
   ```
4. **Variáveis de Ambiente**:
   ```env
   VITE_API_URL=https://[URL-DO-BACKEND]
   ```
5. Deploy automático após push

### 4. Atualizar Variáveis

1. Após deploy do frontend, anote a URL
2. No backend, atualize `FRONTEND_URL` com a URL do frontend
3. Render fará redeploy automaticamente

### 5. Executar Seed

1. No Render, vá para o serviço `cbf-backend`
2. Aba **Shell**
3. Execute: `npm run seed:completo`

## ✅ Testar

- Backend: `https://[URL-BACKEND]/health` → `{"status":"ok"}`
- Frontend: `https://[URL-FRONTEND]`
- Login: `admin@cbf.com.br` / `admin123`

## 🔐 Gerar JWT_SECRET

**Windows PowerShell:**
```powershell
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 }))
```

**Linux/Mac:**
```bash
openssl rand -base64 32
```

## ⚠️ Importante

- ✅ `@nestjs/cli` deve estar em `dependencies` (não `devDependencies`)
- ✅ Root Directory: `backend` ou `frontend` (sem barra no final)
- ✅ `VITE_API_URL` deve ser URL completa (com `https://`)
- ⚠️ Plano Free: aplicação "dorme" após 15 min de inatividade

## 🐛 Problemas

| Erro | Solução |
|------|---------|
| `nest: not found` | Verificar se `@nestjs/cli` está em `dependencies` |
| Backend não conecta | Verificar credenciais do banco |
| Frontend não carrega | Verificar `VITE_API_URL` e limpar cache |

## 📚 Links

- [Render Dashboard](https://dashboard.render.com)
- [Render Docs](https://render.com/docs)

