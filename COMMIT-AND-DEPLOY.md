# 🚀 Guia Rápido: Commit e Deploy no Render

## 📦 Passo a Passo para Commit

### 1. Verificar Status do Git

```powershell
# Ver o que será commitado
git status
```

### 2. Adicionar Arquivos

```powershell
# Adicionar todos os arquivos (respeitando .gitignore)
git add .
```

### 3. Verificar o que será commitado

```powershell
# Ver novamente o status
git status
```

**IMPORTANTE:** Certifique-se de que NÃO há:
- Arquivos `.env`
- Pasta `node_modules/`
- Pasta `dist/` ou `build/`
- Arquivos de log

### 4. Fazer Commit

```powershell
git commit -m "feat: preparar projeto para deploy no Render"
```

### 5. Push para o Repositório

```powershell
# Se for a primeira vez, configure o remote
# git remote add origin https://github.com/seu-usuario/seu-repo.git

# Push para o repositório
git push origin main
# ou
git push origin master
```

## 🎯 Configuração no Render

### Backend (Web Service)

1. **New +** → **Web Service**
2. Conecte seu repositório GitHub
3. Configure:
   ```
   Name: cbf-backend
   Root Directory: backend
   Build Command: npm install && npm run build
   Start Command: npm run start:prod
   Instance Type: Free ou Starter
   ```
4. **Variáveis de Ambiente:**
   ```
   DB_HOST=[HOST DO POSTGRES]
   DB_PORT=5432
   DB_USER=[USUÁRIO]
   DB_PASSWORD=[SENHA]
   DB_NAME=[NOME DO BANCO]
   JWT_SECRET=[GERAR CHAVE SEGURA]
   JWT_EXPIRES_IN=24h
   PORT=3001
   NODE_ENV=production
   FRONTEND_URL=[URL DO FRONTEND - CONFIGURAR DEPOIS]
   ```

### Frontend (Static Site)

1. **New +** → **Static Site**
2. Conecte o mesmo repositório
3. Configure:
   ```
   Name: cbf-frontend
   Root Directory: frontend
   Build Command: npm install && npm run build
   Publish Directory: dist
   ```
4. **Variáveis de Ambiente:**
   ```
   VITE_API_URL=https://[URL-DO-BACKEND].onrender.com
   ```

### Atualizar Variáveis Após Deploy

1. Anote a URL do frontend após o deploy
2. No backend, atualize `FRONTEND_URL` com a URL do frontend
3. O Render fará redeploy automaticamente

## ✅ Verificar Deploy

1. **Backend:** `https://[URL-BACKEND]/health` → `{"status":"ok"}`
2. **Frontend:** `https://[URL-FRONTEND]`
3. **Login:** `admin@cbf.com.br` / `admin123`

## 🔐 Gerar JWT_SECRET

**Windows PowerShell:**
```powershell
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 }))
```

**Linux/Mac:**
```bash
openssl rand -base64 32
```

## ⚠️ Checklist Final

Antes de fazer commit, verifique:

- [ ] Nenhum `.env` está sendo commitado
- [ ] `node_modules/` está no `.gitignore`
- [ ] `dist/` está no `.gitignore`
- [ ] Backend compila: `cd backend; npm run build`
- [ ] Frontend compila: `cd frontend; npm run build`
- [ ] `@nestjs/cli` está em `dependencies` (não `devDependencies`)

## 🐛 Problemas Comuns

| Problema | Solução |
|----------|---------|
| `nest: not found` | Verificar se `@nestjs/cli` está em `dependencies` |
| Build falha | Verificar logs no Render Dashboard |
| CORS error | Verificar `FRONTEND_URL` no backend |
| Frontend não carrega | Verificar `VITE_API_URL` no frontend |

