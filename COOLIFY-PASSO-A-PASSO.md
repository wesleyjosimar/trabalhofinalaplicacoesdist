# 🚀 Deploy no Coolify - Passo a Passo Completo

## 📋 Pré-requisitos

✅ Código no Git (GitHub/GitLab)  
✅ Conta no Coolify: https://coolify.brdrive.net  
✅ Dockerfiles criados (`Dockerfile.prod`)

## 🎯 Passo a Passo Detalhado

### Passo 1: Acessar Coolify

1. Acesse: **https://coolify.brdrive.net**
2. Faça login ou crie uma conta
3. Crie um novo **Projeto**: `CBF`

### Passo 2: Deploy do PostgreSQL

#### 2.1. Criar Banco de Dados

1. No Coolify, clique em **"New Resource"** ou **"Nova Aplicação"**
2. Selecione **"Database" → "PostgreSQL"**
3. Preencha:
   - **Name**: `cbf-postgres`
   - **Version**: `15` ou `latest`
   - **Database Name**: `cbf_db`
   - **User**: `postgres`
   - **Password**: Gere uma senha segura (ex: `Senh@Segur@123!`)

4. Clique em **"Deploy"**
5. Aguarde o deploy concluir (1-2 minutos)
6. **Anote as credenciais**:
   - Host: `cbf-postgres`
   - Port: `5432`
   - User: `postgres`
   - Password: (a senha que você definiu)
   - Database: `cbf_db`

### Passo 3: Deploy do Backend

#### 3.1. Criar Aplicação Backend

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Dockerfile"** ou **"Docker Compose"**
3. Preencha:
   - **Name**: `cbf-backend`
   - **Repository**: URL do seu repositório Git
     - Exemplo: `https://github.com/seu-usuario/seu-repo.git`
   - **Branch**: `main` ou `master`
   - **Dockerfile Path**: `backend/Dockerfile.prod`
   - **Build Context**: `backend`
   - **Port**: `3001`

#### 3.2. Configurar Variáveis de Ambiente

No Coolify, vá em **"Environment Variables"** e adicione:

```env
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=Senh@Segur@123!
DB_NAME=cbf_db
JWT_SECRET=gerar-string-aleatoria-segura-aqui
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

**⚠️ IMPORTANTE**:
- `DB_HOST` deve ser exatamente `cbf-postgres` (nome do serviço PostgreSQL)
- `DB_PASSWORD` deve ser a senha que você definiu no PostgreSQL
- `JWT_SECRET` deve ser uma string aleatória segura (gere com: `openssl rand -base64 32`)
- `FRONTEND_URL` será a URL do frontend (configure após deploy do frontend)

#### 3.3. Configurar Domínio (Opcional)

1. Vá em **"Settings"** da aplicação backend
2. Em **"Domains"**, adicione: `api.seudominio.com`
3. Coolify configura SSL automaticamente com Let's Encrypt
4. **Anote a URL** do backend (será usada no frontend)

#### 3.4. Deploy

1. Clique em **"Deploy"** ou **"Save & Deploy"**
2. Aguarde o build e deploy (pode levar 5-10 minutos)
3. Verifique os logs para garantir que está funcionando
4. Teste o health check: `https://api.seudominio.com/health`
   - Deve retornar: `{"status":"ok"}`

### Passo 4: Deploy do Frontend

#### 4.1. Criar Aplicação Frontend

1. No Coolify, clique em **"New Resource"**
2. Selecione **"Dockerfile"**
3. Preencha:
   - **Name**: `cbf-frontend`
   - **Repository**: URL do seu repositório Git (mesmo repositório)
   - **Branch**: `main` ou `master`
   - **Dockerfile Path**: `frontend/Dockerfile.prod`
   - **Build Context**: `frontend`
   - **Port**: `80`

#### 4.2. Configurar Build Arguments

No Coolify, vá em **"Build Arguments"** e adicione:

```env
VITE_API_URL=https://api.seudominio.com
```

