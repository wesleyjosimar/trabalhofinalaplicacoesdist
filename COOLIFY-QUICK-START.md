# ⚡ Quick Start - Deploy no Coolify

## 🚀 Deploy em 5 Passos

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
6. **Deploy**

### 4. Deploy Backend

1. **New Resource** → **Dockerfile**
2. Name: `cbf-backend`
3. Repository: (seu repositório Git)
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

8. **Deploy**

### 5. Deploy Frontend

1. **New Resource** → **Dockerfile**
2. Name: `cbf-frontend`
3. Repository: (seu repositório Git)
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

8. **Deploy**

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

## 🔧 Configuração Rápida

### Gerar JWT_SECRET

```bash
openssl rand -base64 32
```

### Variáveis Importantes

- `DB_HOST`: Nome do serviço PostgreSQL (`cbf-postgres`)
- `VITE_API_URL`: URL do backend (ex: `https://api.seudominio.com`)
- `FRONTEND_URL`: URL do frontend (ex: `https://seudominio.com`)

## 🆘 Problemas?

Veja **COOLIFY-PASSO-A-PASSO.md** para guia completo e troubleshooting.


