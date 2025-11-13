# Guia de Acesso à Aplicação CBF

## 🚀 Acessar a Aplicação

### 1. Verificar se os serviços estão rodando

```powershell
docker compose ps
```

ou

```powershell
docker ps
```

Você deve ver 3 containers rodando:
- `cbf-postgres` (PostgreSQL)
- `cbf-backend` (Backend NestJS)
- `cbf-frontend` (Frontend React)

### 2. Acessar o Frontend

Abra seu navegador e acesse:

**http://localhost:3000**

### 3. Fazer Login

**Usuário de teste:**
- **Email**: `admin@cbf.com.br`
- **Senha**: `admin123`
- **Perfil**: CBF

### 4. Acessar o Backend (API)

A API REST está disponível em:

**http://localhost:3001**

**Endpoints principais:**
- `POST /auth/login` - Login
- `GET /atletas` - Listar atletas
- `GET /antidoping/testes` - Listar testes
- etc.

## 📋 Pré-requisitos antes de acessar

### 1. Iniciar os serviços Docker

Se os serviços não estiverem rodando:

```powershell
cd C:\trabalhofinalaplicacoesdist
docker compose up -d
```

### 2. Aguardar os serviços iniciarem

Aguarde alguns segundos para que todos os serviços iniciem completamente:

```powershell
# Ver logs para verificar quando está pronto
docker compose logs -f
```

Pressione `Ctrl+C` para sair dos logs.

### 3. Criar dados iniciais (Seed)

**IMPORTANTE:** Antes de fazer login, você precisa criar os dados iniciais (usuários, federações, etc.).

#### Opção A: Executar seed via Docker

```powershell
# Executar o script de seed dentro do container do backend
docker compose exec backend npm run seed
```

#### Opção B: Executar seed localmente

```powershell
cd backend
npm install
npm run seed
```

## 🔍 Verificar se tudo está funcionando

### 1. Verificar se o PostgreSQL está rodando

```powershell
docker compose logs postgres
```

Você deve ver mensagens como: "database system is ready to accept connections"

### 2. Verificar se o Backend está rodando

```powershell
docker compose logs backend
```

Você deve ver: "Application is running on: http://localhost:3001"

### 3. Verificar se o Frontend está rodando

```powershell
docker compose logs frontend
```

Você deve ver mensagens do Vite indicando que o servidor está rodando.

### 4. Testar a API diretamente

Abra o navegador ou use o Postman/Insomnia para testar:

```
POST http://localhost:3001/auth/login
Content-Type: application/json

{
  "email": "admin@cbf.com.br",
  "senha": "admin123"
}
```

## 🐛 Troubleshooting

### Problema: Frontend não carrega (erro de conexão)

**Solução:**
1. Verifique se o backend está rodando:
   ```powershell
   docker compose logs backend
   ```
2. Verifique se há erros no backend
3. Aguarde alguns segundos e recarregue a página

### Problema: Erro 401 (Não autorizado) no login

**Solução:**
1. Certifique-se de que executou o seed:
   ```powershell
   docker compose exec backend npm run seed
   ```
2. Verifique se o usuário foi criado corretamente
3. Verifique os logs do backend para ver erros

### Problema: Erro de conexão com banco de dados

**Solução:**
1. Verifique se o PostgreSQL está rodando:
   ```powershell
   docker compose ps
   ```
2. Verifique os logs do PostgreSQL:
   ```powershell
   docker compose logs postgres
   ```
3. Reinicie os serviços:
   ```powershell
   docker compose restart
   ```

### Problema: Porta já em uso

**Solução:**
1. Verifique qual processo está usando a porta:
   ```powershell
   netstat -ano | findstr :3000
   netstat -ano | findstr :3001
   netstat -ano | findstr :5432
   ```
2. Pare o processo ou mude as portas no `docker-compose.yml`

## 📱 Usar a Aplicação

### 1. Dashboard
Após fazer login, você verá o dashboard com:
- Resumo de atletas cadastrados
- Resumo de testes realizados
- Últimos atletas cadastrados
- Últimos testes antidoping

### 2. Gestão de Atletas
- **Listar atletas**: Clique em "Atletas" no menu
- **Cadastrar atleta**: Clique em "Novo Atleta"
- **Ver detalhes**: Clique em "Ver Detalhes" em um atleta

### 3. Gestão de Testes Antidoping
- **Listar testes**: Clique em "Testes Antidoping" no menu
- **Registrar teste**: Clique em "Novo Teste"
- **Adicionar amostra**: Acesse os detalhes do teste e clique em "Adicionar Amostra"

## 🔐 Usuários de Teste

Após executar o seed, os seguintes usuários estarão disponíveis:

1. **Administrador CBF**
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`
   - Perfil: CBF
   - Permissões: Todas (cadastrar atletas, testes, etc.)

2. **Laboratório**
   - Email: `lab@teste.com.br`
   - Senha: `lab123`
   - Perfil: LABORATORIO
   - Permissões: Registrar resultados de testes

## 📊 Próximos Passos

1. **Cadastrar Atletas**: Use o menu "Atletas" para cadastrar novos atletas
2. **Registrar Testes**: Use o menu "Testes Antidoping" para registrar novos testes
3. **Adicionar Amostras**: Acesse os detalhes de um teste para adicionar amostras A e B
4. **Registrar Resultados**: (Como laboratório) Registre os resultados dos testes

## 🆘 Ajuda

Se tiver problemas:

1. Verifique os logs:
   ```powershell
   docker compose logs -f
   ```
2. Verifique o status dos containers:
   ```powershell
   docker compose ps
   ```
3. Reinicie os serviços:
   ```powershell
   docker compose restart
   ```
4. Reconstrua as imagens:
   ```powershell
   docker compose build
   docker compose up -d
   ```

