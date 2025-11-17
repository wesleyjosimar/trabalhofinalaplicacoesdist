# Sistema CBF - Gestão de Atletas e Antidoping

Sistema completo para gestão de atletas e controle de testes antidoping da CBF.

## 🚀 Stack Tecnológica

- **Backend**: NestJS (TypeScript) - API REST
- **Frontend**: React + TypeScript + Vite - Interface Web
- **Banco de Dados**: PostgreSQL (Render)
- **Autenticação**: JWT

## 📦 Instalação Rápida

### 1. Backend

```bash
cd backend
npm install
cp env.example .env
# Edite o .env com as credenciais do PostgreSQL
npm run start:dev
```

Backend rodando em: `http://localhost:3001`

### 2. Frontend

```bash
cd frontend
npm install
npm run dev
```

Frontend rodando em: `http://localhost:3000`

## ⚙️ Configuração

### Backend (.env)

```env
DB_HOST=dpg-d4b7d60dl3ps7397gdbg-a.oregon-postgres.render.com
DB_PORT=5432
DB_USER=cbf_postgres_user
DB_PASSWORD=aiLhGACmjSaagb3ndX7EZo0BnQL4h9pu
DB_NAME=cbf_postgres
JWT_SECRET=[GERAR: openssl rand -base64 32]
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=development
FRONTEND_URL=http://localhost:3000
```

### Frontend

Configure `VITE_API_URL` no arquivo `.env` (criar se não existir):

```env
VITE_API_URL=http://localhost:3001
```

## 🗄️ Banco de Dados

**PostgreSQL no Render:**
- Host: `dpg-d4b7d60dl3ps7397gdbg-a.oregon-postgres.render.com`
- Database: `cbf_postgres`
- User: `cbf_postgres_user`

## 📝 Scripts

### Backend
```bash
npm run start:dev    # Desenvolvimento
npm run build        # Build produção
npm run start:prod   # Produção
npm run seed:completo # Popular banco
```

### Frontend
```bash
npm run dev          # Desenvolvimento
npm run build        # Build produção
```

## 🔐 Login Padrão

- **Email**: `admin@cbf.com.br`
- **Senha**: `admin123`

## 🔗 Integração Frontend + Backend

Veja o guia completo de integração: [INTEGRACAO.md](./INTEGRACAO.md)

## 🚀 Commit e Deploy

**Guia rápido para commit e deploy no Render:**
- [COMMIT-AND-DEPLOY.md](./COMMIT-AND-DEPLOY.md) - Passo a passo completo
- [PRE-COMMIT-CHECKLIST.md](./PRE-COMMIT-CHECKLIST.md) - Checklist antes de commitar

## ☁️ Deploy

Veja o guia completo: [DEPLOY-RENDER.md](./DEPLOY-RENDER.md)

## 📚 Estrutura

```
trabalhofinalaplicacoesdist/
├── backend/          # API NestJS
│   ├── src/
│   ├── package.json
│   └── env.example
├── frontend/         # React App
│   ├── src/
│   └── package.json
├── README.md
└── DEPLOY-RENDER.md
```

## 🆘 Problemas

- **Backend não conecta**: Verifique credenciais no `.env`
- **Frontend não carrega**: Verifique `VITE_API_URL`
- **Build falha**: Verifique se `@nestjs/cli` está em `dependencies`
