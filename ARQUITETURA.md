# Arquitetura da Aplicação CBF

## Visão Geral

A aplicação foi projetada como um **monólito modular** (Modular Monolith) com separação clara de responsabilidades por contexto de domínio. Esta escolha arquitetural permite:

- **Evolução gradual**: Facilita a migração futura para microserviços se necessário
- **Simplicidade operacional**: Um único deploy e banco de dados facilitam a operação inicial
- **Consistência transacional**: Operações que precisam de transações ACID são mais simples
- **Escalabilidade horizontal**: A aplicação é stateless e pode ser escalada horizontalmente

## Estrutura de Módulos

### 1. Módulo de Autenticação (`auth`)
- **Responsabilidade**: Autenticação e autorização de usuários
- **Tecnologias**: JWT, Passport.js
- **Endpoints**:
  - `POST /auth/login` - Login e obtenção de token JWT
  - `POST /auth/refresh` - Refresh token (futuro)

### 2. Módulo de Atletas (`atletas`)
- **Responsabilidade**: CRUD de atletas e histórico de clubes
- **Entidades**: Atleta, Clube, Federação, HistoricoClube
- **Endpoints**:
  - `GET /atletas` - Listar atletas (paginado, filtros)
  - `GET /atletas/:id` - Detalhes do atleta
  - `POST /atletas` - Criar atleta
  - `PATCH /atletas/:id` - Atualizar atleta
  - `DELETE /atletas/:id` - Remover atleta
  - `GET /atletas/:id/historico` - Histórico de clubes

### 3. Módulo de Antidoping (`antidoping`)
- **Responsabilidade**: Registro de testes, amostras e resultados
- **Entidades**: TesteAntidoping, Amostra, Resultado
- **Endpoints**:
  - `GET /antidoping/testes` - Listar testes
  - `GET /antidoping/testes/:id` - Detalhes do teste
  - `POST /antidoping/testes` - Registrar teste
  - `POST /antidoping/testes/:id/amostras` - Registrar amostras
  - `POST /antidoping/amostras/:id/resultado` - Registrar resultado
  - `GET /antidoping/amostras/:id/custodia` - Cadeia de custódia
  - `POST /antidoping/testes/:id/reanalise` - Solicitar reanálise

### 4. Módulo de Relatórios (`relatorios`)
- **Responsabilidade**: Geração assíncrona de relatórios
- **Endpoints**:
  - `POST /relatorios/gerar` - Gerar relatório (assíncrono)
  - `GET /relatorios/:id` - Status do relatório
  - `GET /relatorios/:id/download` - Download do relatório

### 5. Módulo de Integração (`integracao`)
- **Responsabilidade**: APIs para laboratórios e órgãos reguladores
- **Endpoints**:
  - `POST /integracao/laboratorio/resultado` - Webhook para laboratório
  - `GET /integracao/regulador/testes` - Consulta de testes

### 6. Módulo Compartilhado (`shared`)
- **Responsabilidade**: Entidades, DTOs e utilitários compartilhados
- **Entidades**: Usuario, Federacao, Clube, Atleta, Competicao, Laboratorio, Auditoria

## Modelo de Dados

### Principais Entidades

1. **Usuario**: Usuários do sistema (CBF, Federação, Clube, Laboratório, Regulador)
2. **Atleta**: Atletas cadastrados
3. **Clube**: Clubes de futebol
4. **Federacao**: Federações estaduais e nacional
5. **Competicao**: Competições e campeonatos
6. **TesteAntidoping**: Testes antidoping realizados
7. **Amostra**: Amostras A e B coletadas
8. **Resultado**: Resultados dos testes
9. **Laboratorio**: Laboratórios credenciados
10. **Auditoria**: Log de eventos críticos

### Relacionamentos

```
Atleta -> Clube (N:1)
Atleta -> Federação (N:1)
TesteAntidoping -> Atleta (N:1)
TesteAntidoping -> Competição (N:1)
Amostra -> TesteAntidoping (N:1)
Resultado -> Amostra (1:1)
Resultado -> Laboratório (N:1)
HistoricoClube -> Atleta (N:1)
HistoricoClube -> Clube (N:1)
```

## Segurança

### Autenticação
- **JWT (JSON Web Tokens)**: Tokens stateless para autenticação
- **Validade**: 24 horas (configurável)
- **Refresh Token**: Implementação futura

### Autorização
- **RBAC (Role-Based Access Control)**: Controle de acesso baseado em perfis
- **Perfis**: CBF, FEDERACAO, CLUBE, LABORATORIO, REGULADOR
- **Guards**: Guards do NestJS para proteger rotas

### Auditoria
- **Tabela de Auditoria**: Registro de eventos críticos
- **Eventos auditados**: Criação, atualização, exclusão, registro de resultados
- **Informações auditadas**: Usuário, data, dados antigos/novos

## Escalabilidade

### Estratégias Implementadas

1. **Stateless**: Aplicação sem estado (tokens JWT, sessões no banco)
2. **Cache**: Preparado para Redis (consultas frequentes)
3. **Filas**: Preparado para Bull (processamento assíncrono)
4. **Banco de Dados**: PostgreSQL com índices otimizados
5. **Containerização**: Docker para facilitar deploy

### Próximos Passos

1. **Cache Redis**: Implementar cache para consultas frequentes
2. **Filas Bull**: Implementar processamento assíncrono de relatórios
3. **Read Replicas**: Replicas de leitura para consultas
4. **Load Balancer**: Balanceador de carga para múltiplas instâncias
5. **CDN**: CDN para assets estáticos do frontend

## Desempenho

### Otimizações

1. **Índices no Banco**: Índices em campos frequentemente consultados
2. **Pagininação**: Paginação em todas as listagens
3. **Lazy Loading**: Carregamento sob demanda de relacionamentos
4. **Validação**: Validação de inputs para evitar queries desnecessárias

### Métricas Alvo

- **Tempo de resposta**: < 2 segundos para consultas normais
- **Throughput**: Suportar aumento de carga em épocas de campeonato
- **Disponibilidade**: 99.9% de uptime

## Deployment

### Containerização

- **Docker**: Containerização de backend, frontend e banco
- **Docker Compose**: Orquestração local
- **Multi-stage builds**: Otimização de imagens

### Produção

- **Kubernetes**: Orquestração em produção (futuro)
- **CI/CD**: Pipeline de deploy automatizado (futuro)
- **Monitoring**: Monitoramento e alertas (futuro)

## Evolução Futura

### Microserviços

Se necessário, os módulos podem ser separados em microserviços:

1. **Serviço de Atletas**: CRUD de atletas
2. **Serviço de Antidoping**: Testes e resultados
3. **Serviço de Relatórios**: Geração de relatórios
4. **Serviço de Integração**: APIs externas
5. **API Gateway**: Roteamento e autenticação

### Tecnologias Futuras

1. **GraphQL**: API GraphQL para consultas flexíveis
2. **gRPC**: Comunicação entre serviços
3. **Event Sourcing**: Rastreamento de eventos
4. **CQRS**: Separação de comandos e consultas