**⚠️ IMPORTANTE**: Substitua `https://api.seudominio.com` pela URL real do backend no Coolify.

#### 4.3. Configurar Variáveis de Ambiente

No Coolify, vá em **"Environment Variables"** e adicione:

```env
VITE_API_URL=https://api.seudominio.com
```

#### 4.4. Configurar Domínio (Opcional)

1. Vá em **"Settings"** da aplicação frontend
2. Em **"Domains"**, adicione: `seudominio.com`
3. Coolify configura SSL automaticamente
4. **Anote a URL** do frontend

#### 4.5. Deploy

1. Clique em **"Deploy"** ou **"Save & Deploy"**
2. Aguarde o build e deploy (pode levar 5-10 minutos)
3. Verifique os logs
4. Teste a aplicação: `https://seudominio.com`

### Passo 5: Atualizar Variáveis de Ambiente

Após deploy do frontend, atualize as variáveis do backend:

1. Vá para a aplicação `cbf-backend`
2. Vá em **"Settings" → "Environment Variables"**
3. Atualize `FRONTEND_URL` com a URL do frontend
4. Clique em **"Redeploy"** para aplicar as mudanças

### Passo 6: Executar Seed (Dados Iniciais)

#### 6.1. Via Terminal do Coolify

1. No Coolify, vá para a aplicação `cbf-backend`
2. Clique em **"Terminal"** ou **"Console"**
3. Execute:
   ```bash
   npm run seed:completo
   ```

#### 6.2. Via SSH (se disponível)

```bash
ssh usuario@coolify.brdrive.net
cd /path/to/cbf-backend
npm run seed:completo
```

#### 6.3. Verificar

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

### Passo 7: Testar Aplicação

#### 7.1. Testar Backend

1. Acesse: `https://api.seudominio.com`
   - Deve mostrar informações da API

2. Acesse: `https://api.seudominio.com/health`
   - Deve retornar: `{"status":"ok"}`

#### 7.2. Testar Frontend

1. Acesse: `https://seudominio.com`
   - Deve carregar a aplicação React

2. Faça login:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

3. Teste as funcionalidades:
   - Ver atletas
   - Ver testes antidoping
   - Cadastrar novo atleta
   - Registrar novo teste

## 🔧 Configuração Detalhada

### Variáveis de Ambiente - Backend

