# ⚡ Render - Resumo Rápido

## 🎯 Ordem de Deploy

1. **PostgreSQL** → 2. **Backend** → 3. **Frontend** → 4. **Atualizar Variáveis** → 5. **Seed**

---

## 📝 Configurações Essenciais

### PostgreSQL
```
Name: cbf-postgres
Database: cbf_db
Plan: Free (90 dias) ou Starter ($7/mês)
```

**Anotar**: Internal Database URL ou credenciais individuais

### Backend - Web Service
```
Name: cbf-backend
Root Directory: backend
Build Command: npm install && npm run build
Start Command: npm run start:prod
Instance Type: Free ou Starter ($7/mês)
```

**Variáveis de Ambiente:**
```env
DB_HOST=[HOST DO POSTGRES]
DB_PORT=5432
DB_USER=[USUÁRIO]
DB_PASSWORD=[SENHA]
DB_NAME=cbf_db
JWT_SECRET=[GERAR COM: openssl rand -base64 32]
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=[URL DO FRONTEND - CONFIGURAR DEPOIS]
```

**💡 Alternativa**: Use `DATABASE_URL` completa em vez de variáveis individuais

### Frontend - Static Site
```
Name: cbf-frontend
Root Directory: frontend
Build Command: npm install && npm run build
Publish Directory: dist
```

**Variáveis de Ambiente:**
```env
VITE_API_URL=https://[URL-DO-BACKEND]
```

---

## 🔐 Gerar JWT_SECRET

**Windows PowerShell:**
```powershell
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 }))
```

**Linux/Mac:**
```bash
openssl rand -base64 32
```

---

## 🧪 Testar Após Deploy

1. **Backend Health**: `https://[URL-BACKEND]/health` → `{"status":"ok"}`
2. **Frontend**: `https://[URL-FRONTEND]`
3. **Login**: 
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

---

## 🔄 Executar Seed

No Shell do Render (serviço `cbf-backend`):
```bash
npm run seed:completo
```

---

## ⚠️ Pontos Importantes

- ✅ **Root Directory** deve ser `backend` ou `frontend` (sem barra)
- ✅ Use **Internal Database URL** quando possível (mais seguro)
- ✅ `VITE_API_URL` deve ser a URL completa do backend (com https://)
- ✅ Após deploy do frontend, atualizar `FRONTEND_URL` no backend
- ✅ Seed deve ser executado após o deploy do backend
- ⚠️ **Plano Free**: Aplicação "dorme" após 15 min de inatividade

---

## 🐛 Problemas Comuns

| Problema | Solução |
|----------|---------|
| Backend não conecta ao banco | Usar Internal Database URL ou verificar credenciais |
| Frontend não carrega | Verificar `VITE_API_URL` e limpar cache do navegador |
| Build falha "nest: not found" | ✅ Corrigido: @nestjs/cli movido para dependencies |
| Build falha (outros) | Verificar Root Directory e comandos de build |
| Aplicação "dorme" | Normal no plano Free, primeira requisição pode demorar |
| Seed não executa | Verificar conectividade e credenciais do banco |

---

## 💰 Planos

### Free (Gratuito)
- Backend: 512 MB RAM, dorme após 15 min
- Frontend: Ilimitado
- PostgreSQL: 90 dias grátis

### Starter ($7/mês por serviço)
- Backend: 512 MB RAM, sempre ativo
- Frontend: Sempre ativo
- PostgreSQL: $7/mês

---

## 🔄 Deploy Automático

O Render faz deploy automático a cada push:

```bash
git push origin main
```

---

## 📚 Documentação Completa

Veja `GUIA-RENDER-PASSO-A-PASSO.md` para instruções detalhadas.

---

## 🔗 Links Úteis

- [Render Dashboard](https://dashboard.render.com)
- [Render Docs](https://render.com/docs)
- [Render Community](https://community.render.com)

