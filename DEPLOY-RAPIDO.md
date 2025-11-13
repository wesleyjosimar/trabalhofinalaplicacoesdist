# 🚀 Deploy Rápido - Guia Simplificado

## 🎯 Opção Mais Rápida: Railway ou Render

### Railway (Recomendado para começar)

#### 1. Criar Conta
1. Acesse: https://railway.app
2. Faça login com GitHub
3. Crie um novo projeto

#### 2. Deploy do Backend
1. Clique em "New" → "GitHub Repo"
2. Selecione seu repositório
3. Selecione o diretório `backend`
4. Railway detecta automaticamente e faz deploy
5. Adicione variáveis de ambiente:
   - `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`
   - `JWT_SECRET` (gere uma string aleatória segura)
   - `FRONTEND_URL` (URL do frontend)

#### 3. Deploy do Frontend
1. Clique em "New" → "GitHub Repo"
2. Selecione o diretório `frontend`
3. Adicione variáveis de ambiente:
   - `VITE_API_URL` (URL do backend no Railway)

#### 4. Adicionar Banco de Dados
1. Clique em "New" → "Database" → "PostgreSQL"
2. Railway cria automaticamente
3. Use as credenciais fornecidas no backend

#### 5. Executar Seed
1. Abra o terminal do serviço backend
2. Execute: `npm run seed:completo`
3. Pronto! ✅

### Render (Alternativa)

#### 1. Criar Conta
1. Acesse: https://render.com
2. Faça login com GitHub
3. Conecte seu repositório

#### 2. Deploy do Backend
1. Clique em "New" → "Web Service"
2. Conecte seu repositório
3. Configure:
   - **Name**: cbf-backend
   - **Root Directory**: backend
   - **Environment**: Node
   - **Build Command**: `npm install && npm run build`
   - **Start Command**: `npm run start:prod`
   - **Environment Variables**: Adicione todas as variáveis

#### 3. Deploy do Frontend
1. Clique em "New" → "Static Site"
2. Conecte seu repositório
3. Configure:
   - **Root Directory**: frontend
   - **Build Command**: `npm install && npm run build`
   - **Publish Directory**: dist

#### 4. Adicionar Banco de Dados
1. Clique em "New" → "PostgreSQL"
2. Render cria automaticamente
3. Use as credenciais fornecidas

## 🔧 Configuração Mínima Necessária

### Variáveis de Ambiente (Backend)

```env
DB_HOST=seu-postgres-host
DB_PORT=5432
DB_USER=seu-usuario
DB_PASSWORD=sua-senha
DB_NAME=cbf_db
JWT_SECRET=seu-jwt-secret-super-seguro-aqui
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

### Variáveis de Ambiente (Frontend)

```env
VITE_API_URL=https://seu-backend-url.com
```

## 📋 Checklist Rápido

- [ ] Conta criada no Railway/Render
- [ ] Repositório conectado
- [ ] Backend deployado
- [ ] Frontend deployado
- [ ] Banco de dados criado
- [ ] Variáveis de ambiente configuradas
- [ ] Seed executado
- [ ] Aplicação testada

## 🎉 Pronto!

Sua aplicação estará rodando na nuvem em poucos minutos!

---

**Dica**: Railway e Render oferecem planos gratuitos para começar, perfeitos para MVP e testes.

