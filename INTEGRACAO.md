# 🔗 Guia de Integração Frontend + Backend

Este guia explica como configurar e executar o frontend e backend juntos.

## 📋 Pré-requisitos

- Node.js 18+ instalado
- PostgreSQL configurado (local ou no Render)
- npm ou yarn instalado

## 🚀 Configuração Rápida

### 1. Backend

```bash
cd backend
npm install
cp env.example .env
```

Edite o arquivo `.env` com suas credenciais:

```env
DB_HOST=seu-host-postgres.com
DB_PORT=5432
DB_USER=seu_usuario
DB_PASSWORD=sua_senha
DB_NAME=nome_do_banco
JWT_SECRET=gerar-uma-chave-segura-aqui
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=development
FRONTEND_URL=http://localhost:3000
```

Inicie o backend:

```bash
npm run start:dev
```

O backend estará rodando em: `http://localhost:3001`

### 2. Frontend

```bash
cd frontend
npm install
```

Crie um arquivo `.env` (se necessário):

```env
VITE_API_URL=http://localhost:3001
```

**Nota:** Se não criar o `.env`, o frontend usará o proxy configurado no `vite.config.ts` que redireciona `/api` para `http://localhost:3001`.

Inicie o frontend:

```bash
npm run dev
```

O frontend estará rodando em: `http://localhost:3000`

## 🔧 Como Funciona a Integração

### Desenvolvimento Local

1. **Backend** roda em `http://localhost:3001`
2. **Frontend** roda em `http://localhost:3000`
3. O Vite proxy redireciona requisições `/api/*` para `http://localhost:3001/*`
4. CORS está configurado para permitir requisições do frontend

### Fluxo de Requisições

```
Frontend (localhost:3000)
    ↓
Requisição para /api/atletas
    ↓
Vite Proxy
    ↓
Backend (localhost:3001/atletas)
    ↓
Resposta JSON
    ↓
Frontend
```

### Autenticação

- O frontend armazena o token JWT no `localStorage`
- Todas as requisições incluem o header `Authorization: Bearer <token>`
- Se o token expirar (401), o usuário é redirecionado para `/login`

## 🐳 Docker (Opcional)

Se estiver usando Docker Compose:

```yaml
services:
  backend:
    build: ./backend
    ports:
      - "3001:3001"
    environment:
      - DB_HOST=postgres
      - FRONTEND_URL=http://localhost:3000
  
  frontend:
    build: ./frontend
    ports:
      - "3000:3000"
    environment:
      - VITE_API_URL=http://localhost:3001
```

## ✅ Verificar Integração

1. **Backend está rodando?**
   - Acesse: `http://localhost:3001/health` → Deve retornar `{"status":"ok","timestamp":"..."}`
   - Ou acesse: `http://localhost:3001/` → Deve retornar informações da API
   - Verifique os logs do terminal

2. **Frontend está conectado?**
   - Abra `http://localhost:3000`
   - Tente fazer login
   - Verifique o console do navegador (F12) para erros

3. **CORS funcionando?**
   - Se houver erros de CORS no console, verifique:
     - `FRONTEND_URL` no `.env` do backend
     - CORS está habilitado no `main.ts`

## 🐛 Problemas Comuns

### Erro: "Network Error" ou "CORS Error"

**Solução:**
- Verifique se o backend está rodando
- Confirme que `FRONTEND_URL` no backend está correto
- Limpe o cache do navegador

### Erro: "401 Unauthorized"

**Solução:**
- Faça login novamente
- Verifique se o token está sendo salvo no `localStorage`
- Confirme que o `JWT_SECRET` está configurado no backend

### Frontend não encontra a API

**Solução:**
- Verifique se `VITE_API_URL` está correto no `.env` do frontend
- Ou confirme que o proxy do Vite está funcionando
- Teste acessar `http://localhost:3001` diretamente

### Backend não conecta ao banco

**Solução:**
- Verifique as credenciais no `.env` do backend
- Teste a conexão com o PostgreSQL
- Confirme que o banco está acessível

## 📝 Scripts Úteis

### Rodar ambos simultaneamente (Windows PowerShell)

```powershell
# Terminal 1 - Backend
cd backend
npm run start:dev

# Terminal 2 - Frontend
cd frontend
npm run dev
```

### Rodar ambos simultaneamente (Linux/Mac)

```bash
# Terminal 1 - Backend
cd backend && npm run start:dev

# Terminal 2 - Frontend
cd frontend && npm run dev
```

## 🔐 Credenciais Padrão

- **Email:** `admin@cbf.com.br`
- **Senha:** `admin123`

## 📚 Próximos Passos

1. Execute o seed do banco: `cd backend && npm run seed:completo`
2. Faça login no frontend
3. Teste as funcionalidades:
   - Listar atletas
   - Criar teste antidoping
   - Visualizar cadeia de custódia
   - Gerar relatórios

