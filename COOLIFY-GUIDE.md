# 🚀 Guia Completo - Deploy no Coolify

## 📋 Visão Geral

Coolify é uma plataforma de self-hosting que facilita o deploy de aplicações Docker. Este guia mostra como fazer deploy do Sistema CBF no Coolify.

## 🎯 Opções de Deploy no Coolify

### Opção 1: Deploy Separado (Recomendado)

Deploy cada serviço separadamente:
- ✅ Mais controle
- ✅ Escalabilidade independente
- ✅ Mais fácil de gerenciar

### Opção 2: Docker Compose

Deploy tudo junto com Docker Compose:
- ✅ Mais rápido
- ✅ Configuração única
- ✅ Menos flexível

## 🚀 Passo a Passo - Opção 1: Deploy Separado

### 1. Preparar Repositório

Certifique-se de que seu código está no Git:

```bash
git add .
git commit -m "Preparar para deploy no Coolify"
git push origin main
```

### 2. Criar Projeto no Coolify

1. Acesse: https://coolify.brdrive.net
2. Faça login
3. Crie um novo projeto: **CBF**

### 3. Deploy do PostgreSQL

#### 3.1. Criar Banco de Dados

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Database" → "PostgreSQL"**
3. Configure:
   - **Name**: `cbf-postgres`
   - **Version**: `15` ou `latest`
   - **Database Name**: `cbf_db`
   - **User**: `postgres`
   - **Password**: Gere uma senha segura (salve para usar no backend)

4. Clique em **"Deploy"**

#### 3.2. Obter Credenciais

Após o deploy, anote:
- **Host**: `cbf-postgres` (nome do serviço)
- **Port**: `5432`
- **User**: `postgres`
- **Password**: (a senha que você definiu)
- **Database**: `cbf_db`

### 4. Deploy do Backend

#### 4.1. Criar Aplicação Backend

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Dockerfile"** ou **"Docker Compose"**
3. Configure:
   - **Name**: `cbf-backend`
   - **Repository**: URL do seu repositório Git
   - **Branch**: `main`
   - **Dockerfile Path**: `backend/Dockerfile.prod`
   - **Build Context**: `backend`
   - **Port**: `3001`

#### 4.2. Configurar Variáveis de Ambiente

No Coolify, adicione as seguintes variáveis de ambiente:

```env
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=sua-senha-do-postgres
DB_NAME=cbf_db
JWT_SECRET=sua-chave-jwt-super-segura-aqui
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

**Importante**: 
- `DB_HOST` deve ser o nome do serviço PostgreSQL (`cbf-postgres`)
- `JWT_SECRET` deve ser uma string aleatória segura (gere com `openssl rand -base64 32`)
- `FRONTEND_URL` será a URL do frontend após deploy

#### 4.3. Configurar Domínio

1. Vá em **"Settings"** da aplicação backend
2. Adicione domínio: `api.seudominio.com`
3. Coolify configura SSL automaticamente

#### 4.4. Deploy

1. Clique em **"Deploy"**
2. Aguarde o build e deploy
3. Verifique logs para garantir que está funcionando

### 5. Deploy do Frontend

#### 5.1. Criar Aplicação Frontend

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Dockerfile"**
3. Configure:
   - **Name**: `cbf-frontend`
   - **Repository**: URL do seu repositório Git
   - **Branch**: `main`
   - **Dockerfile Path**: `frontend/Dockerfile.prod`
   - **Build Context**: `frontend`
   - **Port**: `80`

#### 5.2. Configurar Build Args

No Coolify, adicione build arguments:

```env
VITE_API_URL=https://api.seudominio.com
```

#### 5.3. Configurar Variáveis de Ambiente

```env
VITE_API_URL=https://api.seudominio.com
```

#### 5.4. Configurar Domínio

1. Vá em **"Settings"** da aplicação frontend
2. Adicione domínio: `seudominio.com`
3. Coolify configura SSL automaticamente

#### 5.5. Deploy

1. Clique em **"Deploy"**
2. Aguarde o build e deploy
3. Verifique logs

### 6. Executar Seed

#### 6.1. Via Terminal do Coolify

1. No Coolify, vá para a aplicação `cbf-backend`
2. Clique em **"Terminal"** ou **"Console"**
3. Execute:
   ```bash
   npm run seed:completo
   ```

#### 6.2. Verificar

Após executar o seed, você deve ver:
```
✅ Seed concluído com sucesso!
📊 Resumo:
   - Federações: 2
   - Clubes: 6
   - Laboratórios: 3
   - Usuários: 3
   - Competições: 2
   - Atletas: 5
   - Testes: 4
   - Amostras: 8
   - Resultados: 2
