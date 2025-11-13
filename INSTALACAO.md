# Guia de Instalação - Sistema CBF

## Pré-requisitos

- Node.js 18+
- Docker e Docker Compose (opcional, para rodar tudo junto)
- PostgreSQL (se não usar Docker)

## Instalação Local

### 1. Backend

```bash
cd backend
npm install
```

Crie um arquivo `.env` na pasta `backend` com as seguintes variáveis:

```
DB_HOST=localhost
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=postgres
DB_NAME=cbf_db
JWT_SECRET=secret-key-change-in-production
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=development
FRONTEND_URL=http://localhost:3000
```

Execute o backend:

```bash
npm run start:dev
```

O backend estará disponível em `http://localhost:3001`

### 2. Frontend

```bash
cd frontend
npm install
```

Execute o frontend:

```bash
npm run dev
```

O frontend estará disponível em `http://localhost:3000`

## Instalação com Docker

Para rodar tudo junto (backend, frontend e PostgreSQL):

```bash
docker-compose up -d
```

Isso iniciará:
- PostgreSQL na porta 5432
- Backend na porta 3001
- Frontend na porta 3000

## Configuração do Banco de Dados

O TypeORM está configurado para criar as tabelas automaticamente em desenvolvimento (`synchronize: true`).

### Criar usuário inicial

Para criar um usuário inicial, você pode executar um script SQL ou usar a API:

```sql
-- Exemplo: criar usuário admin
INSERT INTO usuarios (id, email, senha, perfil, nome, ativo, "createdAt", "updatedAt")
VALUES (
  gen_random_uuid(),
  'admin@cbf.com.br',
  '$2b$10$rQ...', -- hash bcrypt de 'admin123'
  'CBF',
  'Administrador',
  true,
  NOW(),
  NOW()
);
```

Ou use o serviço de autenticação do backend para criar usuários programaticamente.

## Estrutura do Projeto

```
trabalhofinalaplicacoesdist/
├── backend/           # API NestJS
│   ├── src/
│   │   ├── auth/      # Autenticação JWT
│   │   ├── atletas/   # Módulo de atletas
│   │   ├── antidoping/# Módulo de testes antidoping
│   │   ├── relatorios/# Módulo de relatórios
│   │   ├── integracao/# Módulo de integrações
│   │   └── shared/    # Entidades compartilhadas
│   └── package.json
├── frontend/          # Interface React
│   ├── src/
│   │   ├── pages/     # Páginas da aplicação
│   │   ├── components/# Componentes reutilizáveis
│   │   ├── services/  # Serviços de API
│   │   └── contexts/  # Contextos React
│   └── package.json
└── docker-compose.yml # Configuração Docker
```

## Próximos Passos

1. **Criar dados iniciais**: Criar federações, clubes, laboratórios
2. **Configurar autenticação**: Criar usuários de teste
3. **Testar APIs**: Usar Postman ou similar para testar endpoints
4. **Implementar cache**: Adicionar Redis para cache de consultas
5. **Implementar filas**: Adicionar Bull para processamento assíncrono de relatórios

## Problemas Comuns

### Erro de conexão com banco de dados

Verifique se o PostgreSQL está rodando e se as credenciais no `.env` estão corretas.

### Erro de CORS

Verifique se a variável `FRONTEND_URL` no backend está configurada corretamente.

### Erro de autenticação

Certifique-se de que o token JWT está sendo enviado no header `Authorization: Bearer <token>`.


