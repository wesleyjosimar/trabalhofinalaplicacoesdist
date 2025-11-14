# 🚀 Guia Completo: Deploy no Render - Passo a Passo

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter:

- ✅ Código no Git (GitHub, GitLab ou Bitbucket)
- ✅ Conta no Render (https://render.com)
- ✅ Acesso ao repositório Git
- ✅ Domínio configurado (opcional, o Render fornece URLs automáticas)

---

## 🎯 PASSO 1: Preparar o Repositório Git

### 1.1. Verificar se o código está no Git

```bash
# Verificar status do Git
git status

# Se não estiver commitado, faça:
git add .
git commit -m "Preparar para deploy no Render"
git push origin main
```

### 1.2. Anotar a URL do Repositório

Anote a URL completa do seu repositório:
- Exemplo GitHub: `https://github.com/seu-usuario/seu-repo.git`
- Exemplo GitLab: `https://gitlab.com/seu-usuario/seu-repo.git`

---

## 🎯 PASSO 2: Acessar o Render

1. Acesse: **https://render.com**
2. Clique em **"Get Started"** ou **"Sign Up"**
3. Faça login com GitHub, GitLab ou email
4. Após login, você será redirecionado para o dashboard

---

## 🎯 PASSO 3: Deploy do PostgreSQL

### 3.1. Criar Banco de Dados

1. No dashboard do Render, clique em **"New +"** no canto superior direito
2. Selecione **"PostgreSQL"**
3. Preencha os campos:

   ```
   Name: cbf-postgres
   Database: cbf_db
   User: cbf_user (ou deixe o padrão)
   Region: (escolha a região mais próxima, ex: São Paulo)
   PostgreSQL Version: 15 (ou latest)
   Plan: Free (para começar) ou Starter ($7/mês)
   ```

4. Clique em **"Create Database"**
5. Aguarde o deploy concluir (1-2 minutos)
6. **⚠️ IMPORTANTE**: Anote as credenciais que aparecem na tela!

### 3.2. Anotar Credenciais do Banco

Na página do banco de dados, você verá:

```
Internal Database URL: postgresql://cbf_user:senha@dpg-xxxxx-a/cbf_db
External Database URL: postgresql://cbf_user:senha@dpg-xxxxx-a.oregon-postgres.render.com/cbf_db
```

**Anote estas informações:**
- **Host**: `dpg-xxxxx-a.oregon-postgres.render.com` (ou similar)
- **Port**: `5432` (geralmente)
- **User**: `cbf_user` (ou o que você definiu)
- **Password**: (a senha gerada)
- **Database**: `cbf_db`

**💡 Dica**: Você pode usar a **Internal Database URL** diretamente no backend (mais seguro) ou extrair os valores individuais.

---

## 🎯 PASSO 4: Deploy do Backend

### 4.1. Criar Web Service (Backend)

1. No dashboard do Render, clique em **"New +"**
2. Selecione **"Web Service"**
3. Conecte seu repositório:
   - Se for a primeira vez, clique em **"Connect account"** e autorize o Render
   - Selecione seu repositório
   - Clique em **"Connect"**

### 4.2. Configurar Backend

Preencha os campos:

```
Name: cbf-backend
Region: (escolha a mesma região do PostgreSQL)
Branch: main (ou master)
Root Directory: backend
Runtime: Node
Build Command: npm install && npm run build
Start Command: npm run start:prod
Instance Type: Free (para começar) ou Starter ($7/mês)
```

**⚠️ IMPORTANTE**: 
- **Root Directory** deve ser `backend` (sem barra no final)
- **Build Command** deve ser exatamente `npm install && npm run build`
- **Start Command** deve ser `npm run start:prod`
- O `@nestjs/cli` está em `dependencies` (não em `devDependencies`) para funcionar no Render

### 4.3. Configurar Variáveis de Ambiente

Role até a seção **"Environment Variables"** e adicione:

```env
DB_HOST=dpg-xxxxx-a.oregon-postgres.render.com
DB_PORT=5432
DB_USER=cbf_user
DB_PASSWORD=[SENHA DO POSTGRES - da página do banco]
DB_NAME=cbf_db
JWT_SECRET=[GERE UMA CHAVE SEGURA - veja abaixo]
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=[DEIXE VAZIO POR ENQUANTO, CONFIGURAREMOS DEPOIS]
```

**💡 Alternativa**: Você pode usar a **Internal Database URL** diretamente:

```env
DATABASE_URL=postgresql://cbf_user:senha@dpg-xxxxx-a/cbf_db
```

E ajustar o código do backend para usar `DATABASE_URL` se preferir.

#### 🔐 Gerar JWT_SECRET

No terminal (PowerShell no Windows), execute:

```powershell
# Windows PowerShell
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 }))
```

Ou use um gerador online: https://generate-secret.vercel.app/32

**⚠️ IMPORTANTE**: 
- `DB_HOST` deve ser o host externo do PostgreSQL (ou use `DATABASE_URL`)
- `DB_PASSWORD` deve ser a senha que aparece na página do banco
- `JWT_SECRET` deve ser uma string aleatória segura (mínimo 32 caracteres)

### 4.4. Configurar Auto-Deploy

Certifique-se de que:
- ✅ **Auto-Deploy** está habilitado (deploy automático a cada push)
- ✅ **Branch** está correto (`main` ou `master`)

### 4.5. Fazer Deploy

1. Clique em **"Create Web Service"**
2. Aguarde o build e deploy (pode levar 5-10 minutos)
3. Verifique os logs para garantir que está funcionando
4. **Anote a URL** do backend (ex: `https://cbf-backend.onrender.com`)
5. Teste o health check:
   - Acesse: `https://[URL-DO-BACKEND]/health`
   - Deve retornar: `{"status":"ok"}`

---

## 🎯 PASSO 5: Deploy do Frontend

### 5.1. Criar Static Site (Frontend)

1. No dashboard do Render, clique em **"New +"**
2. Selecione **"Static Site"**
3. Conecte seu repositório (se ainda não conectou)
4. Selecione o mesmo repositório

### 5.2. Configurar Frontend

Preencha os campos:

```
Name: cbf-frontend
Branch: main (ou master)
Root Directory: frontend
Build Command: npm install && npm run build
Publish Directory: dist
```

**⚠️ IMPORTANTE**: 
- **Root Directory** deve ser `frontend` (sem barra no final)
- **Build Command** deve incluir `npm run build`
- **Publish Directory** deve ser `dist`

### 5.3. Configurar Variáveis de Ambiente

Na seção **"Environment Variables"**, adicione:

```env
VITE_API_URL=https://[URL-DO-BACKEND]
```

**⚠️ IMPORTANTE**: 
- Substitua `[URL-DO-BACKEND]` pela URL real do backend no Render
- Exemplo: `https://cbf-backend.onrender.com`
- **Não inclua barra no final** (`/`)

**💡 Nota**: O Render injeta variáveis de ambiente durante o build. Certifique-se de que o `vite.config.ts` está configurado corretamente.

### 5.4. Fazer Deploy

1. Clique em **"Create Static Site"**
2. Aguarde o build e deploy (pode levar 5-10 minutos)
3. Verifique os logs
4. **Anote a URL** do frontend (ex: `https://cbf-frontend.onrender.com`)
5. Teste a aplicação: `https://[URL-DO-FRONTEND]`

---

## 🎯 PASSO 6: Atualizar Variáveis de Ambiente

Após o deploy do frontend, atualize as variáveis do backend:

1. Vá para o serviço `cbf-backend` no Render
2. Vá em **"Environment"** (aba no topo)
3. Encontre a variável `FRONTEND_URL`
4. Atualize com a URL do frontend:
   ```env
   FRONTEND_URL=https://[URL-DO-FRONTEND]
   ```
5. Clique em **"Save Changes"**
6. O Render fará redeploy automaticamente (ou clique em **"Manual Deploy"**)

---

## 🎯 PASSO 7: Executar Seed (Dados Iniciais)

### 7.1. Via Shell do Render

1. No Render, vá para o serviço `cbf-backend`
2. Clique na aba **"Shell"** (no topo)
3. Execute:

   ```bash
   npm run seed:completo
   ```

4. Aguarde a execução (pode levar alguns segundos)

### 7.2. Verificar Seed

Após executar o seed, você deve ver uma mensagem como:

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

---

## 🎯 PASSO 8: Testar Aplicação

### 8.1. Testar Backend

1. Acesse: `https://[URL-DO-BACKEND]`
   - Deve mostrar informações da API

2. Acesse: `https://[URL-DO-BACKEND]/health`
   - Deve retornar: `{"status":"ok"}`

### 8.2. Testar Frontend

1. Acesse: `https://[URL-DO-FRONTEND]`
   - Deve carregar a aplicação React

2. Faça login:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

3. Teste as funcionalidades:
   - Ver atletas
   - Ver testes antidoping
   - Cadastrar novo atleta
   - Registrar novo teste

---

## 📋 Checklist Completo

### ✅ Antes do Deploy

- [ ] Código no Git (GitHub/GitLab)
- [ ] Dockerfiles criados (opcional para Render)
- [ ] Conta criada no Render
- [ ] JWT_SECRET gerado
- [ ] Senha do banco anotada

### ✅ Durante o Deploy

- [ ] PostgreSQL deployado
- [ ] Credenciais do banco anotadas
- [ ] Backend deployado
- [ ] Frontend deployado
- [ ] Variáveis de ambiente configuradas
- [ ] Build arguments configurados (frontend)
- [ ] URLs anotadas

### ✅ Após o Deploy

- [ ] Seed executado
- [ ] Backend testado (`/health`)
- [ ] Frontend testado
- [ ] Login testado
- [ ] Funcionalidades testadas
- [ ] Logs verificados
- [ ] URLs documentadas

---

## 🔄 Atualizações Futuras

### Deploy Automático (CI/CD)

O Render faz deploy automático por padrão quando você faz push para a branch configurada:

```bash
git add .
git commit -m "Atualização"
git push origin main
```

O Render detecta automaticamente e faz rebuild e redeploy.

### Deploy Manual

1. No Render, vá para o serviço
2. Clique em **"Manual Deploy"**
3. Selecione a branch
4. Clique em **"Deploy"**

---

## 🐛 Troubleshooting

### Problema: Backend não conecta ao banco

**Solução**:
1. Verifique se está usando o **Internal Database URL** (mais seguro) ou o host externo
2. Verifique credenciais (usuário, senha, banco)
3. Verifique logs do backend no Render
4. Verifique se o PostgreSQL está rodando
5. **Dica**: Use a variável `DATABASE_URL` completa em vez de variáveis individuais

### Problema: Frontend não carrega ou não conecta ao backend

**Solução**:
1. Verifique se o backend está acessível
2. Verifique `VITE_API_URL` (deve ser a URL completa do backend)
3. Verifique CORS no backend
4. Verifique logs do frontend no Render
5. Verifique build do frontend (verifique se `VITE_API_URL` foi usado no build)
6. **Dica**: Limpe o cache do navegador (Ctrl+Shift+R)

### Problema: Build falha com "nest: not found" ou "could not determine executable"

**Erro**: `sh: 1: nest: not found` ou `npm error could not determine executable to run`

**Solução**:
1. ✅ **Já corrigido**: O `@nestjs/cli` foi movido para `dependencies` no `package.json`
2. Faça commit e push das alterações:
   ```bash
   git add backend/package.json
   git commit -m "Fix: mover @nestjs/cli para dependencies para Render"
   git push origin main
   ```
3. O Render fará redeploy automaticamente
4. **Verifique**: O Build Command no Render deve ser:
   ```
   npm install && npm run build
   ```
   (O Render instala todas as dependências, incluindo `@nestjs/cli` que agora está em `dependencies`)

### Problema: Build falha (outros erros)

**Solução**:
1. Verifique logs do build no Render
2. Verifique se o **Root Directory** está correto
3. Verifique se os comandos de build estão corretos
4. Verifique dependências no `package.json`
5. Verifique se há erros de TypeScript/compilação

### Problema: Erro 404 no backend

**Solução**:
1. Verifique se a aplicação está rodando (status no dashboard)
2. Verifique logs
3. Verifique porta (deve ser 3001 ou a porta configurada)
4. Verifique health check: `/health`
5. Verifique se o domínio está correto

### Problema: Seed não executa

**Solução**:
1. Verifique se o banco está acessível
2. Verifique credenciais do banco
3. Verifique logs do seed no shell
4. Verifique se o backend está rodando
5. Tente executar manualmente via shell

### Problema: Aplicação "dorme" no plano Free

**Solução**:
- No plano Free, o Render "dorme" após 15 minutos de inatividade
- A primeira requisição após dormir pode levar 30-60 segundos
- Para evitar isso, use o plano Starter ($7/mês) ou configure um ping automático

---

## 💰 Planos e Custos

### Plano Free (Gratuito)
- ✅ Backend: 512 MB RAM, dorme após 15 min
- ✅ Frontend: Ilimitado
- ✅ PostgreSQL: 90 dias grátis, depois $7/mês
- ⚠️ Limitação: Aplicação "dorme" após inatividade

### Plano Starter ($7/mês por serviço)
- ✅ Backend: 512 MB RAM, sempre ativo
- ✅ Frontend: Sempre ativo
- ✅ PostgreSQL: $7/mês
- ✅ Sem limitações de "dormir"

**💡 Recomendação**: Comece com Free para testar, depois migre para Starter quando precisar de produção.

---

## 🔒 Segurança

### 1. Variáveis Secretas

No Render, todas as variáveis de ambiente são automaticamente secretas. Não aparecem nos logs.

### 2. HTTPS/SSL

O Render fornece SSL/HTTPS automaticamente para todos os serviços. Não precisa configurar nada.

### 3. Internal vs External URLs

- **Internal Database URL**: Mais seguro, só funciona dentro da rede do Render
- **External Database URL**: Funciona de qualquer lugar, mas menos seguro

**Recomendação**: Use Internal Database URL quando possível.

---

## 📊 Monitoramento

### Logs

1. No Render, vá para o serviço
2. Clique na aba **"Logs"**
3. Veja logs em tempo real

### Métricas

No plano Starter, você tem acesso a métricas básicas:
- CPU
- Memória
- Requisições

---

## 🎯 URLs Após Deploy

- **Frontend**: `https://cbf-frontend.onrender.com` (ou domínio customizado)
- **Backend**: `https://cbf-backend.onrender.com` (ou domínio customizado)
- **Health Check**: `https://cbf-backend.onrender.com/health`
- **API**: `https://cbf-backend.onrender.com/api`

---

## 🌐 Domínio Customizado (Opcional)

### Configurar Domínio Próprio

1. No Render, vá para o serviço
2. Vá em **"Settings"**
3. Role até **"Custom Domains"**
4. Adicione seu domínio
5. Configure DNS conforme instruções do Render
6. SSL será configurado automaticamente

---

## 📚 Recursos Adicionais

- [Render Documentation](https://render.com/docs)
- [Render Community](https://community.render.com)
- [Node.js on Render](https://render.com/docs/node)
- [PostgreSQL on Render](https://render.com/docs/databases)

---

## 🆘 Precisa de Ajuda?

Se tiver problemas:

1. **Verifique logs** no Render
2. **Verifique variáveis de ambiente**
3. **Verifique documentação** do Render
4. **Contate suporte** do Render (disponível no dashboard)

---

## 🎉 Pronto!

Sua aplicação estará rodando no Render! 

**Dica**: Siga a ordem recomendada (PostgreSQL → Backend → Frontend) para evitar problemas de conectividade.

---

## 🔄 Comparação: Render vs Coolify

| Característica | Render | Coolify |
|----------------|--------|---------|
| **Facilidade** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Custo Free** | ✅ Sim | ✅ Sim |
| **Auto-Deploy** | ✅ Automático | ✅ Automático |
| **PostgreSQL** | ✅ Gerenciado | ✅ Gerenciado |
| **SSL** | ✅ Automático | ✅ Automático |
| **Dormir (Free)** | ⚠️ Sim (15 min) | ❌ Não |
| **Controle** | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |

**Recomendação**: 
- Use **Render** se quer simplicidade máxima
- Use **Coolify** se quer mais controle e não quer que a aplicação "durma"

