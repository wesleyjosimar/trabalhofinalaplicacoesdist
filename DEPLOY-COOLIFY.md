# 🚀 Deploy no Coolify - Sistema CBF

## 📋 O que é Coolify?

Coolify é uma plataforma de self-hosting open-source que permite fazer deploy de aplicações Docker de forma simples, similar ao Heroku ou Railway, mas você pode hospedar em seu próprio servidor ou usar o serviço hospedado deles.

## 🎯 Pré-requisitos

1. Conta no Coolify: https://coolify.brdrive.net
2. Repositório Git (GitHub, GitLab, etc.)
3. Código da aplicação no repositório

## 🚀 Passo a Passo - Deploy no Coolify

### 1. Preparar o Repositório

Certifique-se de que seu código está no GitHub/GitLab:

```bash
# Se ainda não está no Git
git init
git add .
git commit -m "Initial commit"
git remote add origin <seu-repositorio>
git push -u origin main
```

### 2. Criar Aplicação no Coolify

#### 2.1. Acessar Coolify

1. Acesse: https://coolify.brdrive.net
2. Faça login ou crie uma conta
3. Crie um novo projeto

#### 2.2. Deploy do Backend

1. **Clique em "New Resource"** ou "Nova Aplicação"
2. **Selecione "Docker Compose"** ou "Dockerfile"
3. **Configure**:
   - **Nome**: `cbf-backend`
   - **Repositório Git**: URL do seu repositório
   - **Branch**: `main` ou `master`
   - **Dockerfile Path**: `backend/Dockerfile.prod`
   - **Porta**: `3001`
   - **Build Command**: (deixar vazio, Coolify faz automaticamente)
   - **Start Command**: (deixar vazio)

4. **Variáveis de Ambiente**:
   ```
   DB_HOST=postgres
   DB_PORT=5432
   DB_USER=postgres
   DB_PASSWORD=sua-senha-segura
   DB_NAME=cbf_db
   JWT_SECRET=sua-chave-jwt-super-segura
   JWT_EXPIRES_IN=24h
   PORT=3001
   NODE_ENV=production
   FRONTEND_URL=https://seu-frontend-url.com
   ```

5. **Clique em "Deploy"**

#### 2.3. Deploy do Frontend

1. **Clique em "New Resource"**
2. **Selecione "Docker Compose"** ou "Dockerfile"
3. **Configure**:
   - **Nome**: `cbf-frontend`
   - **Repositório Git**: URL do seu repositório
   - **Branch**: `main` ou `master`
   - **Dockerfile Path**: `frontend/Dockerfile.prod`
   - **Porta**: `80`
   - **Build Args**:
     ```
     VITE_API_URL=https://seu-backend-url.com
     ```

4. **Variáveis de Ambiente**:
   ```
   VITE_API_URL=https://seu-backend-url.com
   ```

5. **Clique em "Deploy"**

#### 2.4. Adicionar Banco de Dados PostgreSQL

1. **Clique em "New Resource"**
2. **Selecione "Database" → "PostgreSQL"**
3. **Configure**:
   - **Nome**: `cbf-postgres`
   - **Versão**: `15` ou `latest`
   - **Senha**: Gere uma senha segura
   - **Banco de Dados**: `cbf_db`

4. **Variáveis de Ambiente** (serão criadas automaticamente):
   ```
   POSTGRES_USER=postgres
   POSTGRES_PASSWORD=sua-senha
   POSTGRES_DB=cbf_db
   ```

5. **Conectar ao Backend**:
   - No backend, use as variáveis de ambiente do PostgreSQL
   - Coolify cria automaticamente uma rede Docker interna
   - Use o nome do serviço como host: `cbf-postgres`

### 3. Configurar Docker Compose (Opção Alternativa)

Se o Coolify suportar Docker Compose, você pode usar o arquivo `docker-compose.prod.yml`:

#### 3.1. Criar Aplicação Docker Compose

1. **Clique em "New Resource"**
2. **Selecione "Docker Compose"**
3. **Configure**:
   - **Nome**: `cbf-app`
   - **Repositório Git**: URL do seu repositório
   - **Docker Compose File**: `docker-compose.prod.yml`
   - **Variáveis de Ambiente**: Adicione todas as variáveis necessárias

4. **Clique em "Deploy"**

### 4. Configurar Variáveis de Ambiente

No Coolify, configure as seguintes variáveis de ambiente:

#### Backend

```env
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=${POSTGRES_PASSWORD}
DB_NAME=cbf_db
JWT_SECRET=${JWT_SECRET}
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=${FRONTEND_URL}
```

#### Frontend

```env
VITE_API_URL=${BACKEND_URL}
```

### 5. Configurar Domínios

#### 5.1. Backend

1. No Coolify, vá para a aplicação `cbf-backend`
2. Vá em "Settings" ou "Configurações"
3. Adicione um domínio: `api.seudominio.com`
4. Coolify configura SSL automaticamente

#### 5.2. Frontend

1. No Coolify, vá para a aplicação `cbf-frontend`
2. Vá em "Settings" ou "Configurações"
3. Adicione um domínio: `seudominio.com`
4. Coolify configura SSL automaticamente

### 6. Executar Seed (Dados Iniciais)

#### Opção 1: Via Terminal do Coolify

1. No Coolify, vá para a aplicação `cbf-backend`
2. Clique em "Terminal" ou "Console"
3. Execute:
   ```bash
   npm run seed:completo
   ```

#### Opção 2: Via SSH (se disponível)

```bash
ssh usuario@coolify.brdrive.net
cd /path/to/cbf-backend
npm run seed:completo
```

### 7. Verificar Deploy

1. **Backend**: Acesse `https://api.seudominio.com/health`
   - Deve retornar: `{"status":"ok"}`