```env
# Banco de Dados
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=sua-senha-segura
DB_NAME=cbf_db

# JWT
JWT_SECRET=sua-chave-jwt-super-segura
JWT_EXPIRES_IN=24h

# Aplicação
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

### Variáveis de Ambiente - Frontend

```env
VITE_API_URL=https://api.seudominio.com
```

### Build Arguments - Frontend

```env
VITE_API_URL=https://api.seudominio.com
```

## 🔒 Segurança

### 1. Gerar JWT_SECRET

No terminal, execute:

```bash
openssl rand -base64 32
```

Use o resultado como `JWT_SECRET`.

### 2. Senha do Banco

Use uma senha forte:
- Mínimo 12 caracteres
- Inclua letras, números e símbolos
- Exemplo: `Senh@Segur@123!`

### 3. Variáveis Secretas

No Coolify, marque variáveis sensíveis como **"Secret"**:
- `JWT_SECRET`
- `DB_PASSWORD`
- `POSTGRES_PASSWORD`

## 🔗 Conectividade entre Serviços

No Coolify, os serviços ficam na mesma rede Docker. Use o nome do serviço como host:

- **Backend → PostgreSQL**: `cbf-postgres:5432`
- **Frontend → Backend**: Via proxy Nginx (configurado no `nginx.conf`)

## 📊 Ordem de Deploy Recomendada

1. ✅ **PostgreSQL** (primeiro)
2. ✅ **Backend** (segundo)
3. ✅ **Frontend** (terceiro)
4. ✅ **Atualizar variáveis** (quarto)
5. ✅ **Executar seed** (quinto)
6. ✅ **Testar aplicação** (sexto)

## 🐛 Troubleshooting

### Problema: Backend não conecta ao banco

**Solução**:
1. Verifique se o nome do serviço está correto (`cbf-postgres`)
2. Verifique se estão no mesmo projeto no Coolify
3. Verifique credenciais (usuário, senha, banco)
4. Verifique logs do PostgreSQL e do backend
5. Verifique se o PostgreSQL está rodando

### Problema: Frontend não carrega

**Solução**:
1. Verifique se o backend está acessível
2. Verifique `VITE_API_URL` (deve ser a URL do backend)
3. Verifique CORS no backend
4. Verifique logs do frontend
5. Verifique build do frontend (verifique se `VITE_API_URL` foi usado no build)

### Problema: Build falha

**Solução**:
1. Verifique logs do build no Coolify
2. Verifique Dockerfile
3. Verifique variáveis de ambiente
4. Verifique dependências no `package.json`
5. Verifique build context

### Problema: Erro 404 no backend

**Solução**:
1. Verifique se a aplicação está rodando
2. Verifique logs
3. Verifique porta
4. Verifique health check: `/health`
5. Verifique domínio

### Problema: Seed não executa

**Solução**:
1. Verifique se o banco está acessível
2. Verifique credenciais do banco
3. Verifique logs do seed
4. Verifique se o backend está rodando
5. Tente executar manualmente via terminal

## 📋 Checklist Completo

### Antes do Deploy

- [ ] Código no Git (GitHub/GitLab)
- [ ] Dockerfiles criados (`Dockerfile.prod`)
- [ ] Variáveis de ambiente documentadas
- [ ] JWT_SECRET gerado
- [ ] Senha do banco definida
- [ ] Conta criada no Coolify

### Durante o Deploy

- [ ] Projeto criado no Coolify
- [ ] PostgreSQL deployado
- [ ] Backend deployado
- [ ] Frontend deployado
- [ ] Variáveis de ambiente configuradas
- [ ] Build arguments configurados (frontend)
- [ ] Domínios configurados (opcional)
- [ ] SSL configurado (automático)

### Após o Deploy

- [ ] Seed executado
- [ ] Backend testado (`/health`)
- [ ] Frontend testado
- [ ] Login testado
- [ ] Funcionalidades testadas
- [ ] Logs verificados
- [ ] URLs documentadas

## 🎯 URLs Após Deploy

- **Frontend**: `https://seudominio.com` (ou URL do Coolify)
- **Backend**: `https://api.seudominio.com` (ou URL do Coolify)
- **Health Check**: `https://api.seudominio.com/health`
- **API**: `https://api.seudominio.com/api`

## 🔄 Atualizações

### Deploy Automático (CI/CD)

1. **Configure Webhook no Coolify**:
   - Vá para a aplicação
   - Copie a URL do webhook
   - Configure no GitHub (Settings → Webhooks → Add webhook)

2. **Push para o repositório**:
   ```bash
   git push origin main
   ```
   - Coolify detecta automaticamente
   - Faz rebuild e redeploy

### Deploy Manual

1. No Coolify, vá para a aplicação
2. Clique em **"Redeploy"** ou **"Deploy"**
3. Aguarde build e deploy

## 📚 Recursos Adicionais

- [Coolify Documentation](https://coolify.io/docs)
- [Docker Documentation](https://docs.docker.com)
- [NestJS Deployment](https://docs.nestjs.com/faq/serverless)

## 🆘 Ajuda

Se tiver problemas:

1. **Verifique logs** no Coolify
2. **Verifique variáveis de ambiente**
3. **Verifique conectividade** entre serviços
4. **Verifique documentação** do Coolify
5. **Contate suporte** do Coolify se necessário

## 🎉 Pronto!

Sua aplicação estará rodando no Coolify em poucos minutos!

---

**Dica**: Siga a ordem recomendada (PostgreSQL → Backend → Frontend) para evitar problemas de conectividade.


