# Sistema CBF - Gestão de Atletas e Antidoping

## Arquitetura da Aplicação

### Decisão Arquitetural: Monólito Modular (Modular Monolith)

**Justificativa:**
- Permite separação clara de responsabilidades por contexto de domínio (Atletas, Antidoping, Relatórios, Integrações)
- Facilita evolução futura para microserviços se necessário
- Simplifica deployment e operação inicial
- Mantém consistência transacional quando necessário
- Preparado para escalabilidade horizontal (stateless, cache distribuído)

### Módulos Principais

1. **Auth Module**: Autenticação e autorização (JWT)
2. **Atletas Module**: CRUD de atletas, histórico de clubes
3. **Antidoping Module**: Registro de testes, amostras, resultados, cadeia de custódia
4. **Relatórios Module**: Geração de relatórios assíncronos
5. **Integrações Module**: APIs para laboratórios e órgãos reguladores
6. **Shared Module**: Entidades, DTOs, utilitários compartilhados

### Estratégia de Escalabilidade

- **Stateless**: Aplicação sem estado (tokens JWT, sessões no banco/cache)
- **Cache**: Redis para consultas frequentes (lista de atletas, clubes, federações)
- **Filas**: Processamento assíncrono de relatórios e integrações
- **Banco de Dados**: PostgreSQL com índices otimizados, read replicas quando necessário
- **Containerização**: Docker para facilitar deploy em múltiplas instâncias

### Stack Tecnológica

- **Backend**: NestJS (TypeScript) - Framework modular, suporte a DI, fácil de testar
- **Frontend**: React + TypeScript + Vite - Interface moderna e responsiva
- **Banco de Dados**: PostgreSQL - Relacional, ACID, suporte a JSON
- **Cache**: Redis - Cache distribuído
- **Filas**: Bull (Redis-based) - Processamento assíncrono
- **Autenticação**: JWT - Stateless, escalável
- **Containerização**: Docker + Docker Compose

## Modelo de Domínio

### Entidades Principais

- **Atleta**: Nome, documento, data nascimento, clube atual, federação
- **Clube**: Nome, federação, histórico de atletas
- **Federação**: Nome, sigla, nível (estadual, nacional)
- **Competição**: Nome, data, tipo, federação
- **TesteAntidoping**: Atleta, competição, data coleta, coletor, local
- **Amostra**: Teste, tipo (A/B), código, status (pendente, analisada, positiva, negativa)
- **Resultado**: Amostra, laboratório, resultado (negativo, positivo, inconclusivo), data
- **Laboratório**: Nome, código, ativo
- **Usuário**: Email, senha, perfil (CBF, Federação, Clube, Laboratório, Regulador)
- **Auditoria**: Tabela de log de eventos críticos

### Relacionamentos

- Atleta -> Clube (N:1)
- Atleta -> Federação (N:1)
- TesteAntidoping -> Atleta (N:1)
- TesteAntidoping -> Competição (N:1)
- Amostra -> TesteAntidoping (N:1)
- Resultado -> Amostra (1:1)
- Resultado -> Laboratório (N:1)

## APIs Principais

### Autenticação
- `POST /auth/login` - Login e obtenção de JWT
- `POST /auth/refresh` - Refresh token

### Atletas
- `GET /atletas` - Listar atletas (paginado, filtros)
- `GET /atletas/:id` - Detalhes do atleta
- `POST /atletas` - Criar atleta (CBF, Federação)
- `PUT /atletas/:id` - Atualizar atleta
- `DELETE /atletas/:id` - Remover atleta
- `GET /atletas/:id/historico` - Histórico de clubes/competições

### Antidoping
- `GET /antidoping/testes` - Listar testes (filtros: atleta, competição, período)
- `GET /antidoping/testes/:id` - Detalhes do teste
- `POST /antidoping/testes` - Registrar teste (CBF, Federação)
- `POST /antidoping/testes/:id/amostras` - Registrar amostras
- `POST /antidoping/amostras/:id/resultado` - Registrar resultado (Laboratório)
- `GET /antidoping/amostras/:id/custodia` - Cadeia de custódia
- `POST /antidoping/testes/:id/reanalise` - Solicitar reanálise (amostra B)

### Relatórios
- `POST /relatorios/gerar` - Gerar relatório (assíncrono)
- `GET /relatorios/:id` - Status do relatório
- `GET /relatorios/:id/download` - Download do relatório

