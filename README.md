# Sistema CBF - Gestão de Atletas e Antidoping

Sistema para gestão de atletas e controle de testes antidoping da CBF.

## 🚀 Tecnologias

- **Backend**: NestJS (TypeScript)
- **Frontend**: React + TypeScript + Vite
- **Banco de Dados**: PostgreSQL
- **Autenticação**: JWT

## 📦 Instalação Local

### Pré-requisitos
- Node.js 18+
- PostgreSQL
- npm ou yarn

### Backend

```bash
cd backend
npm install
cp env.example .env
# Configure as variáveis de ambiente no arquivo .env com as credenciais do PostgreSQL
npm run start:dev
```

**Variáveis de Ambiente (.env):**
```env
DB_HOST=dpg-d4b7d60dl3ps7397gdbg-a.oregon-postgres.render.com
DB_PORT=5432
DB_USER=cbf_postgres_user
DB_PASSWORD=aiLhGACmjSaagb3ndX7EZo0BnQL4h9pu
DB_NAME=cbf_postgres
JWT_SECRET=gerar-uma-chave-segura
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=development
FRONTEND_URL=http://localhost:3000
```

**💡 Dica**: Veja [backend/CONFIGURAR-ENV.md](./backend/CONFIGURAR-ENV.md) para instruções detalhadas.

### Frontend

```bash
cd frontend
npm install
npm run dev
```

## ☁️ Deploy no Render

Veja o guia completo em: [DEPLOY-RENDER.md](./DEPLOY-RENDER.md)

### Resumo Rápido

1. **PostgreSQL**: Criar banco no Render
2. **Backend**: Web Service com Root Directory `backend`
3. **Frontend**: Static Site com Root Directory `frontend`
4. **Variáveis**: Configurar `DB_*`, `JWT_SECRET`, `VITE_API_URL`
5. **Seed**: Executar `npm run seed:completo` no shell do backend

## 🔐 Credenciais Padrão

- **Email**: `admin@cbf.com.br`
- **Senha**: `admin123`

## 📚 Estrutura do Projeto

```
trabalhofinalaplicacoesdist/
├── backend/          # API NestJS
│   ├── src/
│   │   ├── auth/     # Autenticação
│   │   ├── atletas/  # Módulo de atletas
│   │   ├── antidoping/ # Módulo de testes
│   │   └── ...
│   └── package.json
├── frontend/         # Interface React
│   ├── src/
│   │   ├── pages/    # Páginas
│   │   ├── components/ # Componentes
│   │   └── services/ # API services
│   └── package.json
└── README.md
```

## 📝 Scripts Úteis

### Backend
- `npm run build` - Build para produção
- `npm run start:prod` - Iniciar em produção
- `npm run seed:completo` - Popular banco com dados iniciais

### Frontend
- `npm run build` - Build para produção
- `npm run dev` - Desenvolvimento

## 🆘 Problemas Comuns

### Build falha no Render
- Verifique se `@nestjs/cli` está em `dependencies` (não `devDependencies`)
- Verifique se todos os imports estão corretos

### Backend não conecta ao banco
- Verifique variáveis de ambiente `DB_*`
- Use Internal Database URL quando possível

### Frontend não carrega
- Verifique `VITE_API_URL` (deve ser URL completa do backend)
- Limpe cache do navegador (Ctrl+Shift+R)

## 📄 Licença

UNLICENSED
