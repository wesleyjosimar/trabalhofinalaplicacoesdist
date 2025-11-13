# 🚀 Deploy Rápido no Coolify - Sistema CBF

## 📋 Passo a Passo Simplificado

### 1. Preparar Repositório

Certifique-se de que seu código está no Git:

```bash
git add .
git commit -m "Preparar para deploy no Coolify"
git push origin main
```

### 2. Acessar Coolify

1. Acesse: **https://coolify.brdrive.net**
2. Faça login ou crie uma conta
3. Crie um novo **Projeto**: `CBF`

### 3. Deploy do PostgreSQL

#### 3.1. Criar Banco de Dados

1. Clique em **"New Resource"** ou **"Nova Aplicação"**
2. Selecione **"Database" → "PostgreSQL"**
3. Configure:
   - **Name**: `cbf-postgres`
   - **Version**: `15`
   - **Database Name**: `cbf_db`
   - **User**: `postgres`
   - **Password**: Gere uma senha segura (ex: `Senh@Segur@123!`)

4. Clique em **"Deploy"**
5. Aguarde o deploy concluir
6. **Anote as credenciais** (host, porta, usuário, senha, banco)

### 4. Deploy do Backend

#### 4.1. Criar Aplicação Backend

1. Clique em **"New Resource"**
2. Selecione **"Dockerfile"** ou **"Docker Compose"**
3. Configure:
   - **Name**: `cbf-backend`
   - **Repository**: URL do seu repositório Git (ex: `https://github.com/seu-usuario/seu-repo.git`)
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
DB_PASSWORD=Senh@Segur@123!
DB_NAME=cbf_db
JWT_SECRET=gerar-string-aleatoria-segura-aqui-minimo-32-caracteres
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-frontend-url.com
```

**⚠️ IMPORTANTE**:
- `DB_HOST` deve ser o nome do serviço PostgreSQL (`cbf-postgres`)
- `JWT_SECRET` deve ser uma string aleatória segura (gere com: `openssl rand -base64 32`)
- `FRONTEND_URL` será a URL do frontend (configure após deploy do frontend)

#### 4.3. Configurar Domínio (Opcional)

1. Vá em **"Settings"** da aplicação backend
2. Adicione domínio: `api.seudominio.com` (ou use o domínio fornecido pelo Coolify)
3. Coolify configura SSL automaticamente

#### 4.4. Deploy

1. Clique em **"Deploy"**
2. Aguarde o build e deploy (pode levar alguns minutos)
3. Verifique logs para garantir que está funcionando
4. **Anote a URL do backend** (será usada no frontend)

### 5. Deploy do Frontend

#### 5.1. Criar Aplicação Frontend

1. Clique em **"New Resource"**
2. Selecione **"Dockerfile"**
3. Configure:
   - **Name**: `cbf-frontend`
   - **Repository**: URL do seu repositório Git (mesmo repositório)
   - **Branch**: `main`
   - **Dockerfile Path**: `frontend/Dockerfile.prod`
   - **Build Context**: `frontend`
   - **Port**: `80`

#### 5.2. Configurar Build Arguments

No Coolify, adicione build arguments:

```env
VITE_API_URL=https://api.seudominio.com
```

**⚠️ IMPORTANTE**: Substitua `https://api.seudominio.com` pela URL real do backend no Coolify.

#### 5.3. Configurar Variáveis de Ambiente

```env
VITE_API_URL=https://api.seudominio.com
```

#### 5.4. Configurar Domínio (Opcional)

1. Vá em **"Settings"** da aplicação frontend
2. Adicione domínio: `seudominio.com` (ou use o domínio fornecido pelo Coolify)
3. Coolify configura SSL automaticamente

#### 5.5. Deploy

1. Clique em **"Deploy"**
2. Aguarde o build e deploy
3. Verifique logs

### 6. Atualizar Variáveis de Ambiente

Após deploy do frontend, atualize as variáveis do backend:

1. Vá para a aplicação `cbf-backend`
2. Vá em **"Settings" → "Environment Variables"**
3. Atualize `FRONTEND_URL` com a URL do frontend
4. Clique em **"Redeploy"** para aplicar as mudanças

### 7. Executar Seed (Dados Iniciais)

#### 7.1. Via Terminal do Coolify

1. No Coolify, vá para a aplicação `cbf-backend`
2. Clique em **"Terminal"** ou **"Console"**
3. Execute:
   ```bash
   npm run seed:completo
   ```

#### 7.2. Verificar

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

### 8. Testar Aplicação

#### 8.1. Testar Backend

1. Acesse a URL do backend: `https://api.seudominio.com`
2. Acesse o health check: `https://api.seudominio.com/health`
3. Deve retornar: `{"status":"ok"}`

#### 8.2. Testar Frontend

1. Acesse a URL do frontend: `https://seudominio.com`
2. Deve carregar a aplicação React
3. Faça login:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

## 📋 Variáveis de Ambiente - Resumo

### Backend

```env
DB_HOST=cbf-postgres
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

### Frontend

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

### 3. Variáveis Sensíveis

No Coolify, marque variáveis sensíveis como **"Secret"**:
- `JWT_SECRET`
- `DB_PASSWORD`
- `POSTGRES_PASSWORD`

## 🔧 Configuração de Rede

No Coolify, os serviços Docker Compose ficam na mesma rede por padrão. Use o nome do serviço como host:

- **PostgreSQL**: `cbf-postgres` (nome do serviço)
- **Backend**: `cbf-backend` (nome do serviço)
- **Frontend**: `cbf-frontend` (nome do serviço)

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
3. Aguarde o build e deploy

## 🐛 Troubleshooting

### Problema: Backend não conecta ao banco

**Solução**:
1. Verifique se o nome do serviço está correto (`cbf-postgres`)
2. Verifique se estão no mesmo projeto no Coolify
3. Verifique credenciais
4. Verifique logs do PostgreSQL e do backend

### Problema: Frontend não carrega

**Solução**:
1. Verifique se o backend está acessível
2. Verifique `VITE_API_URL` (deve ser a URL do backend)
3. Verifique CORS no backend
4. Verifique logs do frontend

### Problema: Build falha

**Solução**:
1. Verifique logs do build no Coolify
2. Verifique Dockerfile
3. Verifique variáveis de ambiente
4. Verifique dependências no `package.json`

### Problema: Erro 404 no backend

**Solução**:
1. Verifique se a aplicação está rodando
2. Verifique logs
3. Verifique porta
4. Verifique health check: `/health`

## 📋 Checklist

### Antes do Deploy

- [ ] Código no Git
- [ ] Dockerfiles criados (`Dockerfile.prod`)
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
- [ ] Domínios configurados (opcional)

### Após o Deploy

- [ ] Seed executado
- [ ] Backend testado (`/health`)
- [ ] Frontend testado
- [ ] Login testado
- [ ] Funcionalidades testadas
- [ ] Logs verificados

## 🎯 URLs Após Deploy

- **Frontend**: `https://seudominio.com` (ou URL do Coolify)
- **Backend**: `https://api.seudominio.com` (ou URL do Coolify)
- **Health Check**: `https://api.seudominio.com/health`
- **API**: `https://api.seudominio.com/api`

## 🎉 Pronto!

Sua aplicação estará rodando no Coolify em poucos minutos!

---

**Dica**: Comece com deploy separado (PostgreSQL → Backend → Frontend) para mais controle e fácil troubleshooting.