2. **Frontend**: Acesse `https://seudominio.com`
   - Deve carregar a aplicação React

3. **Teste Login**:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

## 📋 Arquivos Necessários

### 1. Dockerfile.prod (Backend)

Já criado em `backend/Dockerfile.prod`

### 2. Dockerfile.prod (Frontend)

Já criado em `frontend/Dockerfile.prod`

### 3. docker-compose.prod.yml

Já criado na raiz do projeto

### 4. nginx.conf (Frontend)

Já criado em `frontend/nginx.conf`

## 🔧 Configuração Específica para Coolify

### Opção 1: Deploy Separado (Recomendado)

Deploy cada serviço separadamente:
- Backend como aplicação Docker
- Frontend como aplicação Docker
- PostgreSQL como banco de dados gerenciado

### Opção 2: Docker Compose

Use o arquivo `docker-compose.prod.yml` se o Coolify suportar.

## 🔒 Segurança

### 1. Variáveis de Ambiente

No Coolify, configure as variáveis de ambiente como **secrets**:
- `JWT_SECRET`: Gere uma string aleatória segura
- `DB_PASSWORD`: Senha forte
- Outras credenciais sensíveis

### 2. SSL/HTTPS

Coolify configura SSL automaticamente com Let's Encrypt.

### 3. Firewall

Configure o firewall do Coolify para permitir apenas:
- Porta 80 (HTTP)
- Porta 443 (HTTPS)
- Porta do backend (se exposta)

## 📊 Monitoramento

### 1. Logs

No Coolify, você pode ver logs em tempo real:
- Vá para a aplicação
- Clique em "Logs"
- Veja logs em tempo real

### 2. Métricas

Coolify fornece métricas básicas:
- CPU
- Memória
- Rede
- Disco

## 🔄 Atualizações

### Deploy Automático (CI/CD)

1. **Configure Webhook no Coolify**:
   - Vá para a aplicação
   - Copie a URL do webhook
   - Configure no GitHub/GitLab

2. **Push para o repositório**:
   ```bash
   git push origin main
   ```
   - Coolify detecta automaticamente
   - Faz rebuild e redeploy

### Deploy Manual

1. No Coolify, vá para a aplicação
2. Clique em "Redeploy" ou "Deploy"
3. Aguarde o build e deploy

## 🐛 Troubleshooting

### Problema: Build falha

**Solução**:
1. Verifique os logs no Coolify
2. Verifique o Dockerfile
3. Verifique variáveis de ambiente
4. Verifique dependências no `package.json`

### Problema: Aplicação não inicia

**Solução**:
1. Verifique logs no Coolify
2. Verifique variáveis de ambiente
3. Verifique conectividade com banco de dados
4. Verifique portas

### Problema: Banco de dados não conecta

**Solução**:
1. Verifique nome do serviço (use `cbf-postgres` como host)
2. Verifique credenciais
3. Verifique se o banco está rodando
4. Verifique rede Docker interna

### Problema: Frontend não carrega

**Solução**:
1. Verifique se o backend está acessível
2. Verifique `VITE_API_URL`
3. Verifique CORS no backend
4. Verifique logs do frontend

## 📝 Checklist de Deploy

### Antes do Deploy

- [ ] Código no Git (GitHub/GitLab)
- [ ] Dockerfiles criados (`Dockerfile.prod`)
- [ ] Variáveis de ambiente documentadas
- [ ] JWT_SECRET gerado
- [ ] Senha do banco definida

### Durante o Deploy

- [ ] Conta criada no Coolify
- [ ] Projeto criado
- [ ] Backend deployado
- [ ] Frontend deployado
- [ ] PostgreSQL criado
- [ ] Variáveis de ambiente configuradas
- [ ] Domínios configurados
- [ ] SSL configurado

### Após o Deploy

- [ ] Seed executado
- [ ] Backend testado (`/health`)
- [ ] Frontend testado
- [ ] Login testado
- [ ] Funcionalidades testadas
- [ ] Logs verificados

## 🎯 Configuração Recomendada

### Estrutura no Coolify

```
Projeto: CBF
├── Backend (cbf-backend)
│   ├── Dockerfile: backend/Dockerfile.prod
│   ├── Porta: 3001
│   └── Domínio: api.seudominio.com
├── Frontend (cbf-frontend)
│   ├── Dockerfile: frontend/Dockerfile.prod
│   ├── Porta: 80
│   └── Domínio: seudominio.com
└── PostgreSQL (cbf-postgres)
    ├── Versão: 15
    └── Banco: cbf_db
```

## 🔗 URLs após Deploy

- **Frontend**: `https://seudominio.com`
- **Backend**: `https://api.seudominio.com`
- **Health Check**: `https://api.seudominio.com/health`
- **API Docs**: `https://api.seudominio.com` (se configurado)

## 📚 Recursos Adicionais

- [Coolify Documentation](https://coolify.io/docs)
- [Docker Documentation](https://docs.docker.com)
- [NestJS Deployment](https://docs.nestjs.com/faq/serverless)

## 🆘 Ajuda

Se tiver problemas:

1. **Verifique os logs** no Coolify
2. **Verifique variáveis de ambiente**
3. **Verifique conectividade** entre serviços
4. **Verifique documentação** do Coolify
5. **Contate suporte** do Coolify se necessário

## 🎉 Próximos Passos

1. ✅ Fazer deploy no Coolify
2. ✅ Configurar domínios
3. ✅ Executar seed
4. ✅ Testar aplicação
5. ✅ Configurar monitoramento (opcional)
6. ✅ Configurar backups (opcional)
7. ✅ Configurar CI/CD (opcional)

---

**Dica**: Coolify é uma excelente opção para self-hosting. Siga este guia passo a passo para fazer deploy com sucesso!