### Integrações
- `POST /integracao/laboratorio/resultado` - Webhook para laboratório enviar resultado
- `GET /integracao/regulador/testes` - Consulta de testes (Órgão Regulador)

## Estrutura do Projeto

```
trabalhofinalaplicacoesdist/
├── backend/
│   ├── src/
│   │   ├── auth/
│   │   ├── atletas/
│   │   ├── antidoping/
│   │   ├── relatorios/
│   │   ├── integracao/
│   │   └── shared/
│   ├── test/
│   └── docker/
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── services/
│   │   └── hooks/
│   └── public/
├── docker-compose.yml
└── README.md
```

## Como Executar

### Pré-requisitos
- Node.js 18+
- Docker e Docker Compose (opcional)
- PostgreSQL (ou via Docker)

### Opção 1: Docker Compose (Recomendado)

**Windows (PowerShell):**

```powershell
# Navegar para o diretório do projeto
cd C:\trabalhofinalaplicacoesdist

# Opção A: Usar script PowerShell (mais fácil)
.\start-docker.ps1

# Opção B: Executar manualmente
docker compose up -d
# ou (versões antigas do Docker)
docker-compose up -d
```

**Linux/Mac:**

```bash
# Navegar para o diretório do projeto
cd /caminho/para/trabalhofinalaplicacoesdist

# Iniciar todos os serviços
docker-compose up -d
# ou
docker compose up -d
```

**Comandos úteis:**

```bash
# Ver logs
docker compose logs -f

# Ver logs de um serviço específico
docker compose logs -f backend
docker compose logs -f frontend

# Parar serviços
docker compose down

# Parar e remover volumes (limpar dados)
docker compose down -v
```

Isso iniciará:
- PostgreSQL na porta 5432
- Backend na porta 3001
- Frontend na porta 3000

**⚠️ IMPORTANTE:** Certifique-se de estar no diretório correto (`C:\trabalhofinalaplicacoesdist`) onde o arquivo `docker-compose.yml` está localizado!

### Opção 2: Instalação Local

#### Backend
```bash
cd backend
npm install

# Criar arquivo .env
cp .env.example .env
# Editar .env com suas configurações

# Iniciar backend
npm run start:dev
```

#### Frontend
```bash
cd frontend
npm install

# Iniciar frontend
npm run dev
```

### Criar Dados Iniciais

Após iniciar o backend, execute o script de seed:

```bash
# No diretório backend
npm run seed
```

Ou execute o SQL manualmente (veja `backend/src/database/seed.sql`).

### Usuários de Teste

Após executar o seed:
- **Email**: admin@cbf.com.br
- **Senha**: admin123
- **Perfil**: CBF

- **Email**: lab@teste.com.br
- **Senha**: lab123
- **Perfil**: LABORATORIO

## Segurança

- Autenticação JWT
- Autorização por perfil (RBAC)
- HTTPS obrigatório em produção
- Validação de inputs
- Auditoria de eventos críticos

## Deploy na Nuvem

Para fazer deploy da aplicação na nuvem, veja:

- **COOLIFY-DEPLOY-RAPIDO.md** - Guia rápido para Coolify (recomendado)
- **COOLIFY-GUIDE.md** - Guia completo para Coolify
- **DEPLOY-RESUMO.md** - Resumo rápido de opções
- **DEPLOY-RAPIDO.md** - Guia rápido para Railway/Render
- **DEPLOY-NUVEM.md** - Guia completo para AWS/Azure/GCP

### Deploy no Coolify (Recomendado)

1. Acesse: https://coolify.brdrive.net
2. Crie um projeto
3. Deploy PostgreSQL
4. Deploy Backend (usando `backend/Dockerfile.prod`)
5. Deploy Frontend (usando `frontend/Dockerfile.prod`)
6. Configure variáveis de ambiente
7. Execute seed: `npm run seed:completo`

**Pronto!** ✅ Aplicação rodando no Coolify!

### Outras Opções

1. **Railway** ou **Render** - Deploy em 10-15 minutos
2. **AWS/Azure/GCP** - Para produção em escala
3. Veja guias específicos para cada opção

## Próximos Passos (Evolução)

1. Implementar cache Redis
2. Implementar filas para relatórios
3. Adicionar testes automatizados
4. Implementar rate limiting
5. Adicionar métricas e monitoramento
6. Implementar CI/CD
7. Configurar monitoramento e alertas
8. Configurar backups automáticos

"# trabalhofinalaplicacoesdist" 