```

## 🚀 Passo a Passo - Opção 2: Docker Compose

### 1. Criar Aplicação Docker Compose

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Docker Compose"**
3. Configure:
   - **Name**: `cbf-app`
   - **Repository**: URL do seu repositório Git
   - **Branch**: `main`
   - **Docker Compose File**: `coolify-docker-compose.yml`

### 2. Configurar Variáveis de Ambiente

No Coolify, adicione todas as variáveis:

```env
POSTGRES_USER=postgres
POSTGRES_PASSWORD=sua-senha-segura
POSTGRES_DB=cbf_db
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
VITE_API_URL=https://api.seudominio.com
```

### 3. Deploy

1. Clique em **"Deploy"**
2. Aguarde o build e deploy de todos os serviços
3. Verifique logs

### 4. Configurar Domínios

Configure domínios para cada serviço:
- Backend: `api.seudominio.com`
- Frontend: `seudominio.com`

## 🔧 Configuração de Rede

No Coolify, os serviços Docker Compose ficam na mesma rede por padrão. Use o nome do serviço como host:

- **PostgreSQL**: `cbf-postgres` ou `postgres` (no Docker Compose)
- **Backend**: `cbf-backend` ou `backend` (no Docker Compose)
- **Frontend**: `cbf-frontend` ou `frontend` (no Docker Compose)

## 🔒 Segurança

### 1. Variáveis de Ambiente

No Coolify, marque variáveis sensíveis como **"Secret"**:
- `JWT_SECRET`
- `DB_PASSWORD`
- `POSTGRES_PASSWORD`

### 2. SSL/HTTPS

Coolify configura SSL automaticamente com Let's Encrypt quando você adiciona um domínio.

### 3. Firewall

Configure o firewall do Coolify para permitir apenas portas necessárias.

## 📊 Monitoramento

### 1. Logs

No Coolify, você pode ver logs em tempo real:
- Vá para a aplicação
- Clique em **"Logs"**
- Veja logs em tempo real

### 2. Métricas

Coolify fornece métricas básicas:
- CPU
- Memória
- Rede
- Disco

## 🔄 Atualizações

### Deploy Automático

1. **Configure Webhook no Coolify**:
   - Vá para a aplicação
   - Copie a URL do webhook
   - Configure no GitHub (Settings → Webhooks)

2. **Push para o repositório**:
   ```bash
   git push origin main
   ```
   - Coolify detecta automaticamente
   - Faz rebuild e redeploy

### Deploy Manual

1. No Coolify, vá para a aplicação
2. Clique em **"Redeploy"** ou **"Deploy"**
3. Aguarde o build e deploy

## 🐛 Troubleshooting

### Problema: Backend não conecta ao banco

**Solução**:
1. Verifique se o nome do serviço está correto (`cbf-postgres`)
2. Verifique se estão na mesma rede Docker
3. Verifique credenciais
4. Verifique logs do PostgreSQL

### Problema: Frontend não carrega

**Solução**:
1. Verifique se o backend está acessível
2. Verifique `VITE_API_URL`
3. Verifique CORS no backend
4. Verifique logs do frontend

### Problema: Build falha

**Solução**:
1. Verifique logs do build
2. Verifique Dockerfile
3. Verifique variáveis de ambiente
4. Verifique dependências

## 📋 Checklist

### Antes do Deploy

- [ ] Código no Git
- [ ] Dockerfiles criados
- [ ] Variáveis de ambiente documentadas
- [ ] JWT_SECRET gerado
- [ ] Senha do banco definida

### Durante o Deploy

- [ ] Conta criada no Coolify
- [ ] Projeto criado
- [ ] PostgreSQL deployado
- [ ] Backend deployado
- [ ] Frontend deployado
- [ ] Variáveis configuradas
- [ ] Domínios configurados

### Após o Deploy

- [ ] Seed executado
- [ ] Backend testado (`/health`)
- [ ] Frontend testado
- [ ] Login testado
- [ ] Funcionalidades testadas

## 🎯 URLs Após Deploy

- **Frontend**: `https://seudominio.com`
- **Backend**: `https://api.seudominio.com`
- **Health Check**: `https://api.seudominio.com/health`
- **API**: `https://api.seudominio.com/api`

## 📚 Recursos

- [Coolify Documentation](https://coolify.io/docs)
- [Docker Documentation](https://docs.docker.com)
- [NestJS Deployment](https://docs.nestjs.com/faq/serverless)

## 🆘 Ajuda

Se tiver problemas:

1. Verifique logs no Coolify
2. Verifique variáveis de ambiente
3. Verifique conectividade entre serviços
4. Verifique documentação do Coolify
5. Contate suporte do Coolify

## 🎉 Pronto!

Sua aplicação estará rodando no Coolify em poucos minutos!

---

**Dica**: Use a Opção 1 (Deploy Separado) para mais controle e flexibilidade.


