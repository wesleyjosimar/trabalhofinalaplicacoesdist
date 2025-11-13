# ⚙️ Configuração Específica para Coolify

## 📋 Checklist de Configuração

### 1. Variáveis de Ambiente - Backend

Configure estas variáveis no Coolify para o serviço `cbf-backend`:

```env
# Banco de Dados
DB_HOST=cbf-postgres
DB_PORT=5432
DB_USER=postgres
DB_PASSWORD=${POSTGRES_PASSWORD}
DB_NAME=cbf_db

# JWT
JWT_SECRET=${JWT_SECRET}
JWT_EXPIRES_IN=24h

# Aplicação
PORT=3001
NODE_ENV=production
FRONTEND_URL=${FRONTEND_URL}
```

### 2. Variáveis de Ambiente - Frontend

Configure estas variáveis no Coolify para o serviço `cbf-frontend`:

```env
# API
VITE_API_URL=${BACKEND_URL}
```

### 3. Build Arguments - Frontend

Configure estes build arguments no Coolify para o serviço `cbf-frontend`:

```env
VITE_API_URL=${BACKEND_URL}
```

## 🔧 Configuração de Serviços

### Backend

- **Nome**: `cbf-backend`
- **Tipo**: Dockerfile
- **Dockerfile Path**: `backend/Dockerfile.prod`
- **Build Context**: `backend`
- **Porta**: `3001`
- **Comando de Início**: (deixar vazio, Dockerfile define)
- **Comando de Build**: (deixar vazio, Dockerfile define)

### Frontend

- **Nome**: `cbf-frontend`
- **Tipo**: Dockerfile
- **Dockerfile Path**: `frontend/Dockerfile.prod`
- **Build Context**: `frontend`
- **Porta**: `80`
- **Comando de Início**: (deixar vazio, Dockerfile define)
- **Comando de Build**: (deixar vazio, Dockerfile define)

### PostgreSQL

- **Nome**: `cbf-postgres`
- **Tipo**: Database → PostgreSQL
- **Versão**: `15`
- **Banco de Dados**: `cbf_db`
- **Usuário**: `postgres`
- **Senha**: (gerar senha segura)

## 🌐 Configuração de Domínios

### Backend

- **Domínio**: `api.seudominio.com` (ou domínio fornecido pelo Coolify)
- **SSL**: Automático (Let's Encrypt)

### Frontend

- **Domínio**: `seudominio.com` (ou domínio fornecido pelo Coolify)
- **SSL**: Automático (Let's Encrypt)

## 🔗 Conectividade entre Serviços

No Coolify, os serviços Docker Compose ficam na mesma rede por padrão. Use o nome do serviço como host:

- **Backend → PostgreSQL**: `cbf-postgres:5432`
- **Frontend → Backend**: `cbf-backend:3001` (via proxy Nginx)

## 📊 Ordem de Deploy

1. **PostgreSQL** (primeiro)
2. **Backend** (segundo)
3. **Frontend** (terceiro)

## 🔒 Segurança

### Variáveis Secretas

No Coolify, marque estas variáveis como **"Secret"**:

- `JWT_SECRET`
- `DB_PASSWORD`
- `POSTGRES_PASSWORD`

### Gerar JWT_SECRET

```bash
openssl rand -base64 32
```

Use o resultado como `JWT_SECRET`.

## 🔄 Atualizações

### Deploy Automático

1. Configure webhook no Coolify
2. Configure webhook no GitHub
3. Push para `main` → Deploy automático

### Deploy Manual

1. No Coolify, vá para a aplicação
2. Clique em "Redeploy"
3. Aguarde build e deploy

## 📝 Notas Importantes

1. **Nome dos Serviços**: Use os nomes exatos (`cbf-postgres`, `cbf-backend`, `cbf-frontend`)
2. **Rede Docker**: Coolify cria rede interna automaticamente
3. **Variáveis de Ambiente**: Use `${VARIAVEL}` para referenciar outras variáveis
4. **Build Args**: Frontend precisa de `VITE_API_URL` como build arg
5. **SSL**: Coolify configura SSL automaticamente com Let's Encrypt

## 🆘 Troubleshooting

### Problema: Serviços não se comunicam

**Solução**:
1. Verifique se estão no mesmo projeto
2. Verifique nomes dos serviços
3. Verifique rede Docker
4. Verifique logs

### Problema: Build falha

**Solução**:
1. Verifique Dockerfile
2. Verifique build context
3. Verifique variáveis de ambiente
4. Verifique logs do build

### Problema: Aplicação não inicia

**Solução**:
1. Verifique logs
2. Verifique variáveis de ambiente
3. Verifique conectividade com banco
4. Verifique porta

## 🎯 Próximos Passos

1. ✅ Configurar serviços no Coolify
2. ✅ Configurar variáveis de ambiente
3. ✅ Fazer deploy
4. ✅ Executar seed
5. ✅ Testar aplicação


