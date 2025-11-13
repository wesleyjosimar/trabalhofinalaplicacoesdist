# 🚀 Deploy no Coolify - Resumo Executivo

## 📋 O Que Você Precisa

✅ Conta no Coolify: https://coolify.brdrive.net  
✅ Código no Git (GitHub/GitLab)  
✅ Dockerfiles criados (`Dockerfile.prod`)

## 🎯 Passo a Passo Simplificado

### 1. Preparar Repositório

```bash
git add .
git commit -m "Preparar para deploy no Coolify"
git push origin main
```

### 2. Acessar Coolify

1. Acesse: **https://coolify.brdrive.net**
2. Faça login
3. Crie projeto: **CBF**

### 3. Deploy PostgreSQL

1. **New Resource** → **Database** → **PostgreSQL**
2. Name: `cbf-postgres`
3. Version: `15`
4. Database: `cbf_db`
5. Password: (gere senha segura)
6. **Deploy** ✅

### 4. Deploy Backend

1. **New Resource** → **Dockerfile**
2. Name: `cbf-backend`
3. Repository: (URL do seu repositório Git)
4. Branch: `main`
5. Dockerfile Path: `backend/Dockerfile.prod`
6. Build Context: `backend`
7. Port: `3001`

**Variáveis de Ambiente**:
```env
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=sua-senha-do-postgres
DB_NAME=cbf_db
JWT_SECRET=gerar-com-openssl-rand-base64-32
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

8. **Deploy** ✅

### 5. Deploy Frontend

1. **New Resource** → **Dockerfile**
2. Name: `cbf-frontend`
3. Repository: (mesmo repositório)
4. Branch: `main`
5. Dockerfile Path: `frontend/Dockerfile.prod`
6. Build Context: `frontend`
7. Port: `80`

**Build Arguments**:
```env
VITE_API_URL=https://api.seudominio.com
```

**Variáveis de Ambiente**:
```env
VITE_API_URL=https://api.seudominio.com
```

8. **Deploy** ✅

### 6. Executar Seed

1. No Coolify, vá para `cbf-backend`
2. Clique em **"Terminal"**
3. Execute: `npm run seed:completo`

### 7. Testar

1. Frontend: `https://seudominio.com`
2. Backend: `https://api.seudominio.com/health`
3. Login: `admin@cbf.com.br` / `admin123`

## ✅ Pronto!

Sua aplicação está rodando no Coolify!

## 🔧 Configuração Importante

### Gerar JWT_SECRET

```bash
openssl rand -base64 32
```

### Variáveis Críticas

- **DB_HOST**: `cbf-postgres` (nome exato do serviço PostgreSQL)
- **VITE_API_URL**: URL do backend (ex: `https://api.seudominio.com`)
- **FRONTEND_URL**: URL do frontend (ex: `https://seudominio.com`)

## 🆘 Problemas Comuns

### Backend não conecta ao banco

- Verifique se `DB_HOST=cbf-postgres` (nome exato)
- Verifique se estão no mesmo projeto
- Verifique credenciais

### Frontend não carrega

- Verifique `VITE_API_URL` (deve ser URL completa do backend)
- Verifique CORS no backend
- Verifique logs

## 📚 Guias Completos

- **COOLIFY-QUICK-START.md** - Guia rápido
- **COOLIFY-PASSO-A-PASSO.md** - Guia completo passo a passo
- **COOLIFY-GUIDE.md** - Guia detalhado
- **COOLIFY-CONFIG.md** - Configuração específica

## 🎉 Próximos Passos

1. ✅ Fazer deploy no Coolify
2. ✅ Configurar domínios (opcional)
3. ✅ Executar seed
4. ✅ Testar aplicação
5. ✅ Configurar CI/CD (opcional)

---

**Dica**: Siga a ordem: PostgreSQL → Backend → Frontend para evitar problemas de conectividade.


